<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        // Lấy danh sách ứng viên và phân trang
        $candidates = Candidate::latest()->paginate(10);
        return view('management.candidates.index', compact('candidates'));
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