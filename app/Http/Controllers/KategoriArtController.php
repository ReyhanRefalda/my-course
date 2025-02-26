<?php

namespace App\Http\Controllers;

use App\Models\Kategoriart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriArtController extends Controller
{
    public function index()
    {
        $search = request()->query('search');
    
        $query = Kategoriart::latest();
    
        if ($search) {
            $query->where('name', 'LIKE', "%$search%");
        }
    
        $kategoriarts = $query->paginate(10)->withQueryString();
    
        return view('admin.kategoriart.index', compact('kategoriarts'));
    }
    

    public function create()
    {
        return view('admin.kategoriart.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoriart,name',
            'icon' => 'nullable|image|max:2048',
        ]);

        Kategoriart::create([
            'name' => $request->name,
            'icon' => $request->file('icon') ? $request->file('icon')->store('kategoriart_icons', 'public') : null,
        ]);

        return redirect()->route('admin.kategoriart.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Kategoriart $kategoriart)
    {
        return view('admin.kategoriart.edit', compact('kategoriart'));
    }

    public function update(Request $request, Kategoriart $kategoriart)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoriart,name,' . $kategoriart->id,
            'icon' => 'nullable|image|max:2048',
        ]);

        $kategoriart->update([
            'name' => $request->name,
            'icon' => $request->file('icon') ? $request->file('icon')->store('kategoriart_icons', 'public') : $kategoriart->icon,
        ]);

        return redirect()->route('admin.kategoriart.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Kategoriart $kategoriart)
    {
        $kategoriart->delete();
        return redirect()->route('admin.kategoriart.index')->with('success', 'Kategori berhasil dihapus');
    }
}
