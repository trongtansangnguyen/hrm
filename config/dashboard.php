<?php

return [
    'cache_ttl' => [
        // TTL values are in seconds.
        'employee_summary' => (int) env('DASHBOARD_CACHE_TTL_EMPLOYEE_SUMMARY', 600),
        'leave_summary' => (int) env('DASHBOARD_CACHE_TTL_LEAVE_SUMMARY', 300),
        'candidate_summary' => (int) env('DASHBOARD_CACHE_TTL_CANDIDATE_SUMMARY', 600),
        'recent_activities' => (int) env('DASHBOARD_CACHE_TTL_RECENT_ACTIVITIES', 60),
        'department_stats' => (int) env('DASHBOARD_CACHE_TTL_DEPARTMENT_STATS', 600),
    ],
];
