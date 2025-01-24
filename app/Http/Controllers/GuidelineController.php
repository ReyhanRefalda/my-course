<?php

namespace App\Http\Controllers;

use App\Models\Guideline;
use Illuminate\Http\Request;

class GuidelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.guideline.index');
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
    public function show(Guideline $guideline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guideline $guideline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guideline $guideline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guideline $guideline)
    {
        //
    }
}
