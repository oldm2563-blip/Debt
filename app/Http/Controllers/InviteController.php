<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Invitation;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function form($token){
        if(!auth()->user()->accommodations()->exists()){
        $invitation = Invitation::where('token', $token)->firstOrFail();
        return view('invite', ['invite' => $invitation]);
        }
        else{
            return redirect('/dashboard');
        }
    }
    public function accept($token){
        $invite = Invitation::where('token', $token)->first();
        $coloc = Accommodation::find($invite->accommodation_id);
        $user = auth()->user();
        $user->accommodations()->attach($coloc->id, ['role' => 'member']);
        return redirect('/coloc/' . $coloc->token);
    }
}
