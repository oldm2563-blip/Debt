<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(){
        $users = User::all();
        $colocations = Accommodation::all();
        return view('admin.dashboard', ['users' => $users, 'colocs' => $colocations]);
    }
}
