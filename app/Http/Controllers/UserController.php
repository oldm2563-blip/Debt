<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        if(auth()->user()->accommodations()->exists()){
            $coloc = auth()->user()->accommodations()->first();
            return redirect('/coloc/' . $coloc->token);
        }
        return view('newstart');
    }
}
