<?php

namespace App\Http\Controllers\Management;

use App\Enums\LeaveRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'from_date', 'to_date']);

        $query = Leave::query()->with(['employee.department', 'approver']);

        if (!empty($filters['search'])) {
            $search = trim((string) $filters['search']);

            $query->whereHas('employee', function ($employeeQuery) use ($search) {
                $employeeQuery
                    ->where('employee_code', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$search}%"]);
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', (int) $filters['status']);
        }

        if (!empty($filters['from_date'])) {
            $query->whereDate('from_date', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('to_date', '<=', $filters['to_date']);
        }

        $leaveRequests = $query->latest()->paginate(15)->withQueryString();

        $summary = [
            'active_today' => Leave::query()
                ->whereDate('from_date', '<=', now()->toDateString())
                ->whereDate('to_date', '>=', now()->toDateString())
                ->where('status', LeaveRequestStatus::APPROVED)
                ->count(),
            'approved' => Leave::query()->where('status', LeaveRequestStatus::APPROVED)->count(),
            'pending' => Leave::query()->where('status', LeaveRequestStatus::PENDING)->count(),
            'rejected' => Leave::query()->where('status', LeaveRequestStatus::REJECTED)->count(),
        ];

        return view('management.leaves.index', compact('leaveRequests', 'summary', 'filters'));
    }

    public function approve(Leave $leave)
    {
        if ($leave->status !== LeaveRequestStatus::PENDING) {
            return back()->with('warning', 'Chỉ có thể duyệt đơn đang chờ duyệt.');
        }

        $leave->update([
            'status' => LeaveRequestStatus::APPROVED,
            'approved_by' => Auth::id(),
        ]);
        $this->dashboardService->clearLeaveCache();

        return back()->with('success', 'Đã duyệt đơn nghỉ phép.');
    }

    public function reject(Leave $leave)
    {
        if ($leave->status !== LeaveRequestStatus::PENDING) {
            return back()->with('warning', 'Chỉ có thể từ chối đơn đang chờ duyệt.');
        }

        $leave->update([
            'status' => LeaveRequestStatus::REJECTED,
            'approved_by' => Auth::id(),
        ]);
        $this->dashboardService->clearLeaveCache();

        return back()->with('success', 'Đã từ chối đơn nghỉ phép.');
    }
}
