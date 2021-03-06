<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    public function __invoke(Request $request){
      if(!$token=auth()->attempt($request->only('name','password'))){
          return response('Wrong ID',401);
      }
      return response()->json([
        'token' => $token 
      ]);
    }
}
