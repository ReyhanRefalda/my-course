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
    public function index()
    {
        $user = Auth::user();
        $balance = $user->balance;
    
        // Ambil data withdrawal berdasarkan user dan status
        $withdrawals = Withdrawal::where('user_id', $user->id)
                                  ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu
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
            'amount.required' => 'Jumlah penarikan harus diisi.',
            'amount.numeric' => 'Jumlah penarikan harus berupa angka.',
            'amount.min' => 'Jumlah penarikan minimal adalah 1.',
        ]);

        $user = Auth::user();
        $amount = $request->input('amount');

        // Cek apakah saldo mencukupi
        if ($user->balance < $amount) {
            return redirect()->back()->with('error', 'Saldo Anda tidak mencukupi.');
        }

        // Buat permintaan penarikan dengan status pending
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.withdraw.index')->with('success', 'Permintaan penarikan berhasil diajukan. Menunggu persetujuan.');
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
        $withdrawals = Withdrawal::whereIn('status', ['pending', 'approved'])->get();
    
        return view('admin.withdraw.manage', compact('withdrawals'));
    }
    
    

    /**
     * Owner menyetujui penarikan saldo.
     */
    public function approve(Request $request, $id)
    {
        // Validasi file bukti
        $request->validate([
            'proof_file' => 'required|file|mimes:jpg,png,pdf|max:2048', // Validasi file bukti
        ]);
    
        // Ambil data penarikan berdasarkan ID
        $withdrawal = Withdrawal::findOrFail($id);
    
        // Cek jika status bukan 'pending', jika sudah diproses, beri pesan error
        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses.');
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
        return redirect()->route('admin.withdraw.manage')->with('success', 'Penarikan berhasil disetujui.');
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
            return redirect()->back()->with('error', 'Permintaan ini sudah diproses.');
        }
    
        // Update status menjadi 'rejected'
        $withdrawal->update([
            'status' => 'rejected',
        ]);
    
        // Redirect dengan pesan sukses
        return redirect()->route('admin.withdraw.manage')->with('success', 'Permintaan penarikan berhasil ditolak.');
    }
    
}
