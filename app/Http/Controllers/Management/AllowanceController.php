<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    public function index()
    {
        // Giả sử sau này bạn sẽ lấy dữ liệu từ DB ở đây
        // $allowances = Allowance::all(); 
        return view('management.allowances.index');
    }
    public function create()
    {
    // Chuyển hướng về trang danh sách kèm thông báo warning
    return redirect()->route('management.allowances.index')
                     ->with('warning', 'Chức năng "Thêm mới phụ cấp" hiện đang được phát triển.');
    }
}
