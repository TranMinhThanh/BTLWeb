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
    public function editRequest(Request $request){
        $data =$request->all();
        $this ->editValidator($data)->validate();
        $this->edit($data);
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
        $news->save();
        //thay doi nguoi lien quan
//        if($news->relater != $data['team']){
//            $news->team = $data['team'];
//        }

    }
    public function createRequest(Request $request)
    {
        $data = $request->all();
        $this->validator($data)->validate();
        $this->create($data);
        if (!emptyArray($data['relater'])){
            foreach ($data['relater'] as $relater)
                RelaterController::create($this->id,$relater);
        }

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
}
