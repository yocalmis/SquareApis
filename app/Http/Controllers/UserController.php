<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function index()
    {
      return "All users";
    } 
    
    
   public function register(Request $request)
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
   
   public function login()
   {
    $id = 1; $key= "";   
    $user = User::find($id);
    return response()->json($user);
   }
      
    public function get()
    {
        $id = 1; $key= "";      
        $user = User::find($id);
        return response()->json($user);

    }





}
