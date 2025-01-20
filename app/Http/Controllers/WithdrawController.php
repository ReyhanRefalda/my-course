<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;
use App\Models\User;

class WithdrawController extends Controller
{
    /**
     * Tampilkan form penarikan saldo untuk teacher.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $balance = $user->balance;

        // Ambil parameter filter
        $status = $request->get('status');
        $date = $request->get('date');

        // Query withdrawals
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.withdraw.index', compact('balance', 'withdrawals'));
    }





    /**
     * Teacher melakukan permintaan penarikan saldo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ], [
            'amount.required' => 'The withdrawal amount must be filled in.',
            'amount.numeric' => 'The withdrawal amount must be a number.',
            'amount.min' => 'The minimum withdrawal amount is 1.',
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        // Cek apakah saldo mencukupi
        if ($user->balance < $amount) {
            return redirect()->back()->with('error', 'Your balance is insufficient.');
        }

        // Buat permintaan penarikan dengan status pending
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.withdraw.index')->with('success', 'Withdrawal request submitted successfully. Waiting for approval');
    }

    /**
     * Tampilkan permintaan penarikan untuk owner.
     */
    public function manage()
    {
        // Ensure only users with the 'owner' role can access
        if (!auth()->user()->hasRole('owner')) {
            abort(403, 'Unauthorized action.');
        }

        // Retrieve withdrawal requests with 'pending' or 'approved' status
        $withdrawals = Withdrawal::whereIn('status', ['pending', 'approved'])->orderByDesc('id')->get();

        return view('admin.withdraw.manage', compact('withdrawals'));
    }



    /**
     * Owner menyetujui penarikan saldo.
     */
    public function approve(Request $request, $id)
    {
        // Validasi file bukti
        $request->validate(
            [
                'proof_file' => 'required|file|mimes:jpg,png,pdf|max:20048', // Validasi file bukti
            ],
            [
                'proof_file.required' => 'proof must be filled in.',
            ]
        );

        // Ambil data penarikan berdasarkan ID
        $withdrawal = Withdrawal::findOrFail($id);

        // Cek jika status bukan 'pending', jika sudah diproses, beri pesan error
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has been processed.');
        }

        // Simpan file bukti yang diupload
        $filePath = $request->file('proof_file')->store('proofs', 'public');

        // Update status dan tambahkan file bukti
        $withdrawal->update([
            'status' => 'approved',
            'proof_file' => $filePath,
        ]);

        // Kurangi saldo user (teacher)
        $user = $withdrawal->user;
        $user->decrement('balance', $withdrawal->amount);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.withdraw.manage')->with('success', 'Withdrawal successfully approved.');
    }


    /**
     * Owner menolak permintaan penarikan.
     */
    public function reject($id)
    {
        // Ambil data penarikan berdasarkan ID
        $withdrawal = Withdrawal::findOrFail($id);

        // Cek jika status bukan 'pending', jika sudah diproses, beri pesan error
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has been processed.');
        }

        // Update status menjadi 'rejected'
        $withdrawal->update([
            'status' => 'rejected',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.withdraw.manage')->with('success', 'The withdrawal request was successfully rejected.');
    }
}
