<?php

namespace App\Mail;

use App\Models\TicketSale;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tickets;      // Birden fazla bilet
    public $order;        // Sipariş bilgisi
    public $totalPrice;   // Toplam fiyat
    public $play;         // Oyun bilgisi (ortak)

    /**
     * Create a new message instance.
     */
    public function __construct($tickets, Order $order, $play)
    {
        $this->tickets = $tickets;           // TicketSale koleksiyonu
        $this->order = $order;               // Sipariş
        $this->totalPrice = $order->total_price;
        $this->play = $play;                 // Oyun (tüm biletler aynı oyuna ait)
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎭 Biletleriniz Hazır! - ' . $this->play->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',  // Yeni view: tickets.blade.php
        );
    }
}
