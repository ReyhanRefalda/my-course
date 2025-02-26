<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategoriart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ArtikelRequest;
use App\Models\Category;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $user = Auth::user();
    $search = $request->search;
    $status = $request->status;
    $date = $request->date;

    $artikels = Artikel::query()
        // Filter berdasarkan peran pengguna
        ->when(!$user->hasRole('owner'), function ($query) use ($user) {
            $query->where('users_id', $user->id);
        })
        // Filter pencarian
        ->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        })
        // Filter status
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        // Filter tanggal
        ->when($date, function ($query) use ($date) {
            $query->whereDate('created_at', $date);
        })
        ->orderBy('id', 'desc')
        ->paginate(3)
        ->withQueryString()
        ->appends($request->query());

    return view('admin.artikel.index', compact('artikels'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Ambil semua kategori
        return view('admin.artikel.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
        public function store(ArtikelRequest $request)
        {
            // Proses upload file thumbnail
            if ($request->hasFile('tumbnail')) {
                $image = $request->file('tumbnail');
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path(getenv('CUSTOM_TUMBNAIL_LOCATION'));
                $image->move($destinationPath, $image_name);
            }

            // Proses data sebelum menyimpan
            $data = [
                'title' => $request->title,
                'content' => "<div class='trix-content'>" . $request->content . "</div>",
                'status' => $request->status,
                'tumbnail' => isset($image_name) ? $image_name : null,
                'slug' => $this->generateSlug($request->title),
                'users_id' => Auth::user()->id,
            ];

            // Simpan artikel ke database
            $artikel = Artikel::create($data);

            // Simpan kategori artikel di tabel pivot
            if ($request->has('kategoriart')) {
                $artikel->kategoriarts()->sync($request->kategoriart);
            }

            // Redirect dengan pesan sukses
            return redirect()->route('admin.artikel.index')->with('success', 'Successfully added article!');
        }


    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        Gate::authorize('edit', $artikel); // Pastikan user punya izin
        $categories = Category::all(); // Ambil semua kategori
        // dd($artikel->kategoriarts->pluck('id')->toArray());
        // dd($artikel);
        return view('admin.artikel.edit', compact('artikel', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ArtikelRequest $request, Artikel $artikel)
    {
        Gate::authorize('edit', $artikel); // Pastikan user punya izin

        // Jika ada file thumbnail baru, hapus yang lama dan upload yang baru
        if ($request->hasFile('tumbnail')) {
            if (!empty($artikel->tumbnail) && file_exists(public_path(config('app.custom_tumbnail_location') . '/' . $artikel->tumbnail))) {
                unlink(public_path(config('app.custom_tumbnail_location') . '/' . $artikel->tumbnail));
            }

            $image = $request->file('tumbnail');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path(config('app.custom_tumbnail_location'));
            $image->move($destinationPath, $image_name);
        }

        // Data yang akan diperbarui
        $data = [
            'title' => $request->title,
            'content' => "<div class='trix-content'>" . $request->content . "</div>",
            'status' => $request->status,
            'tumbnail' => isset($image_name) ? $image_name : $artikel->tumbnail,
            'slug' => $this->generateSlug($request->title, $artikel->id),
        ];

        // Update artikel
        $artikel->update($data);

        // Perbarui kategori artikel di pivot table
        if ($request->has('kategoriart')) {
            $artikel->kategoriarts()->sync($request->kategoriart);
        }
        // dd('masuk');

        // Redirect dengan pesan sukses
        return redirect()->route('admin.artikel.index')->with('success', 'Successfully updated the article!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        Gate::authorize('delete', $artikel);
        if (isset($artikel->tumbnail) && file_exists(public_path(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail))) {
            unlink(public_path(getenv('CUSTOM_TUMBNAIL_LOCATION') . '/' . $artikel->tumbnail));
        }

        Artikel::where('id', $artikel->id)->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Successfully deleted!');
    }


    private function generateSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = Artikel::where('slug', $slug)->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })->count();
        if ($count > 0) {
            $slug = $slug . '-' . $count + 1;
        }
        return $slug;
    }
}
