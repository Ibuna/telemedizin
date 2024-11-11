<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Specialization;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    use HasFactory;

    /**
     * Get specialization.
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    /**
     * Get appointments for the doctor.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get timeslots for the doctor.
     */
    public function timeslots(): HasMany
    {
        return $this->hasMany(TimeSlot::class);
    }
}
