<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonlinearModel extends Model
{
    protected $table = 'nonlinearmodel';
    protected $primaryKey = 'b_prediction_id';

    public $timestamps = true;
    protected $fillable = ['week_num','b_hcg_prediction','pid']; // 允许使用create方法进行批量赋值



    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }
}
