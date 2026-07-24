<?php

namespace App\Http\Controllers;

use App\Models\Play;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Ana sayfa
     * - Giriş yapmamış → welcome.blade.php
     * - Giriş yapmış → home.blade.php (oyun listesi)
     */
    public function index()
    {
        if (auth()->check()) {
            $plays = Play::with('venue')
                ->where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->paginate(9);

            return view('home', compact('plays'));
        }

        return view('welcome');
    }

    /**
     * Oyun detay (sadece giriş yapmışlar)
     */
    public function show(Play $play)
    {
        // Giriş kontrolü zaten middleware'de yapılıyor
        if (!$play->is_active) {
            abort(404);
        }

        $play->load('venue');

        return view('play.show', compact('play'));
    }
}
