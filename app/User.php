<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    public $timestamps = true;
    use Notifiable;
    protected $fillable = [
        'username', 'password', 'name', 'gender', 'age', 'address', 'email', 'level', 'team_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    //1 người chỉ ở trong 1 nhóm
    public function user(){
        return $this->hasOne('App\Team');
    }
}
