<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductSizeRepositoryInterface;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    private ProductSizeRepositoryInterface $product_size_repository;

    public function __construct(ProductSizeRepositoryInterface $product_size_repository)
    {
        $this->product_size_repository = $product_size_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->product_size_repository->getAllProductSizes();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product_size.create');
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
            'size' => 'required|max:255|unique:product_sizes',
            'short_name' => 'required|max:255',
        ]);

        $params = $request->except('_token');
        $product_size = $this->product_size_repository->createProductSize($params);

        if (!$product_size) {
            return $this->responseRedirectBack('Error occurred while creating product size.', 'error', true, true);
        }

        return redirect()->route('admin.available-product-size.index')->with('success','Product Size added');
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
        $data['product_details'] = ProductSize::find($id);
        return view('admin.product_size.edit')->with($data);
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
            'size' => 'required|max:255',
            'short_name' => 'required|max:255',
            'status' => 'required'
        ]);

        $size_details = $request->except('_token');

        $product_size = $this->product_size_repository->updateProductSize($size_details);

        if (!$product_size) {
            return $this->responseRedirectBack('Error occurred while updating product_size.', 'error', true, true);
        }

        return redirect()->route('admin.available-product-size.index')->with('success','Product Size updated');
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
