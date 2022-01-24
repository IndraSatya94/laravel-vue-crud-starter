<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Report;

class ReportController extends BaseController
{
    // protected $report = '';

    // public function __construct(Report $report)
    // {
    //     $this->middleware('auth:api');
    //     $this->report = $report;
    // }

    public function index()
    {
        $reports = Report::all();

        return $reports;
    }
}
