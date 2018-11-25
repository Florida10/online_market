<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use View;
use Validator;
use App\M_user;
use Redirect;
use Hash;
use Session;

class Userscontroller extends Controller
{

    //getting main users view
    public function return_login()
    {
        return view('login');
    }

    public function return_register()
    {
        return view('user.register');
    }

    public function return_panel()
    {
        return view('welcome');
    }


    //validate data for user registration
    public function validate_user_input(Request $request)
    {
        //checking session
        $users = new M_user();
        if(Session::has('user')){
            //taking form data

            $user = Session('user');

            //getting the role of the user
             $return_roli = $users::where('USERNAME', '=', $user)->get();
            foreach ($return_roli as $roli){
                switch($roli->ROLI){
                    case 'supermarket':
                        $user_roli = 'user';
                        break;
                    case 'admin':
                        $user_roli = 'supermarket';
                        break;

                }
            }
             //checking 
            //checking if user_roli has value

            if(empty($user_roli)){
                $user_roli = 'klient';
            }

            $alldata = $request->all();

            //validating user input

            $rules = ['uname' => ['alpha_num', 'min:3', 'required'],
                'password' => ['alpha_num', 'min:6', 'max:15', 'required'],
                're-pass' => ['alpha_num', 'min:6', 'max:15', 'required'],
                'emer' => ['alpha_dash', 'min:3', 'max:20'],
                'gjinia' => ['alpha_num', 'required'],
                'qyteti' => ['alpha_num', 'min:3', ':max:30', 'required'],
                'adresa' => ['alpha_num', 'min:3', 'required'],
                'cel' => ['alpha_num', 'min:10', 'max:10', 'required'],
                'tel' => ['alpha_num', 'min:10', 'max:10', 'required'],
                'email' => ['required', 'email']
            ];


            //creating validator

            $validator = Validator::make($alldata, $rules);

            if ($validator->passes()) {
                //declaring object for model
//                $users = new M_user();


                //check password match
                if ($request->input('password') !== $request->input('re-pass')) {

                    return view('user.register')->with('message', 'Passwords doesent match!');

                }

                //check if the account already exists
                $return_data = $users::where('USERNAME', '=', $request->input('uname'))->orwhere('EMAIL', '=', $request->input('email'))->count();


                if ($return_data > 0) {
                    return view('user.register')->with('message', 'USERNAME OR EMAIL ALREADY EXISTS!');
                }

                //hashing password
                $hashed_pass = Hash::make($request->input('password'));


                //mapping data from form to the model and  save them into corresponding database table
                $users->USERNAME = $request->input('uname');
                $users->password = $hashed_pass;
                $users->EMER_MBIEMER = $request->input('emer');
                $users->gjinia = $request->input('gjinia');
                $users->qyteti = $request->input('qyteti');
                $users->adresa = $request->input('adresa');
                $users->cel = $request->input('cel');
                $users->tel = $request->input('tel');
                $users->email = $request->input('email');
                $users->roli  = $user_roli;
                $users->CR_DATE = date('Y-m-d');
                $users->last_update = date('Y-m-d');

                //insert data to db and checking if was succesfull
                if ($users->save() === true) {

                    return view('user.register')->with('message', 'USER REGISTRED SUCCESFULLY!');

                } else {

                    return view('user.register')->with('message', 'SOMETHING WENT WRONG PLEASE TRY AGAIN!');

                }

            }

            return view('user.register')->withErrors($validator);

        } else {
            return view('login')->with('message1','Please login to use the functions');
        }

    }
    //function for login
    public function user_login(Request $request)
    {
        //getting  data from user input
        $user_Data = input::all();

        //creating validation rules

        $rules = ['username' => ['alpha_num', 'min:3', 'required'],
            'password' => ['alpha_num', 'min:6', 'max:15', 'required']
        ];

        //creating validator
        $validator = validator::make($user_Data, $rules);

        //hashing password
        //$password_hsh = $request->input('password');


        if ($validator->fails()) {
            //return login view with errors1
            return view( 'login')->withErrors($validator);
        } else {
            $users = new M_user();
            //add the logic for login

            //check if account  exists
            $user_get_data = $users->where('username', '=', $request->input('username'), 'and', 'password', '=', $request->input('password'))->count();
            $user_data =  $users->where('username', '=', $request->input('username'), 'and', 'password', '=', $request->input('password'))->get();
            //check user_get_data
            if ($user_get_data > 0) {
                //start the session
                //checking the returned data against
                foreach ($user_data as $key){
                    if($key->USERNAME  === $request->input('username')  AND $key->PASSWORD === $request->input('password')){
                        //start session
                        //redirect to user panel view
                        Session::put('user',$request->input('username'));
                         switch($key->ROLI) {
                             case "user":
                                 return view('user.panel');
                                 break;
                                 //case for admin
                             case "admin":
                                 return view('admin.index');
                                 break;
                                //case for supermarket
                             case "supermarket":
                                 return view('supermarket.panel');
                                 break;//case for client
                             case "klient":
                                 return view('klient.panel');
                                 break;
                             default:
                                 return view('login')->with('message1','Account problem please try again');
                         }

                    }
                }

            } else {
                //return login with error
                return view('login')->with('message1', 'Error login in / please try again');
            }
        }
    }
}


