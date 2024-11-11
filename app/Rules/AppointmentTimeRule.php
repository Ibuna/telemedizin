<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AppointmentTimeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (isTooLate($value)) {
            $fail('To late for appointment time.');
        }
    }

    private function isTooLate($value)
    {
        // Set the timezone
        $timezone = new DateTimeZone('Europe/Berlin');

        // Create DateTime object
        $dateTime = new DateTime($value, $timezone);

        $time = new DateTime('20:00', $timezone);

        // Check
        return $dateTime > $time;
    }
}
