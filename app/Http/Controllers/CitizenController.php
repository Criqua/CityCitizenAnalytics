<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Citizen;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $citiesQuery = City::with(['citizens' => function($q) {
            $q->orderBy('first_name', 'asc');
        }])->orderBy('name', 'asc')

        // 2) Filtra ciudades: nombre O having ciudadanos coincidentes
        ->when($search, function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
            ->orWhereHas('citizens', function($q2) use ($search) {
                $q2->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name',  'like', "%{$search}%");
            });
        });

        $cities = $citiesQuery->paginate(6)->appends(['search' => $search]);

        if ($search) {
            $cities->getCollection()->transform(function($city) use ($search) {
                // Si la ciudad coincide por nombre, se devuelven sus ciudadanos
                if (stripos($city->name, $search) !== false) {
                    return $city;
                }

                // Si no, se devuelven solo los ciudadanos cuyo nombre/apellido coincida
                $filtered = $city->citizens->filter(function($c) use ($search) {
                    return stripos($c->first_name, $search) !== false
                    || stripos($c->last_name,  $search) !== false;
                })->values();

                $city->setRelation('citizens', $filtered);
                return $city;
            });
        }

        return view('citizens.index', compact('cities', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $cities = City::orderBy('name', 'asc')->get();
            return view('citizens.create', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al mostrar el formulario de creación: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'birth_date' => 'required|date',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:500',
            'phone_number' => 'nullable|string|max:15',
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required' => 'El apellido es obligatorio.',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'city_id.required' => 'La ciudad es obligatoria.',
            'address.required' => 'La dirección es obligatoria.',
        ]);

        try {
            Citizen::create($request->all());
            return redirect()->route('citizens.index')->with('success', 'Ciudadano creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el ciudadano: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            return view('citizens.show', compact('citizen'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener el ciudadano: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            $cities = City::orderBy('name', 'asc')->get();
            return view('citizens.edit', compact('citizen', 'cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al mostrar el formulario de edición: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'birth_date' => 'required|date',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string|max:500',
            'phone_number' => 'nullable|string|max:15',
        ]);

        try {
            $citizen = Citizen::findOrFail($id);
            $citizen->update($request->all());
            return redirect()->route('citizens.index')->with('success', 'Ciudadano actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el ciudadano: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $citizen = Citizen::findOrFail($id);
            $citizen->delete();
            return redirect()->route('citizens.index')->with('success', 'Ciudadano eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el ciudadano: ' . $e->getMessage());
        }
    }

}
