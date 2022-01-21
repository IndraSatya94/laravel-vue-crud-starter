<?php

namespace App\Http\Controllers\API\V1;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    protected $report = '';

    public function __construct(Report $report)
    {
        $this->middleware('auth:api');
        $this->report = $report;
    }

    public function index()
    {
        $reports = $this->report->latest()->with('reportstatus', 'reporttype')->paginate(10);

        return $this->sendResponse($reports, 'Report list');
    }
}
