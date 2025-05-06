<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Nestedsetbie
{

    protected $params;
    protected $checked;
    protected $data;
    protected $count;
    protected $count_level;
    protected $left;
    protected $right;
    protected $level;

    function __construct($params = NULL)
    {
        $this->params = $params;
        $this->checked = NULL;
        $this->data = NULL;
        $this->count = 0;
        $this->count_level = 0;
        $this->left = NULL;
        $this->right = NULL;
        $this->level = NULL;
    }

    // Lấy giá trị
    public function Get()
    {
        $foreignkey = (isset($this->params['foreignkey'])) ? $this->params['foreignkey'] : 'post_catalogue_id';
        $moduleExtract = explode('_', $this->params['table']);
        $result = DB::table($this->params['table'] . ' as tb1')
            ->join($moduleExtract[0] . '_catalogue_language as tb2', 'tb1.id', '=', 'tb2.' . $foreignkey . '')
            ->select('tb1.id', 'tb2.name', 'tb1.parent_id', 'tb1.left', 'tb1.right', 'tb1.level', 'tb1.order')
            ->where('tb2.language_id', '=', $this->params['language_id'])
            ->whereNull('tb1.deleted_at')
            ->orderBy('tb1.left', 'asc')->get()->toArray();
        $this->data = $result;
        // dd($this->data);
    }

    public function Set()
    {
        if (isset($this->data) && is_array($this->data)) {
            $arr = NULL;
            foreach ($this->data as $key => $val) {
                $arr[$val->id][$val->parent_id] = 1;
                $arr[$val->parent_id][$val->id] = 1;
            }
            // dd($arr);
            return $arr;
        }
    }

    /*
    $arr = [
        47 => [
            0 => 1 checked
        ]
        0 => [
            42 => 1,checked
            47 => 1 checked
        ]
        42 => [
            0 => 1,checked
            44 => 1,checked
        ],
        44 => [
            42 => 1,checked
            46 => 1,checked
        ],
        46 => [
            44 => 1checked
        ],
    */

    // Tính toàn lại các giá trị Node
    public function Recursive($start = 0, $arr = NULL)
    {
        $this->left[$start] = ++$this->count;
        $this->level[$start] = $this->count_level;
        if (isset($arr) && is_array($arr)) {
            foreach ($arr as $key => $val) {
                if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
                    $this->count_level++;
                    $this->checked[$start][$key] = 1;
                    $this->checked[$key][$start] = 1;
                    $this->recursive($key, $arr);
                    $this->count_level--;
                }
            }
        }
        $this->right[$start] = ++$this->count;
    }

    /*
        left = [0 => 1, 48 => 2, 42 => 4, 44 => 5, 46 => 6]
        level = [0 => 0, 48 => 1, 42 => 1, 44 => 2, 46 => 3]
        right = [48 => 3, 46 => 7, 44 => 8, 42 => 9, 0 => 10]
    */

    // Cập nhật lại giá trị
    public function Action()
    {
        if (isset($this->level) && is_array($this->level) && isset($this->left) && is_array($this->left) && isset($this->right) && is_array($this->right)) {
            $data = NULL;
            foreach ($this->level as $key => $val) {
                if ($key == 0) continue;
                $data[] = array(
                    'id' => $key,
                    'level' => $val,
                    'left' => $this->left[$key],
                    'right' => $this->right[$key],
                    'user_id' => Auth::id(),
                );
            }
            if (isset($data) && is_array($data) && count($data)) {
                DB::table($this->params['table'])->upsert($data, 'id', ['level', 'left', 'right']);
            }
        }
    }

    // Lấy ra các giá trị để hiển thị
    public function Dropdown($param = NULL)
    {
        $this->Get();
        if (isset($this->data) && is_array($this->data)) {
            $temp = NULL;
            $temp[0] = (isset($param['text']) && !empty($param['text'])) ? $param['text'] : '[Root]';
            foreach ($this->data as $key => $val) {
                $temp[$val->id] = str_repeat('|-----', (($val->level > 0) ? ($val->level - 1) : 0)) . $val->name;
            }
            return $temp;
        }
    }
}