<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AllowanceType;

class AllowanceTypeController extends Controller
{
    public function index()
    {
        $types = AllowanceType::latest()->get();
        return view('management.allowances.indexs', compact('types'));
    }

    // Trang tạo mới
    public function create()
    {
        return view('management.allowances.creates');
    }

    // Lưu loại phụ cấp mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        AllowanceType::create($request->all());

        return redirect()->route('management.allowances.indexs')
                         ->with('success', 'Đã thêm loại phụ cấp mới thành công!');
    }

    // Trang chỉnh sửa
    public function edit(AllowanceType $allowanceType)
    {
        return view('management.allowances.edit', compact('allowanceType'));
    }

    // Cập nhật dữ liệu
    public function update(Request $request, AllowanceType $allowanceType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $allowanceType->update($request->all());

        return redirect()->route('management.allowances.indexs')
                         ->with('success', 'Cập nhật loại phụ cấp thành công!');
    }

    // Xóa
    public function destroy(AllowanceType $allowanceType)
    {
        $allowanceType->delete();
        return redirect()->route('management.allowances.indexs')
                         ->with('success', 'Đã xóa loại phụ cấp!');
    }
}