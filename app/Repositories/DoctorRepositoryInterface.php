<?php
namespace App\Repositories;

interface DoctorRepositoryInterface
{
    public function searchBySpecialization(string $searchterm);
}