<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileHistory extends Model
{
    //lalavel_18課題
    protected $guarded = array('id');

    public static $rules =  array(
        'name_at' => 'required' ,
        'gender_at' => 'required',
        'hobby_at' => 'required',
        'introduction_at' => 'required',

      );
}
