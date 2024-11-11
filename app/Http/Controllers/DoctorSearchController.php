<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DoctorRepositoryInterface;

class DoctorSearchController extends Controller
{
    protected $doctorRepository;

    public function __construct(DoctorRepositoryInterface $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function search(Request $request)
    {
        $searchterm = $request->input('searchterm');

        $doctors = $this->doctorRepository->searchBySpecialization($searchterm);

        return response()->json($doctors);
    }
}
