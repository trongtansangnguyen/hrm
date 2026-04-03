<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
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

        $candidate->update(['status' => $request->status]);

        return back()->with('success', 'Cập nhật trạng thái ứng viên thành công!');
    }
}