<?php

namespace App\Repositories;

use App\Repositories\Core\RepositoryAbstract;
use App\Models\Leave;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LeaveRequestStatus;

class LeaveRepository extends RepositoryAbstract
{
    /**
     * Get the model instance
     */
    protected function getModel(): Model
    {
        return new Leave();
    }

    public function summary()
    {
        return [
            'total_leave_requests_today' => $this->countAllLeaveRequestsToday(),
            'total_approved_leave_requests' => $this->countAllApprovedLeaveRequests(),
            'total_approved_leave_requests_this_month' => $this->countAllApprovedLeaveRequestsThisMonth(),
        ];
    }

    /**
     * Get count of all leave requests today
     */
    public function countAllLeaveRequestsToday(): int
    {
        return $this->newQuery()
            ->whereDate('from_date', '<=', now()->toDateString())
            ->whereDate('to_date', '>=', now()->toDateString())
            ->count();
    }

    /**
     * Get count of all approved leave requests
     */
    public function countAllApprovedLeaveRequests(): int
    {
        return $this->newQuery()
            ->where('status', LeaveRequestStatus::APPROVED)
            ->count();
    }

    /**
     * Get count of all approved leave requests this month
     */
    public function countAllApprovedLeaveRequestsThisMonth(): int
    {
        return $this->newQuery()
            ->where('status', LeaveRequestStatus::APPROVED)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
    }
}
