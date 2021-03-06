<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllRange();
    public function getAllColor();
    public function getAllCategory();
    public function getAllProductSizes();
    public function getAllProduct();
    public function findProductById(int $id);
    public function findProductVariantById(int $id);
    public function findProductVariantByVariantId(int $id);
    public function createProduct(array $productDetails);
    public function updateProduct(array $productDetails);
    public function addVariant(array $variantDetails);
    public function updateVariant(array $variantDetails);
    public function deleteVariant(array $variantDetails);
}
