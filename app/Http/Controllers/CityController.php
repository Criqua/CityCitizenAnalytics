<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cities = City::orderBy('name', 'asc')->paginate(6);
            return view('cities.index', compact('cities'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener las ciudades: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('cities.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de creación: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:50|unique:cities,name',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'El nombre de la ciudad es obligatorio.',
            'name.string' => 'El nombre de la ciudad debe ser una cadena de texto.',
            'name.unique' => 'El nombre de la ciudad ya existe.',
            'name.max' => 'El nombre de la ciudad no puede exceder los 50 caracteres.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',
        ]);

        try {
            City::create($request->all());
            return redirect()->route('cities.index')->with('success', 'Ciudad creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $city = City::findOrFail($id);
            return view('cities.show', compact('city'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al mostrar la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $city = City::findOrFail($id);
            return view('cities.edit', compact('city'));
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
            'name' => "required|string|max:50|unique:cities,name,{$id}",
            'description' => 'nullable|string|max:500',
        ], [
            'name.required' => 'El nombre de la ciudad es obligatorio.',
            'name.string' => 'El nombre de la ciudad debe ser una cadena de texto.',
            'name.unique' => 'El nombre de la ciudad ya existe.',
            'name.max' => 'El nombre de la ciudad no puede exceder los 50 caracteres.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',
        ]);

        try {
            $city = City::findOrFail($id);
            $city->update($request->all());
            return redirect()->route('cities.index')->with('success', 'Ciudad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la ciudad: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::withCount('citizens')->findOrFail($id);

        if ($city->citizens_count > 0) {
            return redirect()->back()
                ->with('warning', 'No se puede eliminar la ciudad porque tiene ciudadanos registrados.');
        }

        try {
            $city->delete();
            return redirect()->route('cities.index')
                ->with('success', 'Ciudad eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al eliminar la ciudad: ' . $e->getMessage()]);
        }
    }

}
