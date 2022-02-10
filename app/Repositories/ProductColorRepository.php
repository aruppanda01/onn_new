<?php

namespace App\Repositories;

use App\Interfaces\ProductColorRepositoryInterface;
use App\Models\Category;
use App\Models\ProductColor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class ProductColorRepository extends BaseRepository implements ProductColorRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     * @param Category $model
     */
    public function __construct(ProductColor $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
     /**
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return mixed
     */
    public function getAllProductColor(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findProductColorById(int $id){
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    /**
     * @param array $params
     * @return Category|mixed
     */
    public function createProductColor(array $productSizeDetails)
    {
        try{
            $collection = collect($productSizeDetails);
            $new_size = new ProductColor();
            $new_size->name = $collection['name'];
            $new_size->status = 1;
            $new_size->save();

            return $new_size;
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    /**
     * @param array $params
     * @return Color|mixed
     */
    public function updateProductColor(array $productSizeDetails)
    {
        try{
                $update_product_size_details = $this->findProductColorById($productSizeDetails['id']);

                $update_product_size_details->name = $productSizeDetails['name'];
                $update_product_size_details->status = $productSizeDetails['status'];
                $update_product_size_details->save();
            return $update_product_size_details;
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
