<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategory();
    public function findCategoryById(int $id);
    public function checkExistingCategoryByName(string $name);
    public function createCategory(array $categoryDetails);
    public function updateCategory(array $categoryDetails);
}
