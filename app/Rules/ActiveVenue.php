<?php

namespace App\Rules;

use App\Models\Venue;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ActiveVenue implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $venue = Venue::find($value);

        if (!$venue || !$venue->is_active) {
            $fail('Seçilen salon aktif değil lütfen aktif bir salon seçin.');
        }

        if ($venue && $venue->hasActivePlay()) {
            $fail('Bu salonda zaten aktif bir oyun var. Lütfen başka bir salon seçin.');
        }
    }
}
