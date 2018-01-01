<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request){
        dd($request);
        $this->validate($request, array(
            'request_id' => 'required',
            'user_id' => 'required',
            'content' => 'required',
        ));
        $rq = \App\Request::find($request->request_id);
        $comment = Thread::create([
            'request_id' => $request['request_id'],
            'user_id'  => $request['user_id'],
            'content' => $request['content']
        ]);
        RequestController::sendMail($rq, 2);
        return redirect()->back();
    }
}
