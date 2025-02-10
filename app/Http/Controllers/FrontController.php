<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Artikel;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SubscribeTransaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubscribeTransactionRequest;

class FrontController extends Controller
{
    //

    public function index()
    {
        $courses = Course::with(['categories', 'teacher', 'students']) // Ganti 'category' menjadi 'categories'
            ->orderByDesc('id')
            ->get();

        $categories = Category::all();

        return view('front.index', compact('courses', 'categories'));
    }


    public function detail(Course $course)
    {
        // Ambil video kursus dengan logika sesuai role
        $user = auth()->user();
        $userRole = $user ? $user->getRoleNames()->first() : 'student';

        $courseVideos = $course->course_videos()
            ->when($userRole === 'owner', function ($query) {
                return $query->withTrashed(); // Tampilkan semua video termasuk yang dihapus
            })
            ->when($userRole === 'teacher', function ($query) {
                return $query->withTrashed(); // Tampilkan semua video termasuk yang dihapus
            })
            ->when($userRole === 'student', function ($query) {
                return $query->whereNull('deleted_at'); // Hanya tampilkan video yang tidak dihapus
            })
            ->get();

        return view('front.details', compact('course', 'courseVideos'));
    }

    public function learning($courseId, $courseVideoId)
    {
        $user = Auth::user();

        if (
            !($user->hasRole('owner') ||
                $user->hasRole('teacher') ||
                ($user->hasRole('student') && $user->hasActiveSubscription()))
        ) {
            return redirect()->route('front.pricing');
        }

        $course = Course::with(['categories', 'course_videos' => function ($query) use ($courseVideoId) {
            $query->where('id', $courseVideoId)->whereNull('deleted_at');
        }])->where('id', $courseId)->whereNull('deleted_at')->first();

        if (!$course || $course->course_videos->isEmpty()) {
            return redirect()->route('front.courses')->with('error', 'Course or video not found or has been removed.');
        }

        $video = $course->course_videos->first();

        // Tambahkan ke pivot hanya untuk student dengan 1 role
        if ($user->hasRole('student') && $user->roles->count() === 1) {
            $user->courses()->syncWithoutDetaching($course->id);
        }

        $categories = $course->categories->pluck('name');

        return view('front.learning', compact('course', 'video', 'categories'));
    }



    public function pricing()
    {
        // $packages = Package::all();
        $packages = Package::orderByRaw("
            FIELD(tipe, 'daily', 'weekly', 'monthly', 'yearly')
        ")->orderBy('harga', 'asc')->get();

        return view('front.pricing', compact('packages'));
    }

    public function checkout($packageId)
    {
        $package = Package::findOrFail($packageId);
        $payment = Payment::first();
        // $payments = Payment::all();
        if (!$payment) {
            abort(404, 'Payment details not found.');
        }

        if (Auth::check() && Auth::user()->hasActiveSubscription()) {
            $user = Auth::user();
            $currentPackage = $user->subscribe_transactions()
                ->where('is_paid', true)
                ->where('expired_at', '>=', now())
                ->latest('expired_at')
                ->first()->package;
            // dd($currentPackage);

            // Jika paket yang dipilih sama atau lebih rendah dari paket aktif
            if ($package->harga <= $currentPackage->harga) {
                return redirect()->route('front.pricing');
            }
        }

        return view('front.checkout', compact('package', 'payment'));
    }

    public function checkout_store(StoreSubscribeTransactionRequest $request)
    {
        $user = Auth::user();

        // if (Auth::user()->hasActiveSubscription()) {
        //     return redirect()->route('front.index');
        // }

        DB::transaction(function () use ($request, $user) {
            $validated = $request->validated();

            $package = Package::findOrFail($validated['package_id']);

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['user_id'] = $user->id;
            $validated['total_amount'] = $package->harga;
            $validated['is_paid'] = false;

            $transaction = SubscribeTransaction::create($validated);
        });

        return redirect()->route('front.index');
    }

    public function category(Category $category)
    {
        $courses = $category->courses()->get();

        return view('front.category', compact('courses', 'category'));
    }

    public function course(Request $request)
    {
        $query = Course::query();
    
        // Filter berdasarkan kategori yang dipilih
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }
    
        // Filter berdasarkan tanggal jika dipilih
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }
    
        $courses = $query->get();
        $categories = Category::all(); // Ambil semua kategori untuk dropdown
    
        return view('front.course', compact('courses', 'categories'));
    }
    

    public function progress()
    {
        $user = auth()->user();
    
        // Ambil 9 kursus yang baru diikuti user
        $courses = $user->courses()->latest()->take(9)->get();
    
        // Ambil daftar artikel yang baru dikunjungi dari session
        $visitedArticles = session()->get('visited_articles', []);
    
        // Debugging: Cek isi visitedArticles
        \Log::info('Visited Articles:', $visitedArticles);
    
        // Cek apakah visitedArticles tidak kosong
        if (!empty($visitedArticles)) {
            // Ambil artikel berdasarkan urutan dalam session
            $articles = Artikel::whereIn('id', $visitedArticles)
                        ->where('status', 'publish') // Pastikan hanya artikel yang diterbitkan
                        ->orderByRaw("FIELD(id, " . implode(',', $visitedArticles) . ")")
                        ->take(9)
                        ->get();
        } else {
            // Jika tidak ada artikel yang dikunjungi, ambil artikel terbaru
            $articles = Artikel::where('status', 'publish')
                        ->latest()
                        ->take(9)
                        ->get();
        }
    
        return view('front.progress', compact('courses', 'articles'));
    }


    public function search(Request $request)
    {
        $request->validate([
            'keyword' => ['required', 'string', 'max:255']
        ]);
        $keyword = $request->keyword;

        $courses = Course::with(['teacher', 'categories'])
            ->where('name', 'like', '%' . $keyword . '%')
            ->paginate(3);

        return view('front.search', compact('courses', 'keyword'));
    }

    public function reapplyForm()
    {
        $teacher = auth()->user()->teachers;

        return view('teachers.reapply');
    }

    public function submitReapply(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('owner')) {
            return redirect()->back()->with('error', 'Reapply is not allowed because you are an owner.');
        }

        if ($user->hasRole('teacher')) {
            return redirect()->back()->with('error', 'Reapply is not allowed because you are a teacher.');
        }

        $existingTeacher = $user->teachers()->where('status', '!=', 'approved')->latest()->first();

        if ($existingTeacher && $existingTeacher->status === 'pending') {
            return redirect()->back()->with('error', 'You already have a pending application.');
        }

        $newTeacher = new Teacher([
            'user_id' => $user->id,
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        $newTeacher->save();

        return redirect()->route('teachers.approval-notice')->with('success', 'Reapply submitted successfully. Please wait for admin approval.');
    }
}
