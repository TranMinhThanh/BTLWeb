<?php

namespace App\Http\Controllers;

use App\Relater;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Mail;
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
        $this->getRelaterId($request['relater']);
        $this->validator($data)->validate();
        $newRequest = $this->create($data);
        // xu ly luu anh
        $images = $request->file("file");
        if(!empty($images)){
            foreach ($images as $image){
                $imageCtrl = new ImageController();
                $imageCtrl->storeImage($newRequest,$image);
            }
        }
        $relaters = $this->getRelaterId($data['relater']);
        // lay mail cua nguoi lien quan vaf gui
        if($relaters!= null){
            foreach ($relaters as $relater) {
                $emailRelaters = User::where('user_id', $relater)->get();
                if ($emailRelaters != null) {
                    foreach ($emailRelaters as $emailRelater) {
                        $email = $emailRelater->email;
                        dump($email);
                        Mail::send('Notifi.mailNotifi', array('type' => env('typeNotifi.1'), 'person' => Auth::user()->name, 'name' => $data['title'], 'content' => $data['content']), function ($msg) use ($email) {
                            $msg->from('btlweb.uet@gmail.com', 'btlweb');
                            $msg->to($email, env('typeNotifi.1'));
                        });
                    }
                }
            }
        }
        // mail cho ca nguoi tao request
        $user = Auth::user()->email;
        Mail::send('Notifi.mailNotifi',array('type'=>env('typeNotifi.1'), 'person'=>Auth::user()->name ,'name'=>$data['title'],'content'=>""),function($msg) use($user){
            $msg->from('btlweb.uet@gmail.com','btlweb');
            $msg->to($user,env('typeNotifi.1'));
    });
    }

    //lay id cua nguoi lien quan
    private function getRelaterId($data){
        $arrayId = array();
        $i = 0;
        if (!empty($data)) {
            $arrayRelater = explode(',', $data);
            foreach ($arrayRelater as $relater) {
                // sử lý để lấy user_id của người liên quan VD a[id]
                $item = explode("[", $relater); //-> item[1]= "id]"
                if (count($item) >= 2) {
                    $relater_id = explode("]", $item[1]); //-> realter_id[0]=id
                    $arrayId[$i] = $relater_id[0];
                    dump($arrayId);
                    $i++;
                }
            }
        }
        return $arrayId;
    }
    public function create(array $data){
//        if ($data['relater'].)
        $request = \App\Request::create([
            'title' => $data['title'],
            'create_by' => Auth::id(),
            'content' => $data['content'],
            'status' => '1',
            'priority' => $data['priority'],
            'deadline' => $data['deadline'],
            'team_id' => $data['team'],
        ]);
        return $request;
      //  protected $redirectTo = '/createRequest';
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
