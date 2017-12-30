<?php

namespace App\Http\Controllers;

use App\Relater;

class RelaterController extends Controller
{
    //
    public static function create($requestId, $userId){
        return Relater::create([
            'request_id' => $requestId,
            'user_id' => $userId,
        ]);
    }
}
