<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepository->getAllCategory();
        return response()->json(array(
            'message' => 'Data fetch successfully',
            'errorMsg' => false,
            'data' => $categories
        ));
    }

    public function show($id)
    {
        $category_details = $this->categoryRepository->findCategoryById($id);
        return response()->json(array(
            'message' => 'Data fetch successfully',
            'errorMsg' => false,
            'data' => $category_details
        ));
    }

    public function store(Request $request)
    {
       $params = $request->all();
       $category = $this->categoryRepository->createCategory($params);
       if ($category) {
            return response()->json(array(
                'error'  => false,
                'message'  => 'Category added successfully',
            ));
       }else {
            return response()->json(array(
                'error'  => true,
                'message'  => 'Please used different category name',
            ));
       }

    }

    public function update(Request $request,$id)
    {
        $category_details = $request->all();
        $category_details['id'] = $id;

        $category = $this->categoryRepository->updateCategory($category_details);
        if ($category) {
            return response()->json(array(
                'error'  => false,
                'message'  => 'Category update successfully',
            ));
       }else {
            return response()->json(array(
                'error'  => true,
                'message'  => 'Issue occurred',
            ));
       }
    }
}
