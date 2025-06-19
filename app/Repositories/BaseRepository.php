<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // All
    public function all(array $relation = [])
    {
        return $this->model->with($relation)->get();
    }

    // Find by Id
    public function findById(
        int $modelId,
        array $column = ['*'],
        array $relation = [],
    ) {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

    // Paginate
    public function paginate(
        array $column = ['*'],
        array $condition = [],
        array $relations = [],
        array $join = [],
        array $orderBy = [['id', 'desc']],
        int $perpage = 20,
        $extend = [],
        array $rawQuery = [],
    ) {
        $query = $this->model->select($column);

        return $query->keyword($condition['keyword'] ?? null)
            ->publish($condition['publish'] ?? null)
            ->customWhere($condition['where'] ?? [])
            ->customWhereRaw($rawQuery['whereRaw'] ?? [])
            ->relationCount($relations ?? [])
            ->relation($relations ?? [])
            ->customJoin($join ?? [])
            ->customGroupBy($extend['groupBy'] ?? [])
            ->customOrderBy($orderBy ?? [])
            ->paginate($perpage)
            ->withQueryString()
            ->withPath(env('APP_URL') . $extend['path']);
    }

    // Create
    public function create(array $payload = [])
    {
        $newModel = $this->model->create($payload);
        return $newModel->fresh();
    }

    // Update
    public function update(int $id, array $payload = [])
    {
        $model = $this->findById($id);
        return $model->update($payload);
    }

    // Update Where
    public function updateByWhere(array $condition = [], array $payload = [])
    {
        $query = $this->model->newQuery();
        foreach ($condition as $key => $val) {
            $query->where(...$val);
        }

        return $query->update($payload);
    }

    // Update Where in
    public function updateByWhereIn(string $field, array $whereIn = [], array $payload = [])
    {
        return $this->model->whereIn($field, $whereIn)->update($payload);
    }

    // Soft Delete
    public function softDelete(int $id)
    {
        return $this->findById($id)->delete();
    }


    // Destroy
    public function destroy(int $id)
    {
        return $this->findById($id)->forceDelete();
    }

    // Create Pivot
    public function createPivot($model, array $payload = [], string $relation = '')
    {
        return $model->{$relation}()->attach($payload['language_id'], $payload);
    }

    // Detach Pivot
    public function detachPivot($model, array $payload = [], string $relation = '')
    {
        return $model->{$relation}()->detach($payload);
    }
}
