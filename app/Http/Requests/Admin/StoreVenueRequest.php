<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVenueRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20|min:10',
            'email' => 'nullable|email|max:255|min:5',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:100',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048', // 2MB
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Salon adı zorunludur.',
            'name.string' => 'Salon adı sadece harflerden oluşmalıdır',
            'name.max' => 'Salon adı max 255 karakter olmalıdır.',
            'name.min' => 'Salon adı min 3 karakter olmalıdır.',
            'capacity.required' => 'Kapasite zorunludur.',
            'capacity.min' => 'Kapasite en az 1 olmalıdır.',
            'image.image' => 'Dosya resim formatında olmalıdır.',
            'image.max' => 'Resim en fazla 2MB olabilir.',
            'is_active.required' => 'Aktiflik alanı zorunludur.',
        ];
    }
}
