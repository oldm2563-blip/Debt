<?php

namespace App\Http\Controllers;

use App\Mail\InviteUserMail;
use App\Models\Accommodation;
use App\Models\Category;
use App\Models\Expense;
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
        if (auth()->user()->accommodations()->exists()) {
            $coloc = Accommodation::where('token', $token)->first();
            $users = $coloc->users;
            $expenses = $coloc->expenses;
            $payments = $coloc->payments;
            $categories = $coloc->categories;
            return view('coloc', ['users' => $users, 'coloc' => $coloc, 'expenses' => $expenses, 'payments' => $payments, 'categories' => $categories]);
        }
        else{
            abort(403);
        }
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
    public function create_category(Request $request, Accommodation $coloc)
    {
        $incomingFields = $request->validate([
            'name' => 'required'
        ]);
        $incomingFields['accommodation_id'] = $coloc->id;
        Category::updateOrCreate($incomingFields);
        return back();
    }



    public function quit(User $user, Accommodation $coloc)
    {
        if ($user->balance >= 0) {
            $user->reputation += 1;
        } else {
            $user->reputation -= 1;
            $total = $user->sharrer()->sum('expense_share.amount');
            $expense = Expense::create([
                'title' => $user->name . 'left over',
                'amount' => $total,
                'category_id' => 2,
                'paid_by' => auth()->id(),
                'accommodation_id' => $coloc->id
            ]);
            $user->balance = 0;
            $members = $coloc->users->where('id', '!=', $user->id);
            $shared = $expense->amount / count($members);
            foreach ($members as $member) {
                $balance = $member->balance;
                $balance = $balance - $shared;

                $expense->shares()->attach($member->id, ['amount' => $shared]);
                $member->balance = $balance;
                $member->save();
            }
        }
        $user->sharrer()->detach();
        $user->accommodations()->detach($coloc->id);
        $user->save();
        return redirect('/dashboard');
    }

    public function kick(User $user, Accommodation $coloc)
    {
        if ($user->balance >= 0) {
            $user->reputation += 1;
        } else {
            auth()->user()->reputation -= 1;
            $total = $user->sharrer()->sum('expense_share.amount');
            $expense = Expense::create([
                'title' => $user->name . 'left over',
                'amount' => $total,
                'category_id' => 2,
                'paid_by' => $user->id,
                'accommodation_id' => $coloc->id
            ]);
            $user->balance = 0;
            $expense->shares()->attach(auth()->id(), ['amount' => $total]);
            auth()->user()->balance -= $total;
            auth()->user()->save(); 
        }

        $user->sharrer()->detach();
        $user->accommodations()->detach($coloc->id);
        $user->save();
        return back();
    }
}
