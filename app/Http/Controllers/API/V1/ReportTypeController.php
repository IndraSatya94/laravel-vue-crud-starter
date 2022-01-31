<?php

namespace App\Http\Controllers\API\V1;
use App\Http\Controllers\Controller;
use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportTypeController extends BaseController
{
    protected $reporttype = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReportType $reporttype)
    {
        $this->middleware('auth:api');
        $this->reporttype = $reporttype;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reporttypes = $this->reporttype->latest()->paginate(10);

        return $this->sendResponse($reporttypes, 'Report type list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $reporttypes = $this->reporttype->pluck('name', 'id');

        return $this->sendResponse($reporttypes, 'Report Type list');
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
