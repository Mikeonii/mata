<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(Request $request){
    	$new = new User;
    	$new->name = $request->input('name');
    	$new->email = $request->input('email');
    	$new->password = Hash::make($request->input('password'));
    	$new->branch_id = $request->input('branch_id');
    	$new->location = $request->input('location');
    	$new->save();
    }
}
