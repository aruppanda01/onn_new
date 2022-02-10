<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\RangeRepositoryInterface;
use Illuminate\Http\Request;

class RangeController extends Controller
{
    private RangeRepositoryInterface $rangeRepository;

    public function __construct(RangeRepositoryInterface $rangeRepository)
    {
        $this->rangeRepository = $rangeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['ranges'] = $this->rangeRepository->getAllRange();
        return view('admin.range.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.range.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255|unique:categories',
            'image' => 'required|mimes:png,jpg,jpeg'
       ]);

       $params = $request->except('_token');
       $range = $this->rangeRepository->createRange($params);

       if (!$range) {
        return $this->responseRedirectBack('Error occurred while creating range.', 'error', true, true);
       }
       return redirect()->route('admin.range.index')->with('success','Range created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $range_details = $this->rangeRepository->findRangeById($id);
        return view('admin.range.edit',compact('range_details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $range_details = $this->rangeRepository->findRangeById($id);
        return view('admin.range.edit',compact('range_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'image' => 'nullable|mimes:png,jpg,jpeg',
       ]);

       $range_details = $request->except('_token');

       $range = $this->rangeRepository->updateRange($range_details);

       if (!$range) {
           return $this->responseRedirectBack('Error occurred while updating range.', 'error', true, true);
       }
       return redirect()->route('admin.range.index')->with('success','Range details updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
