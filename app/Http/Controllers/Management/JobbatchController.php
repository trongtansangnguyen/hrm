<?php
namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobbatchController extends Controller
{
    // 1. LIẾT KÊ (Index)
    public function index()
    {
        // Eager load 'department' để tránh lỗi RelationNotFound
        $jobs = JobPosition::with('department')->latest()->get();
        return view('management.jobbatch.index', compact('jobs'));
    }

    // 2. GIAO DIỆN THÊM (Create)
    public function create()
    {
        $departments = Department::all();
        return view('management.jobbatch.create', compact('departments'));
    }

    // 3. LƯU MỚI (Store)
    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255|unique:job_positions,title',
        'department_id' => 'required|exists:departments,id',
        'description' => 'nullable',
        'status' => 'nullable|integer',
    ]);

    $data['status'] = $data['status'] ?? 1; 

    \App\Models\JobPosition::create($data);
    return redirect()->route('management.jobbatch.index')->with('success', 'Thêm thành công!');
}

    // 4. GIAO DIỆN SỬA (Edit)
    public function edit($id)
    {
        $job = JobPosition::findOrFail($id);
        $departments = Department::all();
        return view('management.jobbatch.edit', compact('job', 'departments'));
    }

    // 5. CẬP NHẬT (Update)
public function update(Request $request, $id)
{
    $job = JobPosition::findOrFail($id);

    $data = $request->validate([
        'title' => [
            'required',
            'string',
            'max:255',
            Rule::unique('job_positions', 'title')->ignore($id)
        ],
        'department_id' => 'required|exists:departments,id',
        'description' => 'nullable',
        'status' => 'nullable|integer',
    ]);

        $job->title = $request->title;
        $job->department_id = $request->department_id;
        $job->status = trim($request->status ?? 1);
        $job->save();

    return redirect()->route('management.jobbatch.index')
        ->with('success', 'Cập nhật thành công!');
}

    // 6. XÓA (Destroy)
    public function destroy($id)
    {
        $job = JobPosition::findOrFail($id);
        $job->delete(); // Sẽ là Soft Delete nếu bạn đã setup trong Model
        return back()->with('success', 'Đã xóa vị trí tuyển dụng!');
    }
}