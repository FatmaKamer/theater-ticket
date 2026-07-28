@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="play-title">
                    <span>{{ $play->name }}</span>
                </h1>
                <p class="play-meta">
                    <i class="fas fa-map-pin"></i>
                    {{ $play->venue->name }}
                    <span class="mx-2">|</span>
                    <i class="fas fa-ticket-alt"></i>
                    {{ number_format($play->ticket_price, 2) }} ₺ / koltuk
                </p>
            </div>
        </div>

        <div class="row">
            <!-- Sol: Koltuklar -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="play-title text-center mb-3">SAHNE</h5>

                        <!-- Koltuk Matrisi -->
                        <div class="seat-matrix">
                            <table class="seat-table">
                                <thead>
                                <tr>
                                    <th class="corner"></th>
                                    @for($i = 1; $i <= 10; $i++)
                                        <th class="seat-col-header">{{ $i }}</th>
                                    @endfor
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($seatsByRow as $row => $rowSeats)
                                    <tr>
                                        <td class="seat-row-header">{{ $row }}</td>
                                        @foreach($rowSeats as $seat)
                                            <td>
                                                <button class="seat {{ $seat['is_sold'] ? 'sold' : '' }}"
                                                        data-id="{{ $seat['id'] }}"
                                                        data-code="{{ $seat['code'] }}"
                                                        data-price="{{ $seat['price'] }}"
                                                    {{ $seat['is_sold'] ? 'disabled' : '' }}>
                                                    {{ $seat['number'] }}
                                                </button>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Lejant -->
                        <div class="text-center mt-3">
                            <span class="badge" style="background: #28a745; color: white; padding: 6px 14px; border-radius: 50px;">Müsait</span>
                            <span class="badge" style="background: #007bff; color: white; padding: 6px 14px; border-radius: 50px;">Seçili</span>
                            <span class="badge" style="background: #6c757d; color: white; padding: 6px 14px; border-radius: 50px;">Dolu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sağ: Özet -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="summary-title">
                            <i class="fas fa-shopping-cart"></i> Seçim Özeti
                        </h5>
                        <hr>
                        <ul id="selected-list" class="list-unstyled">
                            <li class="text-muted">Henüz koltuk seçilmedi.</li>
                        </ul>
                        <hr>
                        <p><strong>Toplam: </strong><span id="total-price">0.00</span> ₺</p>

                        <button id="clear-btn" class="btn-theater-outline" style="padding: 8px 20px; font-size: 0.9rem; text-align: center; width: 100%;">
                            <i class="fas fa-trash"></i> Hepsini Sil
                        </button>
                        <button id="pay-btn" class="btn-theater" style="padding: 12px 30px; font-size: 1rem; text-align: center; width: 100%; margin-top: 8px;">
                            <i class="fas fa-credit-card"></i> Ödemeye Geç
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .seat-matrix {
            max-width: 600px;
            margin: 0 auto;
            overflow-x: auto;
        }

        .seat-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .seat-table th, .seat-table td {
            padding: 4px;
            min-width: 35px;
        }

        .corner {
            min-width: 30px;
        }

        .seat-col-header {
            font-weight: 700;
            font-size: 13px;
            color: #5C1A1A;
            padding-bottom: 8px;
        }

        .seat-row-header {
            font-weight: 700;
            font-size: 14px;
            color: #5C1A1A;
            padding-right: 10px;
        }

        .seat {
            aspect-ratio: 1 / 1;
            width: 100%;
            border: none;
            border-radius: 6px;
            background: #28a745;
            color: white;
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            min-height: 30px;
        }

        .seat:hover:not(.sold):not(.selected) {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        }

        .seat.sold {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .seat.selected {
            background: #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
        }

        .seat:disabled {
            cursor: not-allowed;
        }

        #selected-list li {
            padding: 6px 10px;
            background: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 4px;
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selected = [];

            // Koltuk tıkla
            document.querySelectorAll('.seat:not(.sold)').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const code = this.dataset.code;
                    const price = parseFloat(this.dataset.price);

                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        selected = selected.filter(s => s.id !== id);
                    } else {
                        this.classList.add('selected');
                        selected.push({ id, code, price });
                    }
                    updateUI();
                });
            });

            function updateUI() {
                const list = document.getElementById('selected-list');
                const total = document.getElementById('total-price');

                if (selected.length === 0) {
                    list.innerHTML = '<li class="text-muted">Henüz koltuk seçilmedi.</li>';
                    total.textContent = '0.00';
                    return;
                }

                list.innerHTML = selected.map(s =>
                    `<li>${s.code} - ${s.price.toFixed(2)} ₺</li>`
                ).join('');

                const sum = selected.reduce((a, b) => a + b.price, 0);
                total.textContent = sum.toFixed(2);
            }

            // Hepsini sil
            document.getElementById('clear-btn').addEventListener('click', function() {
                document.querySelectorAll('.seat.selected').forEach(s => s.classList.remove('selected'));
                selected = [];
                updateUI();
            });

            // Ödemeye geç
            document.getElementById('pay-btn').addEventListener('click', function() {
                if (selected.length === 0) {
                    alert('Lütfen en az bir koltuk seçin.');
                    return;
                }
                const codes = selected.map(s => s.code).join(', ');
                alert('Seçilen koltuklar: ' + codes);
            });
        });
    </script>
@endpush
