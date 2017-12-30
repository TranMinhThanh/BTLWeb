<?php
/**
 * Created by PhpStorm.
 * User: Mrs Trang
 * Date: 24/12/2017
 * Time: 16:23
 */
namespace App\Http\Controllers;

use App\Relater;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Mail;
class RequestEditController extends RequestController
{
    //
    protected $redirectTo = '/editRequest/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getEditView($id){
        // 1.lay thong tin của request
        // 2.fill vào view -> return view('editRequest', $data);
        $teams = Team::all();
        $request  = \App\Request::find($id);
        $request->load('create_by');
//        dd($request['relations']['create_by']);
        $request->load('assign_to');
        $request->load('team');

        $relaters = Relater::all()->where('request_id',$request['id']);
        $relaters->load('user_id');
        $data['teams'] = $teams;
        $data['request'] = $request;
        $data['relaters'] = $relaters;

        if (Auth::id() == $request['relations']['create_by']->id || Auth::user()->level == 2|| Auth::user()->level == 3) {
                return view('editRequest', $data);
        }
        else if(!empty($request['relations']['assign_to'])){
            if(Auth::id() == $request['relations']['assign_to']->id){
                return view('editRequest', $data);
            }
        }
        else {
            foreach ($relaters as $relater) {
                if (Auth::id() == $relater['relations']['user_id']->id) {
                    return view('editRequest', $data);
                }
            }
        }
            return view('home');
    }
    protected function editValidator(array $data){
        return Validator::make($data,[
            'id' => 'required|int',
            'priority' => 'required|int|min:1|max:6',
            'deadline' => 'required|date',
            'team' => 'required',
            'status' => 'required',
        ]);
    }
    public function editRequest(Request $request){
        $data =$request->all();
        $this ->editValidator($data)->validate();
        $this->edit($data,$data['id']);
        return redirect($this->redirectTo.$data['id']);

    }

    protected function edit(array $data,$id){
        $request = \App\Request::find($id);
        $request->priority = $data['priority'];
        $request->deadline = $data['deadline'];
        if (array_key_exists('assigned_to',$data))
            $request->assign_to = $data['assigned_to'];
        $request->team_id = $data['team'];
        $request->status = $data['status'];
        //cap nhat bang trung gian
        // $request->relater()->sync($data['relater']);
        $request->save();
//        if (!emptyArray($data['relater'])){
//            $oldRelaters = Relater::where('user-id', $id)->delete();
//            foreach ($data['relater'] as $relater) {
//                    // sử lý để lấy user_id của người liên quan VD a[id]
//                    $item = explode($relater,"["); //-> item[1]= "id]"
//                    $relater_id = explode($item[1],"]"); //-> realter_id[0]=id
//
//                    RelaterController::create($this->id, $relater_id[0]);
//                    $email = User::find($relater_id[0])->email;
//                    Mail::send('Notifi.mailNotifi', array('type' => env('typeNotifi.1'), 'person' => Auth::user()->name, 'name' => $data['title'], 'content' => $data['content']), function ($msg) use($email) {
//                    $msg->from(env('MAIL_USERNAME'), 'btlweb');
//                    $msg->to($email, env('typeNotifi.1'));
//                    });
//            }
//        }
//        if ($data)

    }
}