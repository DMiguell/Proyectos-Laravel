<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use App\Models\Candidato;
use Illuminate\Http\Request;
use App\Notifications\NuevoCandidato;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // Obtener el ID Actual

        $id_vacante = $request->route('id');
        // Obtener los candiatos y la vacante
        $vacante = Vacante::findOrFail($id_vacante);

        $this->authorize('view', $vacante);

        return view('candidatos.index', compact('vacante'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validacion
        $data = $request->validate([
            'nombre' => 'required',
            'email' => 'required',
            'cv' => 'required|mimes:pdf|max:1000',
            'vacante_id' => 'required'
        ]);

        // Alamcenar archivo pdf

        if($request->file('cv'))
        {
            $archivo = $request->file('cv');
            $nombreArchivo = time() . "." . $request->file('cv')->extension();
            $ubicacion = public_path('/storage/cv');
            $archivo->move($ubicacion, $nombreArchivo);
        }
        

    // Cuarta forma es crear una function hasmany en vacante.php
        $vacante = Vacante::find($data['vacante_id']);
        
        $vacante->candidatos()->create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'cv' => $nombreArchivo
        ]);

        $reclutador = $vacante->reclutador;
        $reclutador->notify( new NuevoCandidato( $vacante->titulo, $vacante->id)); //  hay que importar la clase use App\Notifications\NuevoCandidato;

        /* Una Forma
            $candidato = new Candidato();
            $candidato->nombre = $data['nombre'];
            $candidato->email = $data['email'];
            $candidato->vacante_id=$data['vacante_id'];
            $candidato->cv = "123.pdf";

            $candidato->save();
        */
        /* Segunda Forma
        $candidato = new Candidato($data);
        $candidato->cv = "123.pdf";
        $candidato->save();
        */

        /* Tercer Forma

        $candidato = new Candidato();
        $candidato->fill($data);
        $candidato->cv = "123.pdf";
        $candidato->save();
        */
        
        return back()->with('estado','Tus datos se enviaron Correctamente! Suerte');
    }

    /** 
     * Display the specified resource.
     *
     * @param  \App\Models\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function show(Candidato $candidato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function edit(Candidato $candidato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Candidato $candidato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Candidato  $candidato
     * @return \Illuminate\Http\Response
     */
    public function destroy(Candidato $candidato)
    {
        //
    }
}
