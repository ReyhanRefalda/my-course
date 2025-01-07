<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseVideoRequest;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CourseVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($courseId)
    {
        $course = Course::with(['categories'])->findOrFail($courseId);
        return view('admin.course_videos.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseVideoRequest $request, Course $course)
    {
        DB::transaction(function () use ($request, $course) {

            $validated = $request->validated();

            $validated['course_id'] = $course->id;

            $courseVideo = CourseVideo::create($validated);
        });
        return redirect()->route('admin.courses.show', $course->id)->with('success', 'Successfully added course video!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseVideo $courseVideo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseVideo $courseVideo)
    {
        return view('admin.course_videos.edit', compact('courseVideo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCourseVideoRequest $request, CourseVideo $courseVideo)
    {
        DB::transaction(function () use ($request, $courseVideo) {

            $validated = $request->validated();

            $courseVideo->update($validated);
        });
        return redirect()->route('admin.courses.show', $courseVideo->course_id)->with('success', 'Successfully updated course video!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseVideo $courseVideo)
    {
        $user = auth()->user();
        
        // Prioritas role
        if ($user->hasRole('teacher') && !$user->hasRole('owner')) {
            // Teacher hanya dapat hard delete jika video belum soft delete
            if (!$courseVideo->trashed()) {
                $courseVideo->forceDelete();
                return redirect()->back()->with('success', 'Video berhasil dihapus secara permanen.');
            } else {
                return redirect()->back()->with('error', 'Teacher tidak dapat menghapus video yang sudah dihapus (soft delete).');
            }
        }
    
        if ($user->hasRole('owner')) {
            // Owner melakukan soft delete
            if (!$courseVideo->trashed()) {
                $courseVideo->update(['deleted_by' => $user->id]);
                $courseVideo->delete();
                return redirect()->back()->with('success', 'Video berhasil dihapus (soft delete).');
            } else {
                return redirect()->back()->with('error', 'Video sudah dihapus sebelumnya.');
            }
        }
    
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus video.');
    }
    
    
    
    
    
    
    
    
}
