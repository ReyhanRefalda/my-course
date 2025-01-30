<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments.
     */
    public function index()
    {
        $paymentExists = Payment::exists();
        $payments = Payment::all();

        return view('admin.payments.index', compact('payments', 'paymentExists'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        return view('admin.payments.create');
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        // Create a new payment record
        Payment::create([
            'bank_name' => $request->bank_name,
            'number' => $request->number,
            'account_name' => $request->account_name,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Show the form for editing the specified payment.
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);

        return view('admin.payments.edit', compact('payment'));
    }

    /**
     * Update the specified payment in storage.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'bank_name' => 'required|string|max:255',
            'number' => 'required|numeric',
            'account_name' => 'required|string|max:255',
        ]);

        $payment->update([
            'bank_name' => $request->bank_name,
            'number' => $request->number,
            'account_name' => $request->account_name,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->delete();

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
