@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-plus"></i> Yeni Oyun Ekle
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.plays.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Oyun Adı -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Oyun Adı <span class="text-danger">*</span></label>
                                <input type="text" class="form-control login-input @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Açıklama -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Açıklama</label>
                                <textarea class="form-control login-input @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Yazar ve Yönetmen -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Yazar</label>
                                        <input type="text" class="form-control login-input @error('author') is-invalid @enderror"
                                               id="author" name="author" value="{{ old('author') }}">
                                        @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="director" class="form-label">Yönetmen</label>
                                        <input type="text" class="form-control login-input @error('director') is-invalid @enderror"
                                               id="director" name="director" value="{{ old('director') }}">
                                        @error('director')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Oyuncular ve Süre -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="cast" class="form-label">Oyuncular</label>
                                        <input type="text" class="form-control login-input @error('cast') is-invalid @enderror"
                                               id="cast" name="cast" value="{{ old('cast') }}" placeholder="Virgülle ayırarak yazın">
                                        @error('cast')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="duration" class="form-label">Süre (dk)</label>
                                        <input type="number" class="form-control login-input @error('duration') is-invalid @enderror"
                                               id="duration" name="duration" value="{{ old('duration') }}" min="1">
                                        @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Salon ve Fiyat -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="venue_id" class="form-label">Salon <span class="text-danger">*</span></label>
                                        <select class="form-control login-input @error('venue_id') is-invalid @enderror"
                                                id="venue_id" name="venue_id" required>
                                            <option value="">Salon seçin</option>
                                            @foreach($venues as $venue)
                                                <option value="{{ $venue->id }}" {{ old('venue_id') == $venue->id ? 'selected' : '' }}>
                                                    {{ $venue->name }} ({{ $venue->is_active ? 'Aktif' : 'Pasif' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('venue_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Sadece aktif ve boş salonlar seçilebilir.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="ticket_price" class="form-label">Bilet Fiyatı (₺) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control login-input @error('ticket_price') is-invalid @enderror"
                                               id="ticket_price" name="ticket_price" value="{{ old('ticket_price', 0) }}" step="0.01" min="0">
                                        @error('ticket_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Afiş -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Afiş Görseli</label>
                                <input type="file" class="form-control login-input @error('image') is-invalid @enderror"
                                       id="image" name="image" accept="image/*">
                                <small class="text-muted">Maksimum 2MB, JPG, PNG, GIF</small>
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Aktif/Pasif -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                        {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Bilet Satışı Açık (Aktif)</label>
                                </div>
                                <small class="text-muted">Oyun oluşturulduktan sonra bilet satışı başlatmak için işaretleyin.</small>
                            </div>

                            <!-- Butonlar -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn-theater">
                                    <i class="fas fa-save"></i> Kaydet
                                </button>
                                <a href="{{ route('admin.plays.index') }}" class="btn-theater-outline">
                                    <i class="fas fa-times"></i> İptal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
