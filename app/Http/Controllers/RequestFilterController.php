<?php

namespace App\Http\Controllers;

use App\Read;
use App\Relater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestFilterController extends RequestController
{
    public static function myRequest(Request $rq, $kindOfRequests, $status){
//            $requests = \App\Request::paginate(20);
//            $requests = \App\Request::all();
            if (env($kindOfRequests) == 0)
//                $requests = $requests->where('create_by',Auth::id());
                $requests = \App\Request::where('create_by',Auth::id());
            else if (env($kindOfRequests) == 1){
                $requestList = [];
                $relatersList = Relater::all()->where('user_id',Auth::id());
                foreach ($relatersList as $relater){
                    $requestList []= $relater['request_id'];
                }
//                $requests = $requests->whereIn('id',$requestList);
                $requests = \App\Request::whereIn('id',$requestList);
            }
            else if (env($kindOfRequests) == 2)
//                $requests = $requests->where('assign_to',Auth::id());
                $requests = \App\Request::where('assigned_to',Auth::id());
            else if (env($kindOfRequests) == 3)
//                $requests = $requests->where('team_id',Auth::user()['team_id']);
                $requests = \App\Request::where('team_id',Auth::user()['team_id']);
            if (env($status))
                $requests = $requests->where('status',env($status));
            $requests->with('create_by');
            $requests->with('assign_to');
            $requests->with('team');
            $requests = $requests->paginate(20);
            $data['requests'] = $requests;
            return view('filter', $data);
    }

    public static function myUnreadRequest($kindOfRequests, $status){
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
            $requests = $requests->where('assigned_to',Auth::id());
        else if (env($kindOfRequests) == 3)
            $requests = $requests->where('team_id',Auth::user()['team_id']);

        if (env($status))
            $requests = $requests->where('status',env($status));
        $requestIds = [];
        foreach ($requests as $request)
            $requestIds []= $request['id'];

        // tìm toàn bộ request chưa đc đọc
        $unreadRequests = Read::all()->where('status',0)->where('user_id',Auth::id());
        $unreadIds = [];
        foreach ($unreadRequests as $unreadRequest)
            $unreadIds []= $unreadRequest['request_id'];

        //check số phần tử giống nhau trong $requestIds và $unreadIds
        $diffUnreads = array_diff($unreadIds, $requestIds);
        return count($unreadIds) - count($diffUnreads);
    }
}
