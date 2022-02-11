<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\Range;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
    public function getAllRange()
    {
        return Range::latest()->get();
    }
    public function getAllColor()
    {
        return ProductColor::where('status',1)->latest()->get();
    }
    public function getAllCategory()
    {
        return Category::where('status',1)->latest()->get();
    }
    public function getAllProductSizes()
    {
        return ProductSize::where('status',1)->latest()->get();
    }
    public function getAllProduct()
    {
        $data = array();
        $data['products'] = Product::latest()->get();
        return view('admin.product.index')->with($data);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findProductById(int $id){
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findProductVariantById(int $id){
        try {
            return ProductVariant::where('product_id',$id)->get();

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Category|mixed
     */
    public function createProduct(array $productDetails)
    {
        try{
            $collection = collect($productDetails);
            // Image Upload
            $image = $collection['image'];
            $imageName = imageUpload($image,'product');

            $new_product = new Product();

            // Available Color
            $available_color = $collection['color'];
            if ($available_color) {
                $new_product->color_ids = implode(',', $available_color);
            }

            $new_product->name = $collection['name'];
            $new_product->product_code = $collection['product_code'];
            $new_product->image_path = $imageName;
            $new_product->slug = Str::slug($collection['name']);
            $new_product->category_id = $collection['category'];
            $new_product->range_id = $collection['range'];
            $new_product->description = $collection['description'];
            $new_product->status = 1;
            $new_product->save();

            // Store product variant
            foreach ($collection['addMoreInputFields'] as $key => $input_field) {
                $request_sizes = $input_field['sizes'];
                $request_price = $input_field['price'];

                $new_product_variant = new ProductVariant();
                $new_product_variant->product_id = $new_product->id;
                $new_product_variant->size_id =  $request_sizes;
                $new_product_variant->price =  $request_price;
                $new_product_variant->save();

            }

            return $new_product;
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    /**
     * @param array $params
     * @return Category|mixed
     */
    public function updateProduct(array $productDetails)
    {
        try{
                $update_product_details = $this->findProductById($productDetails['id']);

                if (!empty($productDetails['image'])) {
                    $image = $productDetails['image'];
                    $imageName = imageUpload($image,'product');
                }else {
                    $imageName = $update_product_details['image_path'];
                }

                // Available Color
                $available_color = $productDetails['color'];
                if ($available_color) {
                    $update_product_details->color_ids = implode(',', $available_color);
                }

                $update_product_details->name = $productDetails['name'];
                $update_product_details->product_code = $productDetails['product_code'];
                $update_product_details->image_path = $imageName;
                $update_product_details->slug = Str::slug($productDetails['name']);
                $update_product_details->category_id = $productDetails['category'];
                $update_product_details->range_id = $productDetails['range'];
                $update_product_details->description = $productDetails['description'];
                $update_product_details->status = 1;
                // $update_product_details->save();

                // Store product variant
                foreach ($productDetails['addMoreInputFields'] as $key => $input_field) {
                    foreach ($input_field as $field) {
                        dd($field);
                        $request_sizes = $field['sizes'];
                        $request_price = $field['price'];

                        $update_product_variant = $this->findProductVariantById($productDetails['id']);
                        $update_product_variant->size_id =  $request_sizes;
                        $update_product_variant->price =  $request_price;
                        // $update_product_variant->save();
                    }

                }
                //
                 // Available Sizes
                // $available_sizes = $productDetails['available_sizes'];
                // if ($available_sizes) {
                //     $update_product_details->available_sizes = implode(',', $available_sizes);
                // }
                // $update_product_details->name = $productDetails['name'];
                // $update_product_details->category_id = $productDetails['category'];
                // $update_product_details->sub_category_id = $productDetails['sub_category'];
                // $update_product_details->description = $productDetails['description'];
                // $update_product_details->price = $productDetails['price'];
                // $update_product_details->image_path = $imageName;
                // $update_product_details->slug = Str::slug($productDetails['name']);
                // $update_product_details->status = $productDetails['status'];
                // $update_product_details->save();

            return $update_product_details;
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
