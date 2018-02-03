<?php

namespace Ojlinks\Http\Controllers\Auth;

use Ojlinks\User;
use Ojlinks\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = '/';

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
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Ojlinks\User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname'=>$data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /*The methods that follow are NOT part of the out of the box method*/

    /**
     * I make the user go through an 'attempt registration' in the course of which their email address is verified before an actual 
     * registration takes place. This is because Laravel Auth system by default does not implement email verification
     */
    public function attempt_registration(Request $request){
        $user_inputs = $request->all();
        $validation = $this->validator($user_inputs);    
        if($validation->fails()){
            return redirect('/register')->withInput()->withErrors($validation);
        }
       
        $key = $this->keyString(30);    
        session(['user_inputs'=>$user_inputs, 'key'=>$key]);
        $email = $request->input('email');
        $this->sendActivationMail($email, $key);
        return view("auth.attempt_registration")->with('email', $email);
    }
    public function sendActivationMail(string $email, string $key){
        $to = $email;
        $subject = "Account Activation";
        $message = "Click the link provided to activate your account http://ojlinks.dev/attempt_activation?key=".$key;
        $headers = "From: <info@ojlinks.tochukwu.xyz>"; 
        mail($to, $subject, $message, $headers);
    }
    /*
    *Random string generator
    */
    public function keyString($key_len){
        $chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $chars_array=str_split($chars);
        $key="";
        for($i=0;$i<$key_len;$i++)
        {
            $randKey=array_rand($chars_array);
            $key.=$chars_array[$randKey];
        }
        return $key;
    }
    public function attempt_activation(Request $request){        
        if($request->input('key')==session('key')){
            return $this->register(session('user_inputs'));
        }
    }
    public function register(array $user_inputs){
        $this->validator($user_inputs)->validate();

        event(new Registered($user = $this->create($user_inputs)));

        $this->guard()->login($user);

        return  redirect($this->redirectPath());
    }
     
}
