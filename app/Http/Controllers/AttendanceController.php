<?php

namespace App\Http\Controllers;

use App\Enums\AttendanceStatus;
use App\Enums\EmployeeStatus;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = $user?->employee?->load('department');

        $todayAttendance = null;
        $attendances = collect();

        if ($employee?->id) {
            $todayAttendance = Attendance::query()
                ->where('employee_id', $employee->id)
                ->whereDate('date', Carbon::today())
                ->latest('id')
                ->first();

            $attendances = Attendance::query()
                ->where('employee_id', $employee->id)
                ->latest('date')
                ->latest('id')
                ->paginate(10);
        }

        $canCheckIn = (bool) $employee?->id && (!$todayAttendance || !$todayAttendance->check_in);
        $canCheckOut = (bool) $employee?->id && $todayAttendance?->check_in && !$todayAttendance?->check_out;

        return view('employee-attendances', compact('employee', 'todayAttendance', 'attendances', 'canCheckIn', 'canCheckOut'));
    }

    public function checkIn()
    {
        $employee = Auth::user()?->employee;

        if (!$employee?->id) {
            return back()->with('error', 'Tài khoản chưa liên kết hồ sơ nhân viên.');
        }

        $today = Carbon::today();
        $now = now();

        $attendance = Attendance::query()
            ->where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->latest('id')
            ->first();

        if ($attendance?->check_in) {
            return back()->with('warning', 'Bạn đã check-in hôm nay.');
        }

        $status = $this->resolveCheckInStatus($now);

        if ($attendance) {
            $attendance->update([
                'check_in' => $now,
                'status' => $status,
            ]);
        } else {
            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $today,
                'check_in' => $now,
                'status' => $status,
                'working_hours' => 0,
            ]);
        }

        $employee->update([
            'status' => EmployeeStatus::ON_DUTY,
        ]);

        return redirect()
            ->route('employee-attendances.index')
            ->with('success', 'Check-in thành công. Chúc bạn một ngày làm việc hiệu quả!');
    }

    public function checkOut()
    {
        $employee = Auth::user()?->employee;

        if (!$employee?->id) {
            return back()->with('error', 'Tài khoản chưa liên kết hồ sơ nhân viên.');
        }

        $attendance = Attendance::query()
            ->where('employee_id', $employee->id)
            ->whereDate('date', Carbon::today())
            ->latest('id')
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return back()->with('error', 'Bạn chưa check-in, không thể check-out.');
        }

        if ($attendance->check_out) {
            return back()->with('warning', 'Bạn đã check-out hôm nay.');
        }

        $checkOutAt = now();

        if ($checkOutAt->lessThanOrEqualTo($attendance->check_in)) {
            return back()->with('error', 'Thời gian check-out không hợp lệ.');
        }

        $workingMinutes = $attendance->check_in->diffInMinutes($checkOutAt);
        $workingHours = round($workingMinutes / 60, 2);

        $attendance->update([
            'check_out' => $checkOutAt,
            'working_hours' => $workingHours,
        ]);

        $employee->update([
            'status' => EmployeeStatus::WORKING,
        ]);

        return redirect()
            ->route('employee-attendances.index')
            ->with('success', 'Check-out thành công. Tổng giờ làm hôm nay: ' . number_format($workingHours, 2) . ' giờ.');
    }

    private function resolveCheckInStatus(Carbon $checkInTime): AttendanceStatus
    {
        $standardStartTime = (string) config('attendance.standard_start_time', '08:30');
        $lateAfterMinutes = (int) config('attendance.late_after_minutes', 0);

        if (!preg_match('/^\d{2}:\d{2}$/', $standardStartTime)) {
            $standardStartTime = '08:30';
        }

        $deadline = Carbon::today()->setTimeFromTimeString($standardStartTime)->addMinutes(max(0, $lateAfterMinutes));

        return $checkInTime->greaterThan($deadline)
            ? AttendanceStatus::LATE
            : AttendanceStatus::ON_TIME;
    }
}
