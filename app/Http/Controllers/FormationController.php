<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormationRequest;
use App\Http\Requests\UpdateFormationRequest;
use App\Models\Formation;
use Illuminate\Support\Facades\Storage;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Formation::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormationRequest $request)
    {
        $request->validated($request->all());

        $formation = new Formation();

        if ($request->file('fichier')) {
            $fichierPath = $request->file('fichier')->store('fichiers/formation', 'public');
            $formation->fichier = $fichierPath;
        }
        $formation->nomFormation = $request->input('nomFormation');
        $formation->dateDebut = $request->input('dateDebut');
        $formation->dateFin = $request->input('dateFin');
        $formation->save();

        return response()->json(['Formation ajoutée avec succes', $formation]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Formation $formation)
    {
        return response()->json($formation);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formation $formation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormationRequest $request, Formation $formation)
    {
        $request->validated($request->all());

        if ($request->file('fichier')) {
            $fichierPath = $request->file('fichier')->store('fichiers/formation', 'public');
            $formation->fichier = $fichierPath;
        }
        $formation->nomFormation = $request->input('nomFormation');
        $formation->dateDebut = $request->input('dateDebut');
        $formation->dateFin = $request->input('dateFin');
        $formation->save();

        return response()->json(['Formation modifiée avec succes', $formation]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formation $formation)
    {
        Storage::disk('public')->delete($formation->fichier);
        $formation->delete();

        return response()->json(['Formation supprimée avec succes', $formation]);
    }
}
