<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Notifications\PaymentRejected;
use Spatie\Permission\Models\Role;
use App\Models\SubscribeTransaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\PaymentApproved;


class SubscribeTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $packageType = $request->input('package_type');
        $status = $request->input('status');

        $transactions = SubscribeTransaction::with(['user', 'package'])
            ->whereHas('user', function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%{$search}%");
                }
            })
            ->when($packageType, function ($query) use ($packageType) {
                $query->whereHas('package', function ($q) use ($packageType) {
                    $q->where('tipe', $packageType);
                });
            })
            ->when($status, function ($query) use ($status) {
                if ($status === 'PENDING') {
                    $query->where('status', '=', 'pending');
                } elseif ($status === 'ACTIVE') {
                    $query->where('status', '=', 'approved')->where('expired_at', '>=', now());
                } elseif ($status === 'EXPIRED') {
                    $query->where('status', '=', 'approved')->where('expired_at', '<', now());
                } elseif ($status === 'REJECTED') {
                    $query->where('status', '=', 'rejected');
                }
            })
            ->orderByDesc('id')
            ->paginate(5)->appends($request->query());
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
        // dd($subscribeTransaction);
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
        DB::transaction(function () use ($request, $subscribeTransaction) {
            $status = $request->input('status'); // Pastikan mendapatkan status dengan aman

            // Jika transaksi disetujui (approved)
            if ($status === 'approved') {
                // dd('approve');
                // Proses distribusi saldo
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

                // Distribusi balance ke owner
                foreach ($owners as $owner) {
                    $owner->increment('balance', $benefitOwner / $totalOwner);
                }

                // Distribusi balance ke teacher
                foreach ($teachers as $teacher) {
                    $teacher->increment('balance', $teacherPerShare);
                }

                // Mengambil package berdasarkan transaksi
                $package = Package::findOrFail($subscribeTransaction->package_id);

                // Update status transaksi langganan ke "approved"
                $subscribeTransaction->update([
                    'status' => 'approved',
                    'subscription_start_date' => Carbon::now(),
                    'expired_at' => Carbon::now()->addDays(match ($package->tipe) {
                        'daily' => 1,
                        'weekly' => 7,
                        'monthly' => 30,
                        'yearly' => 365,
                        default => 0,
                    }),
                ]);

                // Kirimkan notifikasi approval ke student
                $subscribeTransaction->user->notify(new PaymentApproved($subscribeTransaction));
            }

            // Jika transaksi ditolak (rejected)
            elseif ($status === 'rejected') {
                // dd('rejected');
                // Ambil reason, jika kosong gunakan default
                $reason = $request->filled('reason') ? $request->input('reason') : 'Your payment was rejected';
                
                // Update status transaksi langganan menjadi rejected & simpan reason
                $subscribeTransaction->update([
                    'status' => 'rejected',
                    'rejection_reason' => $reason, // Simpan reason ke kolom rejection_reason
                ]);

                // Kirimkan notifikasi penolakan dengan alasan
                $subscribeTransaction->user->notify(new PaymentRejected($subscribeTransaction, $reason));
            }
        });

        // Redirect dengan pesan sukses
        return redirect()->route('admin.subscribe_transactions.show', $subscribeTransaction)
            ->with('success', 'Subscribe transaction updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscribeTransaction $subscribeTransaction)
    {
        //
    }
}
