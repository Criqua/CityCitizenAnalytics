<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Citizen;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $totalCities = City::count();
        $totalCitizens = Citizen::count();
        $citizensPerCity = City::withCount('citizens')->orderBy('citizens_count', 'desc')->get();

        return view('dashboard', compact('totalCities', 'totalCitizens', 'citizenPerCity'));
    }
}
