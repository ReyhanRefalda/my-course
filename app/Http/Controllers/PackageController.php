<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageRequest;
use App\Models\Package;
use App\Models\Benefit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages.
     */
    public function index(): View
    {
        $packages = Package::with('benefits')->paginate(5);
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create(): View
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created package in storage.
     */
    public function store(StorePackageRequest $request): RedirectResponse
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            // Simpan data package
            $package = Package::create([
                'name' => $request->name,
                'description' => $request->description,
                'harga' => $request->harga,
                'tipe' => $request->tipe,
            ]);

            // Simpan data benefits
            $benefits = array_filter($request->package_benefits, function ($benefitName) {
                return !empty($benefitName); // Hanya ambil nilai yang tidak kosong
            });

            foreach ($benefits as $benefitName) {
                Benefit::create([
                    'name' => $benefitName,
                    'packages_id' => $package->id,
                ]);
            }

            DB::commit(); // Commit transaksi
            return redirect()->route('admin.packages.index')->with('success', 'Package created successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika ada error
            return redirect()->back()->withErrors(['error' => 'Failed to create package: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified package.
     */
    public function show($id)
    {
        $package = Package::with('benefits')->findOrFail($id);

        return view('admin.packages.show', compact('package'));
    }


    /**
     * Show the form for editing the specified package.
     */
    public function edit(Package $package): View
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified package in storage.
     */
    public function update(StorePackageRequest $request, Package $package): RedirectResponse
    {
        DB::beginTransaction();
    
        try {
            $package->update([
                'name' => $request->name,
                'description' => $request->description,
                'harga' => str_replace('.', '', $request->harga),
                'tipe' => $request->tipe,
            ]);
    
            $existingBenefits = $package->benefits->pluck('name', 'id')->toArray();
            $newBenefits = array_filter($request->package_benefits, fn($benefit) => !empty($benefit));
    
            foreach ($existingBenefits as $id => $name) {
                if (!in_array($name, $newBenefits)) {
                    Benefit::destroy($id);
                } else {
                    $newBenefits = array_diff($newBenefits, [$name]);
                }
            }
    
            foreach ($newBenefits as $benefitName) {
                Benefit::create([
                    'name' => $benefitName,
                    'packages_id' => $package->id,
                ]);
            }
    
            DB::commit();
            return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to update package: ' . $e->getMessage()]);
        }
    }
    


    /**
     * Remove the specified package from storage.
     */
    public function destroy(Package $package): RedirectResponse
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully!');
    }
}
