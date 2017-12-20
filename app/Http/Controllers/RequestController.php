<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RequestController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCreateView(){
        $teams = Team::all();
        $data['teams'] = $teams;
        return view('createRequest',$data);
    }

    public function getEditView(){
        // 1.lay thong tin của request
        // 2.fill vào view -> return view('editRequest', $data);
        $teams = Team::all();
        $data['teams'] = $teams;
        return view('editRequest',$data);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => 'required|string|max:255',
            'priority' => 'required|int|min:1|max:6',
            'deadline' => 'required|date',
            'team' => 'required',
            'content' => 'required|string',
        ]);
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
        if($news->priority != $data['priority']){
            $news->priority = $data['priority'];
        }
        if($news->deadline != $data['deadline']){
            $news->deadline = $data['deadline'];
        }
        if($news->assigned_to != $data['assigned_to']){
            $news->assigned_to = $data['assigned_to'];
        }
        if($news->team_id != $data['team']){
            $news->team_id = $data['team'];
        }
        if($news->status != $data['status']){
            $news->status = $data['status'];
        }
        //cap nhat bang trung gian
        $news->relater()->sync($data['relater']);
        $news->save();
        if (!emptyArray($data['relater'])){
            foreach ($data['relater'] as $relater) {
                $email = User::find($relater)->email;
                // can bo sung them content
                Mail::send('Notifi.mailNotifi', array('type' => env('typeNotifi.2'), 'person' => Auth::name(), 'name' => $news->title, 'content' => ""), function ($msg) use($email) {
                    $msg->from('btlweb.uet@gmail.com', 'btlweb');
                    $msg->to($email, env('typeNotifi.1'));
                });
            }
        }

    }
    public function createRequest(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();
        $this->create($data);
        if (!emptyArray($data['relater'])){
            foreach ($data['relater'] as $relater) {
                RelaterController::create($this->id, $relater);
                $email = User::find($relater)->email;
                Mail::send('Notifi.mailNotifi', array('type' => env('typeNotifi.1'), 'person' => Auth::name(), 'name' => $data['title'], 'content' => $data['content']), function ($msg) use($email) {
                    $msg->from('btlweb.uet@gmail.com', 'btlweb');
                    $msg->to($email, env('typeNotifi.1'));
                });
            }
        }

        // mail cho ca nguoi tao request
        $user = Auth::email();
        Mail::send('Notifi.mailNotifi',array('type'=>env('typeNotifi.1'), 'person'=>Auth::name(),'name'=>$data['title'],'content'=>""),function($msg) use($user){
            $msg->from('btlweb.uet@gmail.com','btlweb');
            $msg->to($user,env('typeNotifi.1'));
    });

    }

    public function create(array $data){
//        if ($data['relater'].)
        return \App\Request::create([
            'title' => $data['title'],
            'create_by' => Auth::id(),
            'content' => $data['content'],
            'status' => '1',
            'priority' => $data['priority'],
            'deadline' => $data['deadline'],
            'team_id' => $data['team'],
        ]);
    }
    public function comment(Request $request, $id){
        $comment = $request->all();
        $requestOfComment = Request::find($id);
        // can them note va type
        $requestOfComment->comment()->attach(Auth::id(),['content'=>$comment['comment'],'type'=>'','note'=>'']);
        //thong bao cho nguoi lien quan
        $relaters = $requestOfComment->relater()->user_id;
        if (!emptyArray($relaters)){
            foreach ($relaters as $relater) {
                $email = User::find($relater)->email;
                Mail::send('Notifi.mailNotifi', array('type' => env('typeNotifi.3'), 'person' => Auth::name(), 'name' => $requestOfComment->title, 'content' => $comment['comment']), function ($msg) use($email) {
                    $msg->from('btlweb.uet@gmail.com', 'btlweb');
                    $msg->to($email, env('typeNotifi.3'));
                });
            }
        }
    }
}
