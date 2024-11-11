<?php
// app/Repositories/DoctorRepository.php
namespace App\Repositories;

use App\Models\Doctor;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function searchBySpecialization(string $searchterm)
    {
        return Doctor::with('specialization')
            ->whereHas('specialization', function ($query) use ($searchterm) {
                $query->where('name', 'like', '%' . $searchterm . '%');
            })
            ->get();
    }
}