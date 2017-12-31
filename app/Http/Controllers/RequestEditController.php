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
        $request->load('assign_to');
        $request->load('team');

        $relaters = Relater::all()->where('request_id',$request['id']);
        $relaters->load('user_id');
        $data['teams'] = $teams;
        $data['request'] = $request;
        $data['relaters'] = $relaters;
        return view('editRequest', $data);

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

        //update relater
        $relaters = Relater::all()->where('request_id',$id);
        $relaterIds = [];
        foreach ($relaters as $relater){
            $relaterIds []= $relater['id'];
        }
        $newRelaterIds = $this->getRelaterId($data['relater']);
        $diffRelaters = array_diff($relaterIds,$newRelaterIds);
        $diffNewRelaters = array_diff($newRelaterIds,$relaterIds);
        foreach ($diffRelaters as $diffRelater)
            Relater::where('user_id', $diffRelater)->delete();
        foreach ($diffNewRelaters as $diffNewRelater)
            RelaterController::create($id,$diffNewRelater);


    }
}