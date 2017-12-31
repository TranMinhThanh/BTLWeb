<?php

namespace App\Http\Controllers;

use App\Relater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestFilterController extends RequestController
{
    public static function myRequest(Request $rq, $kindOfRequests, $status){
        if ($rq->ajax() || 'NULL') {
            $requests = \App\Request::all();

            if (env($kindOfRequests) == 0)
                $requests = $requests->where('create_by',Auth::id());
            else if (env($kindOfRequests) == 1){
                $requestList = [];
                $relatersList = Relater::all()->where('user_id',Auth::id());
                foreach ($relatersList as $relater){
                    $requestList []= $relater['request_id'];
                }
                $requests = $requests->whereIn('id',$requestList);
            }
            else if (env($kindOfRequests) == 2)
                $requests = $requests->where('assign_to',Auth::id());
            else if (env($kindOfRequests) == 3)
                $requests = $requests->where('team_id',Auth::user()['team_id']);

            if (env($status))
                $requests = $requests->where('status',env($status));
            $requests->load('create_by');
            $requests->load('assign_to');
            $requests->load('team');
            $data['requests'] = $requests;

            return view('filter', $data);
        }
    }
}
