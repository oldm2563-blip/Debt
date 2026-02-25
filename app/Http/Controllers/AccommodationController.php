<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\User;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function create(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => 'required'
        ]);
        $user = auth()->user();
        if(!$user->accommodations()->exists()){
            $coloc = Accommodation::create($incomingFields);
            $user->accommodations()->attach($coloc->id, ['role' => 'owner']);
            return redirect('/coloc/' . $coloc->id);
        }
        
    }
    public function coloc(Accommodation $coloc){
        $users = $coloc->users;
        return view('coloc', ['users' => $users, 'coloc' => $coloc, 'expenses' => []]);
    }
    
}
