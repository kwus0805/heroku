<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = array('id');

    //lalavel_15_課題5
    public static $rules = array(
      'name' => 'required',
      'gender' =>'required',
      'hobby' =>'required',
      'introduction' =>'required',

    );

    //以下を追記(lalavel_18_課題)
    public function histories()
    {
      return $this->hasMany('App\ProfileHistory');
    }

}
