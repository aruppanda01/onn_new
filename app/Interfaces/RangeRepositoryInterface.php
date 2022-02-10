<?php

namespace App\Interfaces;

interface RangeRepositoryInterface
{
    public function getAllRange();
    public function findRangeById(int $id);
    public function checkExistingRangeByName(string $name);
    public function createRange(array $rangeDetails);
    public function updateRange(array $rangeDetails);
}
