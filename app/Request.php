<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';
    public $timestamps = true;

//    public function User(){
//        return $this->hasOne('App\User','assigned_to');
//    }
}
