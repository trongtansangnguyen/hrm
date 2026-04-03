<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allowance;

class AllowanceController extends Controller
{
    public function index()
    {
        $allowances = Allowance::latest()->get();
        return view('management.allowances.index', compact('allowances'));
    }

    // Trang tạo mới
    public function create()
    {
        return view('management.allowances.create');
    }

    // Lưu loại phụ cấp mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        Allowance::create($request->all());

        return redirect()->route('management.allowances.index')
                         ->with('success', 'Đã thêm loại phụ cấp mới thành công!');
    }

    // Trang chỉnh sửa
    public function edit(Allowance $allowance)
    {
        return view('management.allowances.edit', compact('allowance'));
    }

    // Cập nhật dữ liệu
    public function update(Request $request, Allowance $allowance)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $allowance->update($request->all());

        return redirect()->route('management.allowances.index')
                         ->with('success', 'Cập nhật loại phụ cấp thành công!');
    }

    // Xóa
    public function destroy(Allowance $allowance)
    {
        $allowance->delete();
        return redirect()->route('management.allowances.index')
                         ->with('success', 'Đã xóa loại phụ cấp!');
    }
}
