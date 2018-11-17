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
    	return view('user.login');
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
                  're-pass' =>['alpha_num','min:6','max:15','required'],
                  'emer'    =>['alpha_dash','min:3','max:20'],
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
                    //declaring object for model
                    $users = new M_user();


                  //check password match
                  if ($request->input('password')  !== $request->input('re-pass')){

                   return view('user.register')->with('message', 'Passwords doesent match!');

                  }

                    //check if the account already exists
                    $return_data = $users::where('USERNAME','=',$request->input('uname'))->orwhere('EMAIL','=',$request->input('email'))->count();
                  

                    if($return_data > 0){
                      return view('user.register')->with('message', 'USERNAME OR EMAIL ALREADY EXISTS!');
                    }

                    
                    //mapping data from form to the model and  save them into corresponding database table
                    $users->USERNAME        = $request->input('uname');
                    $users->password        = $request->input('password');
                    $users->EMER_MBIEMER    = $request->input('emer');
                    $users->gjinia          = $request->input('gjinia');
                    $users->qyteti          = $request->input('qyteti');
                    $users->adresa          = $request->input('adresa');
                    $users->cel             = $request->input('cel');
                    $users->tel             = $request->input('tel');
                    $users->email           = $request->input('email');
                    $users->CR_DATE         = date('Y-m-d');
                    $users->last_update     = date('Y-m-d');
                    
                    //insert data to db and checking if was succesfull
                    if ($users->save() === true ){

                    return view('user.register')->with('message', 'USER REGISTRED SUCCESFULLY!');

                    } else{

                      return view('user.register')->with('message', 'SOMETHING WENT WRONG PLEASE TRY AGAIN!');

                    }

                  }

                  return view('user.register')->withErrors($validator);
    }

    //public function for authenticating user login
        public function user_login(Request $request) {

             //checking if data are  empty
              
              if((empty($request->input('username')))  or  (empty($request->input('password')))) {

                return view('user.login')->with('message','Please fill the required fields');

              } else {
                //checking  if data match to any account in  table
                 $users = new M_user();
                 
                 //getting data 
                 $user_data =$users::where('USERNAME','=',$request->input('username'),'and','PASSWORD','=',$request->input('password'));;
                 
                 //counting data
                  $count_return = $users::where('USERNAME','=',$request->input('username'),'and','PASSWORD','=',$request->input('password'))->count();

                  if($count_return == 0 ){

                    return view('user.login')->with('message','No account exists with input data!');

                  } else {
                    //check again if data are the  same 
                    foreach ($user_data as $key => $value) {
                      
                       if($value['USERNAME'] === $request->input('username') and  $value['PASSWORD'] ===$request->input('password')  ) {
                         //initialize session and redirect to corresponding panel
                         switch($value['ROLI']){
                             case "user":
                                return view('user.panel');
                             break;

                             default:
                                return view('user.login')->with('message','Something went wrong!');
                         }
                       }

                    }

                  }

              }
            

        }

}
