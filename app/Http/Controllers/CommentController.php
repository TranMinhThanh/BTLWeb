<?php

namespace App\Http\Controllers;

use App\Image;
use App\Relater;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Request;
use function MongoDB\BSON\toJSON;

class CommentController extends Controller
{
    //
    public function create($requestId,$user, $content){
        return Image::create([
            'request_id' => $requestId,
            'user_id' => $user,
            'content' => $content,
        ]);
    }
    public function createComment(Request $request){
        dd($request);
        $comment = create($request['id'], Auth::user()->id,$request['comment']);
        return toJSON(['status'=> 1]);
    }
//    public function commentValidate($data){
//        return Validator::make($data,[
//            'request_id' => 'required|int',
//            'priority' => 'required|int|min:1|max:6',
//            'deadline' => 'required|date',
//            'team' => 'required',
//            'status' => 'required',
//            ]);
//    {

    //}
}
