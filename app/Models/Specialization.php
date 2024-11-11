<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specialization extends Model
{
    use HasFactory;

    /**
     * Get doctors for the specialization.
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}
