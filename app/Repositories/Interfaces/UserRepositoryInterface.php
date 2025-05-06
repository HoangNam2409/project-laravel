<?php

namespace App\Repositories\Interfaces;

/**
 * Interface app/Repositories/Interfaces/UserRepositoryInterface.php
 * @package App\Repositories\Interfaces
 */
interface UserRepositoryInterface
{
    public function paginate(
        array $column = ['*'],
        array $condition = [],
        array $relations = [],
        array $join = [],
        array $orderBy = [],
        int $perpage = 20,
        $extend = [],
        array $rawQuery = [],
    );
    public function create(array $payload);
    public function update(int $id, array $payload = []);
    public function updateByWhereIn(string $field, array $whereIn = [], array $payload = []);
    public function destroy(int $id);
    public function softDelete(int $id);
    public function findById(int $modelId, array $column = ['*'], array $relation = []);
}
