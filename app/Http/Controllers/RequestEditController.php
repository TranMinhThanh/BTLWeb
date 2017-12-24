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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getEditView(){
        // 1.lay thong tin của request
        // 2.fill vào view -> return view('editRequest', $data);
        $teams = Team::all();
        $data['teams'] = $teams;
        return view('editRequest',$data);

    }
    protected function editValidator(array $data){
        return Validator::make($data,[
            'priority' => 'required|int|min:1|max:6',
            'deadline' => 'required|date',
            'team' => 'required',
            'status' => 'required',
        ]);
    }
    public function editRequest(Request $request,$id){
        $data =$request->all();
        $this ->editValidator($data)->validate();
        $this->edit($data,$id);
    }

    protected function edit(array $data,$id){
        $news = Request::find($id);
        $news->priority = $data['priority'];
        $news->deadline = $data['deadline'];
        $news->assigned_to = $data['assigned_to'];
        $news->team_id = $data['team'];
        $news->status = $data['status'];
        //cap nhat bang trung gian
        // $news->relater()->sync($data['relater']);
        $news->save();
        if (!emptyArray($data['relater'])){
            $oldRelaters = Relater::where('user-id', $id)->delete();
            foreach ($data['relater'] as $relater) {
                Relater::creat([$id,$relater]);
                // can bo sung them content
                Mail::send('Notifi.mailNotifi', array('type' => env('typeNotifi.2'), 'person' => Auth::name(), 'name' => $news->title, 'content' => ""), function ($msg) use($email) {
                    $msg->from('btlweb.uet@gmail.com', 'btlweb');
                    $msg->to($email, env('typeNotifi.1'));
                });
            }
        }
    }
}