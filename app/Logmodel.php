<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logmodel extends Model
{
    protected $table = 'logmodel';
    protected $primaryKey = 'a_prediction_id';

    public $timestamps = true;
    protected $fillable = ['week_num','a_hcg_prediction','pid']; // 允许使用create方法进行批量赋值



    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }
}
