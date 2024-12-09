<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class UserArtikelController extends Controller
{
    public function index()
    {
        $search = request()->query('search');
        $query = Artikel::where('status', 'publish');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('nama', 'LIKE', "%$search%");
                    });
            });
        }

        $lastData = $query->orderBy('id', 'desc')->latest()->first();

        if (!$lastData) {
            return view('user.artikel.index', [
                'artikels' => $query->paginate(12),
                'lastData' => null,
                'secondToFifthData' => collect()
            ]);
        }

        $secondToFifthData = $query->where('id', '!=', $lastData->id)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        $artikels = $query->whereNotIn('id', $secondToFifthData->pluck('id')->prepend($lastData->id))
            ->orderBy('id', 'desc')
            ->paginate(12);

        return view('user.artikel.index', compact('artikels', 'lastData', 'secondToFifthData'));
    }



    public function detail($slug)
    {
        $artikleSidebar = Artikel::where('status', 'publish')->latest()->get();
        $artikels = Artikel::where('status', 'publish')->where('slug', $slug)->firstOrFail();
        return view('user.artikel.show', compact('artikels', 'artikleSidebar'));
    }

    public function lastData()
    {
        $artikels = Artikel::where('status', 'publish')->orderBy('id', 'desc')->latest()->first();
        return $artikels;
    }
}
