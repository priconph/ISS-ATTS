<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaijinUser extends Model
{
    protected $table = 'users';
    protected $connection = 'raijin';

    // public function users(){
    //     return $this->belongsTo(RapidXUser::class);
    // }
}
