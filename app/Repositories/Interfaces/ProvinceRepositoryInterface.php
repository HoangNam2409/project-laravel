<?php

namespace App\Repositories\Interfaces;

/**
 * Interface app/Repositories/Interfaces/ProvinceRepositoryInterface.php
 * @package App\Repositories\Interfaces
 */
interface ProvinceRepositoryInterface
{
    public function all();
    public function findById(int $modelId, array $column, array $relation);
}