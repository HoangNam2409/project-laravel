<?php

namespace App\Repositories\Interfaces;

/**
 * Interface app/Repositories/Interfaces/BaseRepositoryInterface.php
 * @package App\Repositories\Interfaces
 */
interface BaseRepositoryInterface
{
    public function all(array $relation);
    public function findById(int $modelId, array $column, array $relation);
    public function paginate(
        array $column = ['*'],
        array $condition = [],
        array $relations = [],
        array $join = [],
        array $orderBy = ['id', 'DESC'],
        int $perpage = 20,
        $extend = [],
        array $rawQuery = [],
    );
    public function create(array $payload);
    public function update(int $id, array $payload = []);
    public function updateByWhere(array $condition = [], array $payload = []);
    public function updateByWhereIn(string $field, array $whereIn = [], array $payload = []);
    public function destroy(int $id);
    public function softDelete(int $id);
    public function createPivot($model, array $payload = [], string $relation = '');
    public function detachPivot($model, array $payload = [], string $relation = '');
}
