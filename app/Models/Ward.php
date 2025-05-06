<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $tabel = 'wards';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function districts()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
}