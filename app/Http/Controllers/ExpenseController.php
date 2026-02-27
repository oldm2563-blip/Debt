<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function create_expense(Request $request, Accommodation $coloc){
        $incomingFields = $request->validate([
            'title' => 'required',
            'amount' => 'required',
            'category_id' => 'required',
        ]);
        $incomingFields['paid_by'] = auth()->id();
        $incomingFields['accommodation_id'] = $coloc->id;
        $expense = Expense::create($incomingFields);
        $users = $coloc->users;
        $shared = $expense->amount / count($users);
        foreach($users as $user){
            $balance = $user->balance;
            $balance = $balance - $shared;
            if($user->id !== auth()->id()){
                $expense->shares()->attach($user->id, ['amount' => $shared]);
                $user->balance = $balance;
                $user->save();
            }
        }
        return back();
    }
}
