<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $error = Validator::make($data, [
            'name' => 'required|string|max:255',
            'user_id' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'gender' => 'required',
            'level' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
//       dump($error);
//        if($data['level'] != 0){
//            $teamError = Validator::make($data,[
//                'team'=> 'required',
//            ]);
//        //    $error = array_merge($error,$teamError);
//        }
        return $error;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'user_id' => $data['user_id'],
            'age' => $data['age'],
            'address' => $data['address'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'level' => $data['level'],
            'team_id' => null,
            'password' => bcrypt($data['password']),
        ]);
    }
}
