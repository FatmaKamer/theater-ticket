<?php

namespace App\Http\Controllers;

use App\Mail\TicketMail;
use App\Models\Play;
use Illuminate\Http\Request;
use App\Models\Seat;
use App\Models\Order;
use App\Models\TicketSale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Ana sayfa
     * - Giriş yapmamış → welcome.blade.php
     * - Giriş yapmış → home.blade.php (oyun listesi)
     */
    public function index()
    {

        $plays = Play::with('venue')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $breadcrumbs = [
            ['title' => 'Ana Sayfa', 'url' => null],
        ];

        return view('home', compact('plays', 'breadcrumbs'));


    }

    public function show(Play $play)
    {
        if (!$play->is_active) {
            abort(404);
        }

        $play->load('venue');

        $breadcrumbs = [
            ['title' => 'Ana Sayfa', 'url' => route('home')],
            ['title' => $play->name, 'url' => null],
        ];

        return view('play.show', compact('play', 'breadcrumbs'));
    }

    public function seatSelection(Play $play)
    {
        if (!$play->is_active) {
            abort(404);
        }

        $play->load('venue');

        // Satılmış koltuk ID'leri
        $soldSeatIds = $play->soldSeatIds();

        // Tüm koltuklar
        $seats = $play->venue->seats()
            ->where('is_active', true)
            ->orderBy('row')
            ->orderBy('number')
            ->get()
            ->map(function ($seat) use ($soldSeatIds, $play) {
                return [
                    'id' => $seat->id,
                    'code' => $seat->code,
                    'row' => $seat->row,
                    'number' => $seat->number,
                    'is_sold' => in_array($seat->id, $soldSeatIds),
                    'price' => $play->ticket_price,
                ];
            });

        $seatsByRow = $seats->groupBy('row');

        $breadcrumbs = [
            ['title' => 'Ana Sayfa', 'url' => route('home')],
            ['title' => $play->name, 'url' => route('play.show', $play)],
            ['title' => 'Koltuk Seçimi', 'url' => null],
        ];

        return view('play.seats', compact('play', 'seatsByRow', 'seats', 'breadcrumbs'));
    }

    /**
     * KOLTUKLARI GEÇİCİ REZERVE ET (AJAX)
     */
    public function reserveSeats(Request $request, Play $play)
    {
        $request->validate([
            'seat_ids' => 'required|array',
            'seat_ids.*' => 'exists:seats,id',
        ]);

        // Seçilen koltukların satılmadığından emin ol
        $soldSeatIds = $play->soldSeatIds();
        $selectedSeatIds = $request->seat_ids;

        $conflictSeats = array_intersect($selectedSeatIds, $soldSeatIds);
        if (count($conflictSeats) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Bazı koltuklar zaten satılmış!',
                'conflict_seats' => $conflictSeats,
            ], 409);
        }

        // Oturuma geçici rezervasyon kaydet
        session()->put('reserved_seats', [
            'play_id' => $play->id,
            'seat_ids' => $selectedSeatIds,
            'reserved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Koltuklar geçici olarak rezerve edildi.',
        ]);
    }

    /**
     * SİPARİŞİ ONAYLA
     */
    public function confirmOrder(Request $request, Play $play)
    {
        // Oturumdan rezervasyonu al
        $reservation = session()->get('reserved_seats');

        if (!$reservation || $reservation['play_id'] != $play->id) {
            return redirect()->route('play.seats', $play)
                ->with('error', 'Oturum süresi doldu. Lütfen tekrar deneyin.');
        }

        // 1 dakika kontrolü
        if (now()->diffInMinutes($reservation['reserved_at']) > 1) {
            session()->forget('reserved_seats');
            return redirect()->route('play.seats', $play)
                ->with('error', 'Rezervasyon süresi doldu. Lütfen tekrar deneyin.');
        }

        $seatIds = $reservation['seat_ids'];

        // Koltukların hala satılmadığından emin ol
        $soldSeatIds = $play->soldSeatIds();
        $conflictSeats = array_intersect($seatIds, $soldSeatIds);

        if (count($conflictSeats) > 0) {
            session()->forget('reserved_seats');
            return redirect()->route('play.seats', $play)
                ->with('error', 'Bazı koltuklar başka biri tarafından satın alındı.');
        }

        // Sipariş oluştur
        $totalPrice = count($seatIds) * $play->ticket_price;

        DB::beginTransaction();

        try {
            // 1. Orders oluştur
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'paid_at' => null,
            ]);



            $createdTickets = collect(); //hata sebebi collect kullanmayıp standart php dizi kullanmammış.
            foreach ($seatIds as $seatId) {
                $ticket = TicketSale::create([
                    'play_id' => $play->id,
                    'seat_id' => $seatId,
                    'user_id' => auth()->id(),
                    'order_id' => $order->id,
                    'price' => $play->ticket_price,
                    'status' => 'active',
                ]);
                $createdTickets->push($ticket);
            }

            DB::commit();


                try {
                    Mail::to(auth()->user()->email)->send(new TicketMail($createdTickets, $order, $play));
                } catch (\Throwable $e) {
                    \Log::error('Mail gönderilemedi: ' . $e->getMessage(), ['ticket_id' => $ticket->id]);
                }


            //dd(auth()->user()->email);


            // Rezervasyonu temizle
            session()->forget('reserved_seats');

            return redirect()->route('home')
                ->with('success', 'Biletler başarıyla satın alındı!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('play.seats', $play)
                ->with('error', 'Bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }
}
