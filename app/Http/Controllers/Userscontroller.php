<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Validator;
use App\M_user;

class Userscontroller extends Controller
{

	//getting main users view
    public function return_login(){
    	return view('login');
    }

    public function return_register(){
    	return view('user.register');
    }

    public function return_panel(){
    	return view('panel');
    }

    //validate data for user registration
    public function validate_user_input(Request $request){

        //taking form data 
        $alldata = $request->all();

        //validating user input

        $rules = ['uname'   =>['alpha_num','min:3','required'],
                  'password'=>['alpha_num','min:6','max:15','required'],
                  'emer'    =>['alpha_num','min:3','max:20'],
                  'gjinia'  =>['alpha_num','required'],
                  'qyteti'  =>['alpha_num','min:3',':max:30','required'],
                  'adresa'  =>['alpha_num','min:3','required'],
                  'cel'     =>['alpha_num','min:10','max:10','required'],
                  'tel'     =>['alpha_num','min:10','max:10','required'],
                  'email'   =>['required','email']
                  ];  


       //creating validator 

                  $validator = Validator::make($alldata,$rules);

                  if($validator->passes()){
                    //check if the account already exists

                    //insert data to db
                    $users = new M_user();

                    //mapping data from form to the model and  save them into corresponding database table
                    $users->USERNAME  = $request->input('uname');
                    $users->password = $request->input('password');
                    $users->EMER_MBIEMER    = $request->input('emer');
                    $users->gjinia   = $request->input('gjinia');
                    $users->qyteti   = $request->input('qyteti');
                    $users->adresa   = $request->input('adresa');
                    $users->cel      = $request->input('cel');
                    $users->tel      = $request->input('tel');
                    $users->email    = $request->input('email');
                    $users->CR_DATE  = date('Y-m-d');
                    $users->last_update = date('Y-m-d');

                    if ($users->save() === true ){

                    return view('user.register')->with('message', 'USER REGISTRED SUCCESFULLY!');

                    } else{

                      return view('user.register')->with('message', 'SOMETHING WENT WRONG PLEASE TRY AGAIN!');

                    }

                  }

                  return view('user.register')->withErrors($validator);
    }

}
