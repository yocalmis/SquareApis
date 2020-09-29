<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //
    public function index()
    {
      return "All users";
    } 
    
    
   public function register_old(Request $request)
   {
 
    try{

     $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'username' => 'required|unique:users|max:255|email:rfc,dns',
        'password' => 'required|max:255',
        'surname' => 'required|max:255',
     ]);
      
     if ($validator->fails()) { $res ["status"] = "Validate Error"; return response()->json($res);  }
   
     $user = new User();
     $user->name = $request->name;
     $user->surname = $request->surname;
     $user->username = $request->username;
     $user->password = md5($request->password);
     $user->email = $request->username;   
     $user->status = 1;   
     $user->member_type = 0;   
     $user->parent_id = 0;   
     $user->start_date = date("Y-m-d H:i:s");  
     $yil=date("Y"); $yil=$yil+20;
     $user->finish_date = $yil."-".date("m-d H:i:s");      
     $res ["status"] = ($user->save() ? "ok" : "error");    
     return response()->json($res);
     
    }
    catch (Exception $e) {

      // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
      $res ["status"] = $e->getMessage();       
      return response()->json($res);

    }

   }    



   public function register(Request $request)
   {
 
    try{

     $validator = Validator::make($request->all(), [
        'tel' => 'required|unique:users|max:14',
        'password' => 'required|max:255',
     ]);
      
     if ($validator->fails()) { $res ["status"] = "Validate Error"; return response()->json($res);  }
        
     $user = new User();
     $user->tel = $request->tel;
     $user->password = md5($request->password);
     $user->status = 0;   
     $user->member_type = 0;   
     $user->parent_id = 0;   
     $user->login_code = 847404; //rand(100000,999999);      
     $user->start_date = date("Y-m-d H:i:s");  
     $yil=date("Y"); $yil=$yil+20;
     $user->finish_date = $yil."-".date("m-d H:i:s");      
     $res ["status"] = ($user->save() ? "ok" : "error");   
     
     //sms gönder login_code

     return response()->json($res);
     
    }
    catch (Exception $e) {

      // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
      $res ["status"] = $e->getMessage();       
      return response()->json($res);

    }

   } 
   

   public function register_ok(Request $request)
   {
 
    try{

     $validator = Validator::make($request->all(), [
        'sms_code' => 'required|max:6'
     ]);
      
     if ($validator->fails()) { $res ["status"] = "Validate Error"; return response()->json($res);  }
      
     $user = User::where('login_code', $request->sms_code)
          ->update(['status' => 1]); // ,'login_code' => 1
          $res ["status"] = "ok";
          return response()->json($res);

    }
    catch (Exception $e) {

      // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
      $res ["status"] = $e->getMessage();       
      return response()->json($res);

    }

   } 











   public function login(Request $request)
   {
  
    try{

      $validator = Validator::make($request->all(), [
         'tel' => 'required|max:14',
         'password' =>  'required|max:255',
         'device' =>  'required|max:255'            
      ]);
       
      if ($validator->fails()) { $res ["status"] = "Validate Error"; return response()->json($res);  }
       

      $user = User::where('password', '=', md5($request->password))
      ->where('status', '=', 1)     
      ->where('tel', '=', $request->tel)
      ->orWhere('email', '=', $request->tel)     
      ->get();
                           
      if(count($user)>0){

        $token=Str::random(60);
        User::where('password', '=', md5($request->password))
        ->where('status', '=', 1)     
        ->where('tel', '=', $request->tel)
        ->orWhere('email', '=', $request->tel) 
        ->update(['key' => $token,'device' => $request->device]);

        $res ["status"] = "ok";
        $res ["token"] = $token;
        $res ["username"] = $user[0]->username;
        $res ["name"] = $user[0]->name;
        $res ["surname"] = $user[0]->surname;
        $res ["tel"] = $user[0]->tel;

      }  else{
        $res ["status"] = "failed";
      }                   
         
      return response()->json($res);
 
     }
     catch (Exception $e) {
 
       // echo 'Yakalanan olağandışılık: ',  $e->getMessage(), "\n";
       $res ["status"] = $e->getMessage();       
       return response()->json($res);
 
     }


   }
      
    public function get()
    {
        $id = 1; $key= "";      
        $user = User::find($id);
        return response()->json($user);

    }





}
