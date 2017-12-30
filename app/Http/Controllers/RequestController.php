<?php

namespace App\Http\Controllers;

use App\Relater;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Mail;
class RequestController extends Controller
{
    //
    protected $redirectTo = '/filter/myRequests/all';

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
    public function createRequest(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();
        $newrq = $this->create($data);
        $this->sendMail($newrq,1);
        return redirect($this->redirectTo);
    }

    public function create(array $data){

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

    public function sendMail(\App\Request $data, $type){
        // mail cho nguoi tao request
        $this->mail($data, User::find($data['create_by']),$type);

        //mail cho người thực hiện (nếu có)
        if (!is_null($data['assign_to'])){
            $this->mail($data, User::find($data['assign_to']),$type);
        }

        //mail cho người liên quan
        $relaters = Relater::all()->where('request_id',$data['id']);
        foreach ($relaters as $relater){
            $this->mail($data, User::find($relater['user_id']), $type);
        }
    }

    public function mail(\App\Request $data, User $user, $type){
        Mail::send('Notifi.mailNotifi', array(
            'person' => $user->name,
            'name' => $data['title'],
            'content' => $data['content'],
            'type' => $type,
        ), function ($msg) use ($data, $user) {
            $msg->to($user->email, env('typeNotifi.1'))->subject(env('typeNotifi.1') . " " . $data['title']);
        });
    }
}
