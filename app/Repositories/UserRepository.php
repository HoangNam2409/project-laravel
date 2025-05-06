<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // Paginate
    public function paginate(
        array $column = ['*'],
        array $condition = [],
        array $relations = [],
        array $join = [],
        array $orderBy = [],
        int $perpage = 20,
        $extend = [],
        array $rawQuery = [],
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('email', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('phone', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('address', 'LIKE', '%' . $condition['keyword'] . '%');
            }
        });

        if (isset($condition['publish']) && $condition['publish'] != 0) {
            $query->where('publish', '=', $condition['publish']);
        }

        if (!empty($join)) {
            $query->join(...$join);
        }

        return $query->paginate($perpage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
}
