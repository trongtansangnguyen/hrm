<?php

namespace App\Http\Controllers;

use App\Enums\LeaveRequestStatus;
use App\Models\Leave;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $user = Auth::user();

        $employee = $user?->employee?->load('department');

        $leaveRequests = $employee
            ? Leave::where('employee_id', $employee->id)->latest()->get()
            : collect();

        $canCreateLeaveRequest = !empty($employee?->id);

        return view('employee-leaves', compact('employee', 'leaveRequests', 'canCreateLeaveRequest'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $employee = $user?->employee;

        if (!$employee?->id) {
            return back()->with('error', 'Tài khoản chưa liên kết hồ sơ nhân viên.');
        }

        $validated = $request->validate([
            'from_date' => ['required', 'date', 'after_or_equal:today'],
            'to_date' => ['required', 'date', 'after_or_equal:from_date'],
            'reason' => ['required', 'string', 'max:500'],
        ], [
            'from_date.required' => 'Vui lòng chọn ngày bắt đầu.',
            'from_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',
            'to_date.required' => 'Vui lòng chọn ngày kết thúc.',
            'to_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
            'reason.required' => 'Vui lòng nhập lý do nghỉ phép.',
            'reason.max' => 'Lý do nghỉ phép tối đa 500 ký tự.',
        ]);

        $hasOverlap = Leave::query()
            ->where('employee_id', $employee->id)
            ->whereIn('status', [LeaveRequestStatus::PENDING, LeaveRequestStatus::APPROVED])
            ->whereDate('from_date', '<=', $validated['to_date'])
            ->whereDate('to_date', '>=', $validated['from_date'])
            ->exists();

        if ($hasOverlap) {
            return back()->withInput()->with('error', 'Đơn nghỉ bị trùng thời gian với đơn đã gửi/đã duyệt.');
        }

        Leave::create([
            'employee_id' => $employee->id,
            'from_date' => $validated['from_date'],
            'to_date' => $validated['to_date'],
            'reason' => $validated['reason'],
            'status' => LeaveRequestStatus::PENDING,
        ]);
        $this->dashboardService->clearLeaveCache();

        return redirect()
            ->route('employee-leaves.index')
            ->with('success', 'Đã gửi đơn nghỉ phép thành công.');
    }

    public function destroy(Leave $leave)
    {
        $employeeId = Auth::user()?->employee?->id;

        if (!$employeeId || $leave->employee_id !== $employeeId) {
            abort(403);
        }

        if ($leave->status !== LeaveRequestStatus::PENDING) {
            return back()->with('warning', 'Chỉ có thể hủy đơn đang chờ duyệt.');
        }

        $leave->delete();
        $this->dashboardService->clearLeaveCache();

        return back()->with('success', 'Đã hủy đơn nghỉ phép.');
    }
}