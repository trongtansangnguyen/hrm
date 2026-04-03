<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Department;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'department_id', 'status', 'per_page']);

        $query = Candidate::query()
            ->with(['jobPosition.department'])
            ->latest();

        if (!empty($filters['search'])) {
            $search = trim((string) $filters['search']);

            $query->where(function ($candidateQuery) use ($search) {
                $candidateQuery
                    ->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhereHas('jobPosition', function ($jobQuery) use ($search) {
                        $jobQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['department_id'])) {
            $query->whereHas('jobPosition', function ($jobQuery) use ($filters) {
                $jobQuery->where('department_id', (int) $filters['department_id']);
            });
        }

        if (!empty($filters['status'])) {
            $statusMap = [
                'applied' => 1,
                'interview' => 2,
                'hired' => 3,
                'rejected' => 4,
            ];

            if (isset($statusMap[$filters['status']])) {
                $query->where('status', $statusMap[$filters['status']]);
            }
        }

        $perPage = (int) ($filters['per_page'] ?? 10);
        if ($perPage <= 0) {
            $perPage = 10;
        }

        $candidates = $query->paginate($perPage)->withQueryString();
        $departments = Department::query()->orderBy('name')->get();

        return view('management.candidates.index', compact('candidates', 'departments', 'filters'));
    }

    public function show(Candidate $candidate)
    {
        return view('management.candidates.show', compact('candidate'));
    }

    public function updateStatus(Request $request, Candidate $candidate)
{
    $request->validate([
        'status' => 'required|in:applied,interview,hired,rejected'
    ]);

    // Ánh xạ chữ sang số để lưu vào DB (Khớp với logic hiển thị của bạn)
    $statusMap = [
        'applied'   => 1, // Mới nhận
        'interview' => 2, // Phỏng vấn
        'hired'     => 3, // Tuyển dụng
        'rejected'  => 4  // Loại
    ];

    $candidate->update([
        'status' => $statusMap[$request->status]
    ]);
    $this->dashboardService->clearCandidateCache();

    return back()->with('success', 'Cập nhật trạng thái ứng viên thành công!');
}
}