<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use App\Models\Vacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
//use App\Http\Controllers\Controller;


class VacantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$this->authorize('viewAny',Vacante::class);
      //  Gate::authorize('viewAny',Vacante::class);--> Aqui esta comantado pero hay que descomentar XDD sirve para que user 1 no pueda crear vacante xdd
        return view('vacantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        Gate::authorize('create',Vacante::class);
        return  view('vacantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Vacante $vacante)
    {
        //
        return view('vacantes.show',[
            'vacante'=>$vacante
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vacante $vacante)
    {
        //
                //$this->authorize('update',$vacante);
                Gate::authorize('update', $vacante);
                

                return view('vacantes.edit',[
                    'vacante'=>$vacante
                ]);
    }

    public function obtenerEstadisticas()
{
    // Obtener el mes actual
    $mesActual = now()->format('Y-m');

    // Consultar las vacantes publicadas y tomadas en el mes actual
    $estadisticas = DB::table('vacantes')
    ->selectRaw("
        DATE_FORMAT(created_at, '%d') as dia, 
        COUNT(CASE WHEN publicado = 1 THEN 1 END) as publicadas,
        COUNT(CASE WHEN publicado = 0 THEN 1 END) as tomadas
    ")
    ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$mesActual])
    ->groupBy('dia')
    ->orderBy('dia')
    ->get();

    // Formatear datos para la gráfica
    $dias = $estadisticas->pluck('dia');
    $publicadas = $estadisticas->pluck('publicadas');
    $tomadas = $estadisticas->pluck('tomadas');

    return response()->json([
        'dias' => $dias,
        'publicadas' => $publicadas,
        'tomadas' => $tomadas,
    ]);
}

public function mostrarVistaEstadisticas()
{
    return view('estadisticas');
}


    /**
     * Update the specified resource in storage.
     */
   // public function update(Request $request, string $id)
   // {
        //
   // }

    /**
     * Remove the specified resource from storage.
     */
   // public function destroy(string $id)
   // {
        //
  //  }
}
