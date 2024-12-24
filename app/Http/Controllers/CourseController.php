<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
    
        // Load courses with related models
        $query = Course::with(['categories', 'teacher', 'students'])->orderByDesc('id');
    
        // Filter berdasarkan role "teacher"
        if ($user->hasRole('teacher')) {
            $query->whereHas('teacher', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }
    
        // Filter berdasarkan kategori (many-to-many)
        if (request('category')) {
            $query->whereHas('categories', function ($query) {
                $query->where('id', request('category'));
            });
        }
    
        // Filter berdasarkan teacher
        if (request('teacher')) {
            $query->where('teacher_id', request('teacher'));
        }
    
        $courses = $query->paginate(10);
    
        // Ambil data untuk dropdown filter 
        $categories = Category::all();
        $teachers = Teacher::with('user')->get();
    
        return view('admin.courses.index', compact('courses', 'categories', 'teachers'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        // Ambil data teacher berdasarkan user yang login
        $teacher = Teacher::where('user_id', Auth::user()->id)->first();

        // Pastikan user adalah seorang teacher
        if (!$teacher) {
            return redirect()->route('admin.courses.index')->with('error', 'You are not a teacher.');
        }

        try {
            DB::transaction(function () use ($request, $teacher) {
                // Validasi data dari request
                $validated = $request->validated();

                // Upload thumbnail jika ada file yang dikirimkan
                if ($request->hasFile('thumbnail')) {
                    $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                    $validated['thumbnail'] = $thumbnailPath;
                }

                // Tambahkan data tambahan untuk course
                $validated['slug'] = Str::slug($validated['name']);
                $validated['teacher_id'] = $teacher->id;

                // Buat course baru
                $course = Course::create($validated);

                // Sinkronisasi kategori jika ada
                if ($request->has('category_ids')) {
                    // Validasi apakah kategori yang dikirimkan valid
                    $validCategoryIds = Category::whereIn('id', $request->category_ids)->pluck('id')->toArray();

                    if (!empty($validCategoryIds)) {
                        $course->categories()->sync($validCategoryIds);
                    } else {
                        throw new \Exception('Invalid categories selected.');
                    }
                }

                // Tambahkan keypoints untuk course
                if (!empty($validated['course_keypoints'])) {
                    foreach ($validated['course_keypoints'] as $keypointText) {
                        $course->course_keypoints()->create([
                            'name' => $keypointText,
                        ]);
                    }
                }
            });

            return redirect()->route('admin.courses.index')->with('success', 'Course added successfully!');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error while adding course: ' . $e->getMessage());

            return redirect()->route('admin.courses.index')->with('error', 'An error occurred while adding the course. Please try again.');
        }
    }




    
    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        if (!$course) {
            return redirect()->route('admin.courses.index')->with('error', 'Course tidak ditemukan');
        }
    
        $categories = Category::all();
        return view('admin.courses.show', compact('course', 'categories'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $course = Course::find($id);

    if (!$course) {
        return redirect()->route('admin.courses.index')->with('error', 'Course tidak ditemukan.');
    }

    $categories = Category::all();
    return view('admin.courses.edit', compact('course', 'categories'));
}

    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        DB::transaction(function () use ($request, $course) {
            $validated = $request->validated();
    
            // Periksa dan proses upload thumbnail baru jika ada
            if ($request->hasFile('thumbnail')) {
                // Hapus thumbnail lama jika ada
                if ($course->thumbnail) {
                    Storage::disk('public')->delete($course->thumbnail);
                }
    
                // Simpan thumbnail baru
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }
    
            // Generate slug baru berdasarkan nama
            $validated['slug'] = Str::slug($validated['name']);
    
            // Update data course
            $course->update($validated);
    
            // Sinkronisasi kategori
            if ($request->has('category_ids') && !empty($request->category_ids)) {
                // Sinkronisasi kategori baru
                $course->categories()->sync($request->category_ids);
            } else {
                // Jika tidak ada kategori dipilih, hapus semua kategori terkait
                $course->categories()->detach();
            }
    
            // Update course keypoints
            if (!empty($validated['course_keypoints'])) {
                // Hapus semua keypoint lama
                $course->course_keypoints()->delete();
    
                // Tambahkan keypoint baru
                foreach ($validated['course_keypoints'] as $keypointText) {
                    $course->course_keypoints()->create([
                        'name' => $keypointText,
                    ]);
                }
            }
        });
    
        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        DB::beginTransaction();

        try {
            $course->delete();
            DB::commit();

            return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.courses.index')->with('error', 'There was an error while deleting course.');
        }
    }
}
