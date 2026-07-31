<?php

namespace App\Http\Controllers;

use App\Models\TicketSale;
use Illuminate\Http\Request;

class UserTicketController extends Controller
{
    public function show(TicketSale $ticket)
    {
        // Güvenlik: Sadece biletin sahibi veya admin görebilir
        if (auth()->id() !== $ticket->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Bu bileti görüntüleme yetkiniz yok.');
        }

        // Tıklanan biletin order_id'sine sahip TÜM biletleri getir
        $tickets = TicketSale::with(['play.venue', 'seat'])
            ->where('order_id', $ticket->order_id)
            ->get();

        // Oyun ve salon bilgisi tüm biletler için aynı olduğundan ilk biletten alabiliriz
        $play = $ticket->play;
        $venue = $play->venue;
        $order = $ticket->order;

        // Artık tek bir $ticket değil, tüm $tickets koleksiyonunu gönderiyoruz
        return view('ticket.show', compact('tickets', 'play', 'venue', 'order'));
    }
}
