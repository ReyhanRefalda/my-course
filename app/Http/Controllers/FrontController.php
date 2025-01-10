<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Artikel;
use App\Models\Package;
use App\Models\Payment;
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


        return view('front.details', compact('course'));
    }

    public function learning(Course $course, $courseVideoId)
    {
        $user = Auth::user();

        if (!$user->hasActiveSubscription()) {
            return redirect()->route('front.pricing');
        }

        $video = $course->course_videos->firstWhere('id', $courseVideoId);

        $user->courses()->syncWithoutDetaching($course->id);

        return view('front.learning', compact('course', 'video'));
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
        return view('front.checkout', compact('package', 'payment'));
    }

    public function checkout_store(StoreSubscribeTransactionRequest $request)
    {
        $user = Auth::user();

        if (Auth::user()->hasActiveSubscription()) {
            return redirect()->route('front.index');
        }

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

    public function course()
    {
        $courses = Course::all();
        return view('front.course', compact('courses'));
    }

    public function progress()
    {
        $courses = Course::all();
        $courseHistories = auth()->user()->courseHistories()->with('course')->latest()->get();
        $articles = Artikel::where('status', 'publish')->orderBy('created_at', 'desc')->take(3)->get();
        return view('front.progress', compact('courses', 'articles','courseHistories'));
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
}
