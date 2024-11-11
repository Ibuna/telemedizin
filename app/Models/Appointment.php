<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Timeslot;

class Appointment extends Model
{
    use HasFactory;

    /**
     * Get doctor.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}