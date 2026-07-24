@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit"></i> Salon Düzenle: {{ $venue->name }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.venues.update', $venue) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Salon Adı -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Salon Adı <span class="text-danger">*</span></label>
                            <input type="text" class="form-control login-input @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $venue->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Adres -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Adres</label>
                            <textarea class="form-control login-input @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="2">{{ old('address', $venue->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Telefon ve Email -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Telefon</label>
                                    <input type="text" class="form-control login-input @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $venue->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control login-input @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email', $venue->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Website ve Kapasite -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control login-input @error('website') is-invalid @enderror"
                                           id="website" name="website" value="{{ old('website', $venue->website) }}" placeholder="https://...">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="capacity" class="form-label">Kapasite <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control login-input @error('capacity') is-invalid @enderror"
                                           id="capacity" name="capacity" value="{{ old('capacity', $venue->capacity) }}" required min="1">
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Açıklama -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea class="form-control login-input @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $venue->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Resim -->
                        <div class="mb-3">
                            @if($venue->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $venue->image) }}"
                                         alt="{{ $venue->name }}"
                                         style="max-width: 200px; border-radius: 5px;">
                                </div>
                            @endif
                            <label for="image" class="form-label">Salon Görseli</label>
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
                                <!-- ⭐ Hidden input: checkbox işaretlenmediğinde 0 gönderir -->
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                    {{ $venue->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                        </div>

                        <!-- Butonlar -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-theater">
                                <i class="fas fa-save"></i> Güncelle
                            </button>
                            <a href="{{ route('admin.venues.index') }}" class="btn-theater-outline">
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
