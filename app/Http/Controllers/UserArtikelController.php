<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategoriart;
use Illuminate\Http\Request;

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
    
        // Perbaiki pemanggilan relasi dari 'kategoriart' ke 'kategoriarts'
        if ($category) {
            $query->whereHas('kategoriarts', function ($q) use ($category) {
                $q->where('kategoriart.id', $category); // Tambahkan prefix tabel
            });
        }
        
    
        $lastData = $query->orderBy('id', 'desc')->latest()->first();
    
        if (!$lastData) {
            return view('artikel.index', [
                'artikels' => $query->paginate(12)->withQueryString(),
                'lastData' => null,
                'secondToFifthData' => collect(),
                'categories' => Kategoriart::all(), // Ambil semua kategori untuk dropdown
            ]);
        }
    
        $secondToFifthData = $query->where('id', '!=', $lastData->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();
    
        $artikels = $query->whereNotIn('id', $secondToFifthData->pluck('id')->prepend($lastData->id))
            ->orderBy('id', 'desc')
            ->paginate(12)
            ->withQueryString();
    
        return view('artikel.index', compact('artikels', 'lastData', 'secondToFifthData', 'category'))
            ->with('categories', Kategoriart::all());
    }
    
    



    public function detail($slug)
    {
        $artikels = Artikel::where('status', 'publish')->where('slug', $slug)->firstOrFail();
    
        // Ambil daftar artikel yang sudah dikunjungi dari session
        $visitedArticles = session()->get('visited_articles', []);
    
        // Jika artikel sudah ada dalam daftar, hapus dari daftar
        if (in_array($artikels->id, $visitedArticles)) {
            $visitedArticles = array_diff($visitedArticles, [$artikels->id]);
        }
    
        // Tambahkan artikel yang sedang dibaca ke posisi teratas
        array_unshift($visitedArticles, $artikels->id);
    
        // Simpan hanya 9 artikel terakhir
        $visitedArticles = array_slice($visitedArticles, 0, 9);
    
        // Simpan kembali ke session
        session()->put('visited_articles', $visitedArticles);
    
        // Cek apakah visited_articles kosong
        if (!empty($visitedArticles)) {
            // Ambil artikel berdasarkan daftar ID yang baru dikunjungi
            $artikleSidebar = Artikel::whereIn('id', $visitedArticles)
                ->orderByRaw("FIELD(id, " . implode(',', $visitedArticles) . ")")
                ->take(6)
                ->get();
        } else {
            // Jika tidak ada artikel yang dikunjungi, tampilkan artikel terbaru
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
