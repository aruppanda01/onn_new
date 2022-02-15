<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private ProductRepositoryInterface $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $data['products'] = $this->product_repository->getAllProduct();
        $data['available_colors'] = $this->product_repository->getAllColor();
        $data['available_product_sizes'] = $this->product_repository->getAllProductSizes();
        return view('admin.product.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['categories'] = $this->product_repository->getAllCategory();
        $data['available_ranges'] = $this->product_repository->getAllRange();
        $data['available_colors'] = $this->product_repository->getAllColor();
        $data['available_product_sizes'] = $this->product_repository->getAllProductSizes();
        return view('admin.product.create')->with($data);
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
            'name' => 'required|string|max:255|unique:products',
            'product_code' => 'required|string|max:255|unique:products',
            'category' => 'required',
            'range' => 'required',
            // 'color' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'description' => 'required|max:700'
        ]);

        $params = $request->except('_token');
        $product = $this->product_repository->createProduct($params);

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while creating product.', 'error', true, true);
        }

        return redirect()->route('admin.product.index')->with('success','Product added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['product_details'] = $this->product_repository->findProductById($id);
        return view('admin.product.view')->with($data);
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
        $data['product_details'] = $this->product_repository->findProductById($id);
        $data['product_variant_details'] = $this->product_repository->findProductVariantById($id);
        $data['categories'] = $this->product_repository->getAllCategory();
        $data['available_colors'] = $this->product_repository->getAllColor();
        $data['available_ranges'] = $this->product_repository->getAllRange();
        $data['available_product_sizes'] = $this->product_repository->getAllProductSizes();
        return view('admin.product.edit')->with($data);
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
            'product_code' => 'required|string|max:255',
            'category' => 'required',
            'range' => 'required',
            'image' => 'nullable|mimes:png,jpg,jpeg',
            'description' => 'required|max:700'
        ]);

        $product_details = $request->except('_token');

        $product = $this->product_repository->updateProduct($product_details);

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while updating product.', 'error', true, true);
        }

        return redirect()->route('admin.product.index')->with('success','Product details updated');
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

    /**
     * Add product variant
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addVariant(Request $request)
    {
        $product_variant_details = $request->except('_token');

        $product = $this->product_repository->addVariant($product_variant_details);
        return redirect()->route('admin.product.index')->with('success','Product details updated');

    }

    /**
     * Get All the product variant by product id
     */

    public function getAllProductVariantById($id){
        $data = array();
        $data['product_id'] = $id;
        $data['product_variant_details'] = $this->product_repository->findProductVariantById($id);
        return view('admin.product.variant.index')->with($data);
    }

    /**
     * Show Variant
     */

     public function showProductVariantById($id){
        $data = array();
        $data['product_id'] = $id;
        $data['product_variant_details'] = $this->product_repository->findProductVariantById($id);
        return view('admin.product.variant.view')->with($data);
     }

    /**
     * Edit variant
     */

     public function editVariant($id){
        $data = array();
        $data['variant_id'] = $id;
        $data['available_colors'] = $this->product_repository->getAllColor();
        $data['available_product_sizes'] = $this->product_repository->getAllProductSizes();
        $data['product_variant_details'] = $this->product_repository->findProductVariantByVariantId($id);
        return view('admin.product.variant.edit')->with($data);
     }

     /**
      * Update variant
      * @param  \Illuminate\Http\Request  $request
      */

      public function updateVariant(Request $request,$id){
        $this->validate($request,[
            'sizes' => 'required',
            'color' => 'required',
            'mrp' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'required',
        ]);
        $product_details = $request->except('_token');

        $product = $this->product_repository->updateVariant($product_details);

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while updating product.', 'error', true, true);
        }
        return redirect()->route('admin.getAllProductVariantById',$product->product_id)->with('success','Product variant updated');
      }

      /**
       * Delete variant
       */

     public function deleteVariant(Request $request,$id){
        
        $product_details = $request->except('_token');
        $product = $this->product_repository->deleteVariant($product_details);

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while updating product.', 'error', true, true);
        }
        return redirect()->back()->with('success','Product variant deleted');
     }
}
