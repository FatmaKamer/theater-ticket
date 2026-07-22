<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Routing\Attributes\Controllers\Authorize;
use App\Http\Requests\Admin\StoreVenueRequest;
use App\Http\Requests\Admin\UpdateVenueRequest;

class VenueController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Venues::class, 'venue');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = $request->get('search');
        
        $venues = Venue::search($search)->paginate(10);

        return view('admin.venues.index', compact('venues', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.venues.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validated();

        // Resim yükleme (opsiyonel)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('venues', 'public');
        }

        Venue::create($data);

        return redirect()->route('admin.venues.index')
                         ->with('success', 'Salon başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.venues.edit', compact('venue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Eski resmi sil
            if ($venue->image) {
                Storage::disk('public')->delete($venue->image);
            }
            $data['image'] = $request->file('image')->store('venues', 'public');
        }

        $venue->update($data);

        return redirect()->route('admin.venues.index')
                         ->with('success', 'Salon başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($venue->image) {
            Storage::disk('public')->delete($venue->image);
        }

        $venue->delete();

        return redirect()->route('admin.venues.index')
                         ->with('success', 'Salon başarıyla silindi.');
    }
}
