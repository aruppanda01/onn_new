<?php

namespace App\Interfaces;

interface ProductColorRepositoryInterface
{
    public function getAllProductColor();
    public function findProductColorById(int $id);
    public function createProductColor(array $productColorDetails);
    public function updateProductColor(array $productColorDetails);
}
