<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;
use App\Models\User;

class WithdrawController extends Controller
{
    /**
     * Show the withdrawal form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $balance = $user->balance; // Ambil saldo pengguna

        return view('admin.withdraw.index', compact('balance'));
    }

    /**
     * Handle withdrawal request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ], [
            'amount.required' => 'The withdrawal amount is required.',
            'amount.numeric' => 'The withdrawal amount must be a number.',
            'amount.min' => 'The withdrawal amount must be at least 1.',
        ]);
    
        $user = Auth::user();
        $amount = $request->input('amount');
    
        // Check if the balance is sufficient
        if ($user->balance < $amount) {
            return redirect()->back()->with('error', 'Your balance is insufficient for this withdrawal.');
        }
    
        // Deduct the balance
        $user->balance -= $amount;
        $user->save();
    
        // Record the withdrawal
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $amount,
        ]);
    
        return redirect()->route('admin.withdraw.index')->with('success', 'Withdrawal was successfully processed.');
    }
    
}
