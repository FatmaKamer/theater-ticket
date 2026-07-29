<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Play;
use App\Models\TicketSale;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(TicketSale::class, 'ticket');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TicketSale::with(['play', 'user', 'seat']);

        // Filtreleme
        if ($request->filled('play_id')) {
            $query->where('play_id', $request->play_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(20);
        $plays = Play::where('is_active', true)->get();
        $users = User::all();

        $breadcrumbs = [
            ['title' => 'Ana Sayfa', 'url' => route("admin.dashboard")],
            ['title' => 'Bilet Yönetimi', 'url' => null],
        ];

        return view('admin.tickets.index', compact('tickets', 'plays', 'users', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketSale $ticket)
    {
        $ticket->load(['play', 'seat', 'user', 'order']);

        $breadcrumbs = [
            ['title' => 'Ana Sayfa', 'url' => route("admin.dashboard")],
            ['title' => 'Bilet Yönetimi', 'url' => route("admin.tickets.index")],
            ['title' => 'Bilet #' . $ticket->id, 'url' => null],
        ];
        return view('admin.tickets.show', compact('ticket', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketSale $ticket)
    {
        if ($ticket->status !== 'active') {
            return redirect()->route('admin.tickets.index')
                ->with('error', 'Bu bilet zaten iptal edilmiş.');
        }

        $ticket->update(['status' => 'cancelled']);
        /*
        // Koltukları tekrar aktif yap (isteğe bağlı)
        if ($ticket->seat) {
            $ticket->seat()->update(['is_sold' => false]);
        }*/

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Bilet başarıyla iptal edildi.');
    }
}
