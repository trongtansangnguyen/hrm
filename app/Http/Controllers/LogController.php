<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LogService;

class LogController extends Controller
{
    protected LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'action', 'table_name', 'date_from', 'date_to', 'sort_by', 'sort_order', 'per_page']);
        
        $logs = $this->logService->getPaginatedLogs($filters);
        $actions = $this->logService->getDistinctActions();
        $tableNames = $this->logService->getDistinctTableNames();

        return view('logs', compact('logs', 'filters', 'actions', 'tableNames'));
    }
}
