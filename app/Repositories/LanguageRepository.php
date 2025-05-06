<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

/**
 * Class LanguageRepository
 * @package App\Repositories
 */
class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    protected $model;

    public function __construct(Language $model)
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
                    ->orWhere('canonical', 'LIKE', '%' . $condition['keyword'] . '%');
            }
        });

        if (isset($condition['publish']) && $condition['publish'] != 0) {
            $query->where('publish', '=', $condition['publish']);
        }

        if (isset($relations) && !empty($relations)) {
            $query->withCount($relations);
        }

        if (!empty($join)) {
            $query->join(...$join);
        }

        return $query->paginate($perpage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
}
