<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserArtikelController extends Controller
{

    public function index()
    {
        $search = request()->query('search');
        $category = request()->query('category');
        $createdAt = request()->query('created_at');

        $query = Artikel::where('status', 'publish');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%$search%");
                    });
            });
        }

        if ($createdAt) {
            $query->whereDate('created_at', $createdAt);
        }

        // Perbaiki pemanggilan relasi dari 'Category' ke 'Categorys'
        if ($category) {
            $query->whereHas('Categories', function ($q) use ($category) {
                $q->where('Category.id', $category); // Tambahkan prefix tabel
            });
        }


        $lastData = $query->orderBy('id', 'desc')->latest()->first();

        if (!$lastData) {
            return view('artikel.index', [
                'artikels' => $query->paginate(12)->withQueryString(),
                'lastData' => null,
                'secondToFifthData' => collect(),
                'categories' => Category::all(), // Ambil semua kategori untuk dropdown
            ]);
        }

        $secondToFifthData = $query->where('id', '!=', $lastData->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $artikels = $query->whereNotIn('id', $secondToFifthData->pluck('id')->prepend($lastData->id))
            ->orderBy('id', 'desc')
            ->paginate(6)
            ->withQueryString();

        return view('artikel.index', compact('artikels', 'lastData', 'secondToFifthData', 'category'))
            ->with('categories', Category::all());
    }





    public function detail($slug)
    {
        $artikels = Artikel::where('status', 'publish')->where('slug', $slug)->firstOrFail();
        $user = auth()->user();
    
        // Jika user login, simpan riwayat artikel yang dibaca
        if ($user) {
            DB::table('article_histories')->updateOrInsert(
                ['article_id' => $artikels->id, 'user_id' => $user->id],
                ['updated_at' => now(), 'created_at' => now()]
            );
    
            // Ambil daftar artikel yang dikunjungi oleh user
            $visitedArticles = $user->articles()->limit(9)->pluck('artikel.id');
        } else {
            $visitedArticles = collect(); // Jika tidak login, buat koleksi kosong
        }
    
        // Ambil artikel yang pernah dikunjungi, atau ambil artikel terbaru jika belum ada
        if ($visitedArticles->isNotEmpty()) {
            $artikleSidebar = Artikel::whereIn('id', $visitedArticles)
                ->where('status', 'publish')
                ->orderByRaw("FIELD(id, " . implode(',', $visitedArticles->toArray()) . ")")
                ->take(6)
                ->get();
        } else {
            $artikleSidebar = Artikel::where('status', 'publish')
                ->latest()
                ->take(6)
                ->get();
        }
    
        return view('artikel.show', compact('artikels', 'artikleSidebar'));
    }




    public function lastData()
    {
        $artikels = Artikel::where('status', 'publish')->orderBy('id', 'desc')->latest()->first();
        return $artikels;
    }
}
