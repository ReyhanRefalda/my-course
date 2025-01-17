<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $input = request('search');
        $categories = Category::when($input, function ($query, $input) {
            return $query->where('name', 'like', '%' . $input . '%');
        })->orderByDesc('id')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        DB::transaction(function () use ($request) {

            $validated = $request->validated();

            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validated['icon'] = $iconPath;
            } else {
                $iconPath = 'images/default-icon.png';
            }

            $validated['slug'] = Str::slug($validated['name']);

            $categories = Category::create($validated);
        });

        return redirect()->route('admin.categories.index')->with('success', 'Successfully added category!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        DB::transaction(function () use ($request, $category) {

            $validated = $request->validated();

            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validated['icon'] = $iconPath;
            }

            $validated['slug'] = Str::slug($validated['name']);

            $category->update($validated);
        });

        return redirect()->route('admin.categories.index')->with('success', 'Successfully updated category!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();

        try {
            if ($category->courses()->exists()) {
                return redirect()->route('admin.categories.index')->with('error', 'Cannot delete category because it has courses.');
            }

            $category->delete();
            DB::commit();

            return redirect()->route('admin.categories.index')->with('success', 'Successfuly deleted category!.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.categories.index')->with('error', 'There was an error while deleting category.');
        }
    }
}
