<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobPosition; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicCandidateController extends Controller
{
    public function create()
    {
        // Lấy danh sách vị trí để ứng viên chọn
        $positions = JobPosition::all(); 
        return view('public.candidates.apply', compact('positions'));
    }

    public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'job_position_id' => 'required',
        'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
    ]);

    // Tách Họ và Tên từ chuỗi full_name
    $nameParts = explode(' ', $request->full_name);
    $lastName = array_shift($nameParts); // Lấy chữ đầu tiên làm Họ (Last Name)
    $firstName = implode(' ', $nameParts); // Phần còn lại là Tên (First Name)

    // Nếu người dùng chỉ nhập 1 chữ, gán tạm vào First Name
    if (empty($firstName)) {
        $firstName = $lastName;
        $lastName = '';
    }

    $data = [
        'first_name'      => $firstName,
        'last_name'       => $lastName,
        'email'           => $request->email,
        'phone'           => $request->phone,
        'job_position_id' => $request->job_position_id,
        'cv_path'         => $request->hasFile('cv') ? $request->file('cv')->store('cvs', 'public') : 'Không có',
        'status'          => '1', // Theo hình phpMyAdmin của bạn, status đang dùng kiểu số
    ];

    \App\Models\Candidate::create($data);

    return redirect()->back()->with('success', 'Hồ sơ của bạn đã được gửi thành công!');
}
}