<?php
/**
 * Created by PhpStorm.
 * User: tony
 * Date: 17/06/2017
 * Time: 21:50
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class HCG extends Model {

    protected $table = 'hcg';
    protected $primaryKey = 'hcg_id';

    public $timestamps = true;
    protected $fillable = ['week_num','hcg_value','pid']; // 允许使用create方法进行批量赋值



    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }


}