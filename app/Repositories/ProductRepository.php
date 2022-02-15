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
        return Product::latest()->get();
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
     * @param int product $id
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
     * @param int product $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findProductVariantByVariantId(int $id){
        try {
            return ProductVariant::find($id);

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
            // $available_color = $collection['color'];
            // if ($available_color) {
            //     $new_product->color_ids = implode(',', $available_color);
            // }

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
            // foreach ($collection['addMoreInputFields'] as $key => $input_field) {
            //     $request_sizes = $input_field['sizes'];
            //     $request_price = $input_field['price'];

            //     $new_product_variant = new ProductVariant();
            //     $new_product_variant->product_id = $new_product->id;
            //     $new_product_variant->size_id =  $request_sizes;
            //     $new_product_variant->price =  $request_price;
            //     $new_product_variant->save();

            // }

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

                $update_product_details->name = $productDetails['name'];
                $update_product_details->product_code = $productDetails['product_code'];
                $update_product_details->image_path = $imageName;
                $update_product_details->slug = Str::slug($productDetails['name']);
                $update_product_details->category_id = $productDetails['category'];
                $update_product_details->range_id = $productDetails['range'];
                $update_product_details->description = $productDetails['description'];
                $update_product_details->status = 1;
                $update_product_details->save();

            return $update_product_details;
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

     /**
     * @param array $params
     * @return ProductVariant|mixed
     */
    public function addVariant(array $variantDetails){
        try {
            foreach ($variantDetails['addMoreInputFields'] as $key => $input_field) {
                    $request_sizes = $input_field['sizes'];
                    $request_color = $input_field['color'];
                    $request_mrp = $input_field['mrp'];
                    $request_discount = $input_field['discount'];

                    /**
                     * Calculation the actual price
                     */
                    $discount_price =  ($request_mrp / 100) * $request_discount;
                    $final_price = $request_mrp -  $discount_price;

                    /**
                     * Store the variant details in product_variants table
                     */

                    $new_product_variant = new ProductVariant();
                    $new_product_variant->product_id = $variantDetails['product_id'];
                    $new_product_variant->size_id =  $request_sizes;
                    $new_product_variant->color_id =  $request_color;
                    $new_product_variant->mrp =  $request_mrp;
                    $new_product_variant->discount =  $request_discount;
                    $new_product_variant->actual_price =  $final_price;
                    $new_product_variant->save();

            }
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }

    /**
     * Update variant
     */
    public function updateVariant($variantDetails){
            try{
                $update_product_variant_details = $this->findProductVariantByVariantId($variantDetails['id']);

                $request_sizes = $variantDetails['sizes'];
                $request_color = $variantDetails['color'];
                $request_mrp = $variantDetails['mrp'];
                $request_discount = $variantDetails['discount'];

                /**
                 * Calculation the actual price
                 */
                $discount_price =  ($request_mrp / 100) * $request_discount;
                $final_price = $request_mrp -  $discount_price;

                /**
                 * Store the variant details in product_variants table
                */

                $update_product_variant_details->size_id =  $request_sizes;
                $update_product_variant_details->color_id =  $request_color;
                $update_product_variant_details->mrp =  $request_mrp;
                $update_product_variant_details->discount =  $request_discount;
                $update_product_variant_details->actual_price =  $final_price;
                $update_product_variant_details->save();

            return $update_product_variant_details;
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    /**
     * Delete variant
     */

    public function deleteVariant($variantDetails){
        try {
            $variant = ProductVariant::find($variantDetails['id'])->delete();
            return $variant;
        } catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
