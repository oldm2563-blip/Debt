<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay($id, $exs_id){
        $user = User::findOrFail($id);
        $expense = Expense::findOrFail($exs_id);
        $pivotdata = $user->sharrer()->where('expense_id', $expense->id)->first();
        $amount = $pivotdata->pivot->amount;
        $user->sharrer()->detach($expense->id);
        $user->balance += $amount;
        $user->save();
        return back();
    }
}
