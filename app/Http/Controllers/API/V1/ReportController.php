<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Reports\ReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends BaseController
{
    protected $report = '';

    public function __construct(Report $report)
    {
        $this->middleware('auth:api');
        $this->report = $report;
    }

    public function index()
    {
        $reports = $this->report->latest()->with('reportstatus')->paginate(10);

        return $this->sendResponse($reports, 'Report list');
        // $reports = Report::all();

        // return $reports;
    }
    public function store(ReportRequest $request)
    {
        $report = $this->report->create([
            'subject' => $request->get('subject'),
            'description' => $request->get('description'),
            // 'price' => $request->get('price'),
            'reportstatus_id' => $request->get('reportstatus_id'),
        ]);

        // update pivot table
        // $tag_ids = [];
        // foreach ($request->get('tags') as $tag) {
        //     $existingtag = Tag::whereName($tag['text'])->first();
        //     if ($existingtag) {
        //         $tag_ids[] = $existingtag->id;
        //     } else {
        //         $newtag = Tag::create([
        //             'name' => $tag['text']
        //         ]);
        //         $tag_ids[] = $newtag->id;
        //     }
        // }
        // $product->tags()->sync($tag_ids);

        return $this->sendResponse($report, 'Report Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = $this->report->with(['reportstatus'])->findOrFail($id);

        return $this->sendResponse($report, 'Report Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, $id)
    {
        $report = $this->report->findOrFail($id);

        $report->update($request->all());

        // update pivot table
        // $tag_ids = [];
        // foreach ($request->get('tags') as $tag) {
        //     $existingtag = Tag::whereName($tag['text'])->first();
        //     if ($existingtag) {
        //         $tag_ids[] = $existingtag->id;
        //     } else {
        //         $newtag = Tag::create([
        //             'name' => $tag['text']
        //         ]);
        //         $tag_ids[] = $newtag->id;
        //     }
        // }
        // $product->tags()->sync($tag_ids);

        return $this->sendResponse($report, 'Report Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $report = $this->report->findOrFail($id);

        $report->delete();

        return $this->sendResponse($report, 'Report has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
