<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Artikel;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\VideoHistories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SubscribeTransaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSubscribeTransactionRequest;
use Illuminate\Support\Facades\Log;

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
        $user = auth()->user();
        $userRole = $user ? $user->getRoleNames()->first() : 'guest'; // Ubah default jadi 'guest'
    
        // Ambil video berdasarkan role user
        $courseVideos = $course->course_videos()
            ->when($user && in_array($userRole, ['owner', 'teacher']), function ($query) {
                return $query->withTrashed(); // Tampilkan semua video jika pemilik/guru
            }, function ($query) {
                return $query->whereNull('deleted_at'); // Hanya tampilkan video aktif untuk student & guest
            })
            ->get();
    
        // Default array kosong untuk menghindari error di Blade
        $watchedVideos = [];
    
        // Jika user login, ambil daftar video yang sudah ditonton
        if ($user) {
            $watchedVideos = VideoHistories::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->pluck('video_id')
                ->toArray();
        }
    
        // Jika user login dan hanya memiliki role 'student', simpan ke course_students
        if ($user && $user->hasRole('student') && $user->roles->count() === 1) {
            DB::table('course_students')->updateOrInsert(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['updated_at' => now(), 'created_at' => now()]
            );
        }
    
        return view('front.details', compact('course', 'courseVideos', 'watchedVideos'));
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

        // ✅ Ambil semua video kursus, bukan hanya yang ditonton
        $course = Course::with(['categories', 'course_videos'])
            ->where('id', $courseId)
            ->whereNull('deleted_at')
            ->first();

        if (!$course) {
            return redirect()->route('front.courses')->with('error', 'Course not found.');
        }

        // ✅ Ambil video yang sedang ditonton
        $video = $course->course_videos->where('id', $courseVideoId)->first();

        if (!$video) {
            return redirect()->route('front.courses')->with('error', 'Video not found.');
        }

        // ✅ Simpan riwayat tonton hanya untuk student
        if ($user->hasRole('student') && $user->roles->count() === 1) {
            // Menyimpan history kursus ke tabel pivot (jika ada tabel pivot `course_user`)
            DB::table('course_students')->updateOrInsert(
                ['user_id' => $user->id, 'course_id' => $courseId],
                ['updated_at' => now(), 'created_at' => now()]
            );

            // Menyimpan history video ke tabel `video_histories`
            DB::table('video_histories')->updateOrInsert(
                ['user_id' => $user->id, 'course_id' => $courseId, 'video_id' => $courseVideoId],
                ['watched_at' => now(), 'updated_at' => now()]
            );
        }

        // ✅ Ambil daftar video yang sudah ditonton user
        $watchedVideos = VideoHistories::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->pluck('video_id')
            ->toArray();

        return view('front.learning', compact('course', 'video', 'watchedVideos'));
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

        if (!$payment) {
            abort(404, 'Payment details not found.');
        }

        $hasPendingTransaction = false;

        if (Auth::check()) {
            $user = Auth::user();
            $pendingTransaction = $user->subscribe_transactions()
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($pendingTransaction) {
                $hasPendingTransaction = true;
            }

            if ($user->hasActiveSubscription()) {
                $currentPackage = $user->subscribe_transactions()
                    ->where('status', 'approved')
                    ->where('expired_at', '>=', now())
                    ->latest('expired_at')
                    ->first()->package;

                if ($package->harga <= $currentPackage->harga) {
                    return redirect()->route('front.pricing');
                }
            }
        }
        // dd($hasPendingTransaction);

        return view('front.checkout', compact('package', 'payment', 'hasPendingTransaction'));
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
            $validated['status'] = 'pending';

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

        // Search hanya berdasarkan nama kursus
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Paginate 9 data per halaman dengan query parameters tetap ada
        $courses = $query->orderbyDesc('created_at')->paginate(6)->appends($request->query());

        // Tambahkan status progress/done ke setiap kursus jika user login
        if (auth()->check()) {
            $user = auth()->user();
            foreach ($courses as $course) {
                $course->status = $user->courseStatus($course->id);
            }
        }

        // Ambil semua kategori untuk dropdown
        $categories = Category::all();

        return view('front.course', compact('courses', 'categories'));
    }


    public function progress(Request $request)
    {
        $user = auth()->user();
    
        // Ambil parameter filter dari request
        $search = $request->input('search');
        $categoryFilter = $request->input('category');
        $dateFilter = $request->input('date');
        $statusFilter = $request->input('status'); // Khusus kursus
    
        // **AMBIL COURSES YANG PERNAH DIIKUTI USER + FILTER**
        $coursesQuery = $user->courses()->orderByPivot('updated_at');
    
        // Search berdasarkan nama kursus
        if ($search) {
            $coursesQuery->where('name', 'LIKE', "%{$search}%");
        }
    
        // Filter berdasarkan kategori
        if ($categoryFilter) {
            $coursesQuery->whereHas('categories', function ($query) use ($categoryFilter) {
                $query->where('categories.id', $categoryFilter);
            });
        }
    
        // Filter berdasarkan tanggal ditonton
        if ($dateFilter) {
            $coursesQuery->whereIn('courses.id', function ($query) use ($user, $dateFilter) {
                $query->select('vh.course_id')
                    ->from('video_histories as vh')
                    ->where('vh.user_id', $user->id)
                    ->whereDate('vh.watched_at', $dateFilter)
                    ->groupBy('vh.course_id');
            });
            
        }
    
        // Jika ada filter status, gunakan collection & custom pagination
        if ($statusFilter) {
            $filteredCourses = $coursesQuery->get()->filter(function ($course) use ($statusFilter, $user) {
                return $user->courseStatus($course->id) === $statusFilter;
            });
    
            $courses = new \Illuminate\Pagination\LengthAwarePaginator(
                $filteredCourses->forPage(request('courses_page', 1), 2), // Gunakan parameter unik
                $filteredCourses->count(),
                4,
                request('courses_page', 1),
                ['path' => request()->url(), 'query' => request()->query()]
            );
        } else {
            $courses = $coursesQuery->paginate(4, ['*'], 'courses_page'); // Gunakan parameter unik
        }
    
        // Tambahkan status untuk tiap course
        foreach ($courses as $course) {
            $course->status = $user->courseStatus($course->id);
        }
    
        // **AMBIL ARTICLES YANG PERNAH DIKUNJUNGI + FILTER**
        $articlesQuery = $user->articles()->orderByPivot('created_at', 'desc');
    
        // Search berdasarkan judul artikel
        if ($search) {
            $articlesQuery->where('title', 'LIKE', "%{$search}%");
        }
    
        // Filter berdasarkan tanggal dikunjungi
        if ($dateFilter) {
            $articlesQuery->join('article_histories as ah', 'artikel.id', '=', 'ah.article_id')
                          ->where('ah.user_id', $user->id)
                          ->whereDate('ah.created_at', $dateFilter);
        }
    
        // Gunakan parameter unik untuk pagination articles
        $visitedArticles = $articlesQuery->paginate(3, ['*'], 'articles_page');
    
        // Ambil daftar kategori
        $categories = Category::all();
    
        return view('front.progress', compact('courses', 'visitedArticles', 'categories'));
    }
    
    public function tes(Request $request) {

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
