<?php

namespace App\Http\Requests\Admin;

use App\Rules\ActiveVenue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'author' => 'nullable|string|max:255',
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|string',
            'venue_id' => ['required', 'exists:venues,id', new ActiveVenue], // Custom rule
            'is_active' => 'required|boolean',
            'ticket_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Oyun adı zorunludur.',
            'name.max' => 'isim max 50 karakter olabilir.',
            'name.string' => 'İsim alanı sadece harflerden oluşabilir.',
            'description.string' => 'Açıklama alanı sadece harflerden oluşmalıdır.',
            'duration.integer' => 'Süre bilgisi sayı olmalıdır.',
            'duration.min' => 'Süre bilgi min 1 dk olabilir.',
            'author.string' => 'Yazar ismi harflerden oluşmalıdır.',
            'venue_id.required' => 'Salon seçimi zorunludur.',
            'venue_id.exists' => 'Seçilen salon geçersiz.',
            'venue_id.active_venue' => 'Seçilen salon pasif durumda. Aktif bir salon seçiniz.',
            'ticket_price.required' => 'Bilet fiyatı zorunludur.',
            'ticket_price.numeric' => 'Bilet fiyatı sayı olmalıdır.',
            'ticket_price.min' => 'Bilet fiyatı 0\'dan küçük olamaz.',
            'image.image' => 'Dosya resim formatında olmalıdır.',
            'image.max' => 'Resim en fazla 2MB olabilir.',
        ];
    }
}
