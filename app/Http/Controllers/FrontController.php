<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscribeTransactionRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Package;
use App\Models\Payment;
use App\Models\SubscribeTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    //

    public function index(){
        $courses = Course::with(['category', 'teacher', 'students'])
        ->orderByDesc('id')
        ->get();

        $categories = Category::all();

        return view('front.index', compact('courses', 'categories'));
    }

    public function detail(Course $course){


        return view('front.details', compact('course'));
    }

    public function learning(Course $course, $courseVideoId){
        $user = Auth::user();

        if(!$user->hasActiveSubscription()){
            return redirect()->route('front.pricing');
        }

        $video = $course->course_videos->firstWhere('id', $courseVideoId);

        $user->courses()->syncWithoutDetaching($course->id);

        $totalStudent = $course->students->count();
        $benefit = $totalStudent * 10000;
        $teacher = $course->teacher->user;

        $teacher->update([
            'balance' => $benefit
        ]);
        dd($teacher->balance);
        return view('front.learning', compact('course', 'video'));
    }

    public function pricing(){
        $packages = Package::all();

        return view('front.pricing', compact('packages'));
    }

    public function checkout($packageId){
        $package = Package::findOrFail($packageId);
        $payment = Payment::first();
        if (!$payment) {
            abort(404, 'Payment details not found.');
        }
        return view('front.checkout', compact('package', 'payment'));
    }

    public function checkout_store(StoreSubscribeTransactionRequest $request){
        $user = Auth::user();

        if (Auth::user()->hasActiveSubscription()){
            return redirect()->route('front.index');
        }

        DB::transaction(function () use ($request, $user){
            $validated = $request->validated();

            $package = Package::findOrFail($validated['package_id']);

            if($request->hasFile('proof')){
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['user_id'] = $user->id;
            $validated['total_amount'] = $package->harga;
            $validated['is_paid'] = false;

            $transaction = SubscribeTransaction::create($validated);
        });

        return redirect()->route('dashboard');
    }

    public function category(Category $category){
        $courses = $category->courses()->get();

        return view('front.category', compact('courses', 'category'));
    }

    public function course(){
        $courses = Course::all();
        return view('front.course', compact('courses'));
    }
}
