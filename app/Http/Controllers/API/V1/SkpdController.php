<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Models\Skpd;

class SkpdController extends BaseController
{
    protected $skpd = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Skpd $skpd)
    {
        $this->middleware('auth:api');
        $this->skpd = $skpd;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skpds = $this->skpd->latest()->paginate(10);

        return $this->sendResponse($skpds, 'Skpd list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function list()
    // {
    //     $skpds = $this->skpd->pluck('name', 'id');

    //     return $this->sendResponse($categories, 'Category list');
    // }


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
        $skpd = $this->skpd->create([
            'name' => $request->get('name'),
            'short_name' => $request->get('short_name'),
        ]);

        return $this->sendResponse($skpd, 'Skpd Created Successfully');
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
        $skpd = $this->skpd->findOrFail($id);

        $skpd->update($request->all());

        return $this->sendResponse($skpd, 'Skpd Information has been updated');
    }

    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $skpd = $this->skpd->findOrFail($id);

        $skpd->delete();

        return $this->sendResponse($skpd, 'Skpd has been Deleted');
    }
}

