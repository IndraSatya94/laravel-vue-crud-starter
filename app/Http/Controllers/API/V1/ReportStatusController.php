<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ReportStatus;
use Illuminate\Http\Request;

class ReportStatusController extends BaseController
{
    protected $category = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportStatus $reportstatus)
    {
        $this->middleware('auth:api');
        $this->reportstatus = $reportstatus;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reportstatuses = $this->reportstatus->latest()->paginate(10);

        return $this->sendResponse($reportstatuses, 'Report Status list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $reportstatuses = $this->reportstatus->pluck('name', 'id');

        return $this->sendResponse($reportstatuses, 'Report Status list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // $tag = $this->category->create([
        //     'name' => $request->get('name'),
        //     'description' => $request->get('description'),
        // ]);

        // return $this->sendResponse($tag, 'Category Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        // $tag = $this->category->findOrFail($id);

        // $tag->update($request->all());

        // return $this->sendResponse($tag, 'Category Information has been updated');
    }
}
