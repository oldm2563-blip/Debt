<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        if(auth()->user()->accommodations()->exists()){
            $coloc = auth()->user()->accommodations()->first();
            if($coloc->state === 'canceled'){
                return view('newstart');
            }
            return redirect('/coloc/' . $coloc->token);
        }
        auth()->user()->balance = 0.00;
        auth()->user()->save();
        return view('newstart');
    }
    public function ban(User $user){
        $user->is_banned = true;
        $user->save();
        return back();
    }
    public function unban(User $user){
        $user->is_banned = false;
        $user->save();
        return back();
    }
}
