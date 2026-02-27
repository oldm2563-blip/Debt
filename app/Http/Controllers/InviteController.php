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
            if($invitation->email === auth()->user()->email && !$invitation->expires_at){
                return view('invite', ['invite' => $invitation]);
            }
            else{
                abort(403);
            }
        }
        else{
            return redirect('/dashboard');
        }
    }
    public function accept($token){
        $invite = Invitation::where('token', $token)->first();
        $invite->expires_at = now();
        $coloc = Accommodation::find($invite->accommodation_id);
        $user = auth()->user();
        $user->accommodations()->attach($coloc->id, ['role' => 'member']);
        $invite->save();
        return redirect('/coloc/' . $coloc->token);
    }
}
