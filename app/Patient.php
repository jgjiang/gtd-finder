<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model{

    protected $table = 'patient';
    protected $primaryKey = 'pid';
    public $timestamps = true;
    protected $fillable = ['surname','f_name','dob','address','mrn','i','dx','ddx_date']; // 允许使用create方法进行批量赋值



    protected function getDateFormat()
    {
        return time();
    }

    protected function asDateTime($value)
    {
        return $value;
    }

//    public function getSex($index = null){
//        $arr = [
//            self::SEX_UNKNOWN => 'unknown',
//            self::SEX_MALE => 'male',
//            self::SEX_FEMALE => 'female'
//        ];
//
//        if ($index != null){
//            return array_key_exists($index, $arr) ? $arr[$index] : $arr[self::SEX_UNKNOWN];
//        }
//
//        return $arr;
//
//    }
}
