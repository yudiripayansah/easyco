<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;

class SampleModel extends Model
{
  use SoftDeletes;
  protected $table = 'promo';
  protected $fillable = [ 'title','desc','image','code','value','allocation','max_per_user'];
  public static function validate($validate)
  {
    if (isset($validate['id'])) {
      $rule = [
            'title' => 'required',
            'code' => 'required|unique:App\Promo,code,'.$validate['id'],
            'value' => 'required',
            'allocation' => 'required',
            'max_per_user' => 'required',
          ];
    } else {
      $rule = [
            'title' => 'required',
            'code' => 'required|unique:App\Promo,code',
            'value' => 'required',
            'allocation' => 'required',
            'max_per_user' => 'required',
          ];
    }
    $validator = Validator::make($validate, $rule);
    if ($validator->fails()) {
      $errors =  $validator->errors()->all();
      $res = array(
            'status' => false,
            'error' => $errors,
            'msg' => 'Error on Validation'
          );
    } else {
      $res = array(
          'status' => true,
          'msg' => 'Validation Ok'
          );
    }
    return $res;
  }
}
