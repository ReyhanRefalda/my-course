<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\SubscribeTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscribeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = SubscribeTransaction::with(['user'])->orderByDesc('id')->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscribeTransaction $subscribeTransaction)
    {
        return view('admin.transactions.show', compact('subscribeTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscribeTransaction $subscribeTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscribeTransaction $subscribeTransaction)
{
    DB::transaction(function () use ($subscribeTransaction) {
        
        $totalAmount = $subscribeTransaction->total_amount;
        $owners = User::role('owner')->get();
        $teachers = User::role('teacher')->get();

        $totalOwner = $owners->count();
        $totalTeacher = $teachers->count();

        $benefitOwner = $totalAmount * 0.5;
        $benefitTeacherTotal = $totalAmount * 0.5;
        $teacherPerShare = $totalTeacher > 0 ? $benefitTeacherTotal / 50 : 0;
        $distributedBenefitTeacher = $teacherPerShare * $totalTeacher;
        $remainingMoney = $benefitTeacherTotal - $distributedBenefitTeacher;

        $benefitOwner += $remainingMoney;

        foreach ($owners as $owner) {
            $owner->increment('balance', $benefitOwner / $totalOwner);
        }

        foreach ($teachers as $teacher) {
            $teacher->increment('balance', $teacherPerShare);
        }

        $subscribeTransaction->update([
            'is_paid' => true,
            'subscription_start_date' => Carbon::now(),
        ]);
    });

    return redirect()->route('admin.subscribe_transactions.show', $subscribeTransaction);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscribeTransaction $subscribeTransaction)
    {
        //
    }
}
