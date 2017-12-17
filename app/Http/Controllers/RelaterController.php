<?php

namespace App\Http\Controllers;

use App\Relater;
use App\User;
use Illuminate\Http\Request;

class RelaterController extends Controller
{
    //
    public function create(\App\Request $requestId, User $userId){
        return Relater::create([
            'request_id' => $requestId,
            'user_id' => $userId,
        ]);
    }
}
