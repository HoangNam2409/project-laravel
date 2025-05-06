<?php

namespace App\Traits;

trait QueryScopes
{
    public function scopeKeyword($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return $query;
    }

    public function scopePublish($query, $publish)
    {
        if (!empty($publish)) {
            $query->where('publish', '=', $publish);
        }

        return $query;
    }

    public function scopeCustomWhere($query, $where = [])
    {
        if (count($where)) {
            foreach ($where as $key => $val) {
                $query->where(...$val);
            }
        }

        return $query;
    }

    public function scopeCustomWhereRaw($query, $rawQuery = [])
    {
        if (isset($rawQuery) && count($rawQuery)) {
            foreach ($rawQuery as $key => $val) {
                $query->whereRaw(...$val);
            }
        }

        return $query;
    }

    public function scopeRelationCount($query, $relations = [])
    {
        if (!empty($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
            }
        }

        return $query;
    }

    public function scopeRelation($query, $relations = [])
    {
        if (!empty($relations)) {
            foreach ($relations as $relation) {
                $query->with($relation);
            }
        }

        return $query;
    }

    public function scopeCustomJoin($query, $join = [])
    {
        if (is_array($join) && count($join)) {
            foreach ($join as $key => $val) {
                $query->join(...$val);
            }
        }

        return $query;
    }

    public function scopeCustomGroupBy($query, $groupBy)
    {
        if (!empty($groupBy)) {
            $query->groupBy($groupBy);
        }

        return $query;
    }

    public function scopeCustomOrderBy($query, $orderBy = [])
    {
        if (is_array($orderBy) && count($orderBy)) {
            foreach ($orderBy as $key => $val) {
                $query->orderBy($key, $val);
            }
        }

        return $query;
    }
}
