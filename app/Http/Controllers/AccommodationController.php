<?php

namespace App\Http\Controllers;

use App\Mail\InviteUserMail;
use App\Models\Accommodation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccommodationController extends Controller
{
    public function create(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => 'required'
        ]);
        $token = Str::random(12);

        while (Accommodation::where('token', $token)->exists()) {
            $token = Str::random(12);
        }
        $user = auth()->user();
        if (!$user->accommodations()->exists()) {
            $coloc = Accommodation::create([
                'name' => $incomingFields['name'],
                'token' => $token
            ]);
            $user->accommodations()->attach($coloc->id, ['role' => 'owner']);
            return redirect('/coloc/' . $coloc->token);
        }
    }
    public function coloc($token)
    {
        $coloc = Accommodation::where('token', $token)->first();
        $users = $coloc->users;
        return view('coloc', ['users' => $users, 'coloc' => $coloc, 'expenses' => []]);
    }
    public function invite(Request $request, Accommodation $coloc)
    {
        $incomingFields = $request->validate([
            'email' => ['required', 'email']
        ]);
        $token = Str::random(50);

        while (Invitation::where('token', $token)->exists()) {
            $token = Str::random(50);
        }
        $invite = Invitation::create([
            'accommodation_id' => $coloc->id,
            'email' => $incomingFields['email'],
            'token' => $token
        ]);
        Mail::to($incomingFields['email'])
            ->send(new InviteUserMail(auth()->user()->name, $invite->token));
        return back();
    }
}
