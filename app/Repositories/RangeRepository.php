<?php

namespace App\Repositories;

use App\Interfaces\RangeRepositoryInterface;
use App\Models\Category;
use App\Models\Range;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use InvalidArgumentException;

class RangeRepository extends BaseRepository implements RangeRepositoryInterface
{
    /**
     * RangeRepository constructor.
     * @param Range $model
     */
    public function __construct(Range $model)
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
    public function getAllRange(string $order = 'id', string $sort = 'desc', array $columns = ['*'])
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findRangeById(int $id){
        try {
            return $this->findOneOrFail($id);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }
    /**
     * @param int $id
     * @return true or false
     */
    public function checkExistingRangeByName(string $name)
    {
        $check_range_name = Range::where('name',$name)->first();
        if (!empty($check_range_name)) {
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @param array $params
     * @return Range|mixed
     */
    public function createRange(array $rangeDetails)
    {
        try{
            $collection = collect($rangeDetails);
            $check_category_name = $this->checkExistingRangeByName($collection['name']);
            if ($check_category_name == 1) {
                return 0;
            }else{
                $image = $collection['image'];
                $imageName = imageUpload($image,'range');

                $range = new Range();
                $range->name = $collection['name'];
                $range->image_path = $imageName;
                $range->slug = Str::slug($collection['name']);
                $range->save();

                return $range;
            }
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
    /**
     * @param array $params
     * @return Category|mixed
     */
    public function updateRange(array $rangeDetails)
    {
        try{
                $category_details = $this->findRangeById($rangeDetails['id']);

                if (!empty($rangeDetails['image'])) {
                    $image = $rangeDetails['image'];
                    $imageName = imageUpload($image,'category');
                }else {
                    $imageName = $category_details['image_path'];
                }
                $category_details->name = $rangeDetails['name'];
                $category_details->image_path = $imageName;
                $category_details->slug = Str::slug($rangeDetails['name']);
                $category_details->save();

            return $category_details;
        }
        catch (QueryException $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }
    }
}
