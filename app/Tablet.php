<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\RapidXUser;
use App\RapidXDepartment;

class Tablet extends Model
{
    public function rapidx_programmer(){
        return $this->hasOne(RapidXUser::class, 'id', 'programmer');
    }
    public function rapidx_requestor(){
        return $this->hasOne(RapidXUser::class, 'name', 'assigned_user');
    }
    public function rapidx_section_department(){
        return $this->hasOne(RapidXDepartment::class, 'department_id', 'section');
    }
}
