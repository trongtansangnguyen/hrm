<?php
namespace App\Http\Controllers\Management;

use App\Enums\JobPositionStatus;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobbatchController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'department_id', 'status', 'per_page']);

        $query = JobPosition::query()
            ->with(['department', 'candidates'])
            ->latest();

        if (!empty($filters['search'])) {
            $search = trim((string) $filters['search']);
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        if (!empty($filters['department_id'])) {
            $query->where('department_id', (int) $filters['department_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', (int) $filters['status']);
        }

        $perPage = (int) ($filters['per_page'] ?? 10);
        if ($perPage <= 0) {
            $perPage = 10;
        }

        $jobs = $query->paginate($perPage)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('management.jobbatch.index', compact('jobs', 'departments', 'filters'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('management.jobbatch.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255|unique:job_positions,title',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
            'status' => [
                'nullable',
                'integer',
                Rule::in([JobPositionStatus::OPEN->value, JobPositionStatus::CLOSED->value]),
            ],
        ]);

        $data['status'] = $data['status'] ?? JobPositionStatus::OPEN->value;

        JobPosition::create($data);

        return redirect()
            ->route('management.jobbatch.index')
            ->with('success', 'Thêm thành công!');
    }

    public function show($id)
    {
        $job = JobPosition::with(['department', 'candidates'])->findOrFail($id);

        return view('management.jobbatch.show', compact('job'));
    }

    public function edit($id)
    {
        $job = JobPosition::findOrFail($id);
        $departments = Department::orderBy('name')->get();

        return view('management.jobbatch.edit', compact('job', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $job = JobPosition::findOrFail($id);

        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('job_positions', 'title')->ignore($id),
            ],
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
            'status' => [
                'nullable',
                'integer',
                Rule::in([JobPositionStatus::OPEN->value, JobPositionStatus::CLOSED->value]),
            ],
        ]);

        $data['status'] = $data['status'] ?? JobPositionStatus::OPEN->value;
        $job->update($data);

        return redirect()
            ->route('management.jobbatch.index')
            ->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $job = JobPosition::withCount('candidates')->findOrFail($id);

        if ($job->candidates_count > 0) {
            return back()->with('error', 'Không thể xóa vị trí đã có ứng viên. Vui lòng chuyển trạng thái sang Đóng.');
        }

        $job->delete();

        return back()->with('success', 'Đã xóa vị trí tuyển dụng!');
    }
}