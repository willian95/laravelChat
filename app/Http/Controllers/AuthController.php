<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    
    function register(Request $request){

        try{

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json(["success" => true, "msg" => "Registro realizado"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function login(Request $request){

        try{

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json(["success" => true, "msg" => "Has ingresado", "user_id" => Auth::user()->id]);
            }else{
                return response()->json(["success" => false, "msg" => "Credenciales no existen"]);
            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function logout(){

        Auth::logout();
        return response()->json(["success" => true, "msg" => "Has cerrado sesións"]);

    }

}
