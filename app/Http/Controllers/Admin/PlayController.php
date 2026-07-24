<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePlayRequest;
use App\Http\Requests\Admin\UpdatePlayRequest;
use App\Models\Play;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Play::class, 'play');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = request()->get('search');
        $plays = Play::with('venue')->search($search)->paginate(10);
        return view('admin.plays.index', compact('plays', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $venues = Venue::active()->get();
        return view('admin.plays.create',compact('venues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayRequest $request)
    {
        $data = $request->validated();

        // Resim yükleme
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('plays', 'public');
        }

        // Oyunu oluştur
        $play = Play::create($data);

        // Oyun eklendi, salonu pasif yap
        $venue = Venue::find($request->venue_id);
        if ($venue) {
            $venue->update(['is_active' => false]);
        }

        return redirect()->route('admin.plays.index')
            ->with('success', 'Oyun başarıyla oluşturuldu. Salon pasif duruma getirildi.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Play $play)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Play $play)
    {
        $venues = Venue::all();
        return view('admin.plays.edit', compact('play', 'venues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayRequest $request, Play $play)
    {
        $data = $request->validated();

        // Resim yükleme
        if ($request->hasFile('image')) {
            if ($play->image) {
                Storage::disk('public')->delete($play->image);
            }
            $data['image'] = $request->file('image')->store('plays', 'public');
        }

        // Eski salonu bul (güncelleme öncesi)
        $oldVenueId = $play->venue_id;

        // Oyunu güncelle
        $play->update($data);

        // Eğer salon değiştiyse, eski salonu kontrol et
        if ($oldVenueId != $request->venue_id) {
            // Eski salonda başka oyun var mı?
            $oldVenue = Venue::find($oldVenueId);
            if ($oldVenue && !$oldVenue->hasActivePlay()) {
                $oldVenue->update(['is_active' => true]);
            }

            // Yeni salonu pasif yap
            $newVenue = Venue::find($request->venue_id);
            if ($newVenue) {
                $newVenue->update(['is_active' => false]);
            }
        }

        return redirect()->route('admin.plays.index')
            ->with('success', 'Oyun başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Play $play)
    {
        if ($play->image) {
            Storage::disk('public')->delete($play->image);
        }

        // Oyunu sil
        $venueId = $play->venue_id;
        $play->delete();

        // Salonda başka oyun kaldı mı?
        $venue = Venue::find($venueId);
        if ($venue && !$venue->hasActivePlay()) {
            $venue->update(['is_active' => true]);
        }

        return redirect()->route('admin.plays.index')
            ->with('success', 'Oyun başarıyla silindi. Salon tekrar aktif duruma getirildi.');
    }
}
