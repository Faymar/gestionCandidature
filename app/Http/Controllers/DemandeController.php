<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotaions\OpenApi as OA;

class DemandeController extends Controller
{
    /**
     * @OA \GET(
     *  PATH="/liste/demande", 
     * @OA \RESPONSE(response=200))
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function accepterDemande($id_demande, Formation $formation)
    {
        $candidats = User::get();
        $formation->candidat()
            ->wherePivot(
                'id',
                $id_demande
            )->updateExistingPivot(
                $candidats,
                ['status' => 'accepte']
            );
        return response()->json(['message' => 'la demande est acceptee avec sucess']);
    }
    public function reufuseDemande($id_demande, Formation $formation)
    {
        $candidats = User::get();
        $formation->candidat()
            ->wherePivot(
                'id',
                $id_demande
            )->updateExistingPivot(
                $candidats,
                ['status' => 'refuse']
            );
        return response()->json(['message' => 'la demande est refusee avec sucess']);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Formation $formation)
    {
        $candidat = Auth::user();
        $formation->Candidat()->attach($candidat, ['status' => 'encours']);
        return response()->json(['message' => 'votre demande est enregistree avec succes']);
    }

    /**
     * Display the specified resource.
     */
    public function listDemande()
    {
        $demandes =  Auth::user()->formations()->get();
        return response()->json($demandes);
    }


    public function listeCandudature(Formation $formation)
    {
        $demandes =  $formation->candidat()->get();
        return response()->json($demandes);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
