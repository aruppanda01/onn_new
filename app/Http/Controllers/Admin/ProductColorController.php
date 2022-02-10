<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductColorRepositoryInterface;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    private ProductColorRepositoryInterface $product_color_repository;

    public function __construct(ProductColorRepositoryInterface $product_color_repository)
    {
        $this->product_color_repository = $product_color_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['colors'] = $this->product_color_repository->getAllProductColor();
        return view('admin.product_color.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product_color.create');
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
            'name' => 'required|max:255|unique:product_colors',
        ],[
            'name.required' => 'This field is required'
        ]);
        $params = $request->except('_token');
        $product_color = $this->product_color_repository->createProductColor($params);

        if (!$product_color) {
            return $this->responseRedirectBack('Error occurred while creating product color.', 'error', true, true);
        }

        return redirect()->route('admin.available-product-color.index')->with('success','Product Color added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['product_color'] = $this->product_color_repository->findProductColorById($id);;
        return view('admin.product_color.edit')->with($data);
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
            'name' => 'required|max:255',
        ]);

        $color_details = $request->except('_token');

        $product_colour = $this->product_color_repository->updateProductColor($color_details);

        if (!$product_colour) {
            return $this->responseRedirectBack('Error occurred while updating product colour.', 'error', true, true);
        }

        return redirect()->route('admin.available-product-color.index')->with('success','Product Colour  updated');
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
