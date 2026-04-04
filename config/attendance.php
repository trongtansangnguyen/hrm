<?php

return [
    // Giờ bắt đầu làm việc theo chuẩn công ty (HH:MM).
    'standard_start_time' => env('ATTENDANCE_STANDARD_START_TIME', '08:30'),

    // Số phút cho phép trễ trước khi bị tính là đi trễ.
    'late_after_minutes' => (int) env('ATTENDANCE_LATE_AFTER_MINUTES', 0),

    // Số bản ghi mỗi trang ở màn hình quản lý chấm công.
    'management_per_page' => (int) env('ATTENDANCE_MANAGEMENT_PER_PAGE', 15),
];
