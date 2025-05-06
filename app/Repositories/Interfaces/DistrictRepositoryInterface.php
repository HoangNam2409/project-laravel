<?php

namespace App\Repositories\Interfaces;

/**
 * Interface app/Repositories/Interfaces/DistrictRepositoryInterface.php
 * @package App\Repositories\Interfaces
 */
interface DistrictRepositoryInterface
{
    public function findDistrictByProvinceId(int $province_id);
    public function findById(int $modelId, array $column, array $relation);
}