<?php

namespace App\Http\Controllers;

use App\Models\DatosP;
use Illuminate\Http\Request;

class ApiDatosPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DatosP::orderBy('id', 'desc')->get();
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
        // return 'datos recibidos';
        // return $request->all();

        $datos = new DatosP();

        $datos->nombre = $request->nombre;
        $datos->posicion = $request->posicion;
        $datos->salario = $request->salario;
        $datos->save();

        return 'Datos Guardados Correctamente';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DatosP $datosp)
    {
        $datosp->nombre = $request->nombre;
        $datosp->posicion = $request->posicion;
        $datosp->salario = $request->salario;
        $datosp->save();

        return 'Datos editados correctamente';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DatosP $datosp)
    {
        // DatosP $datosp
        $datosp->delete();

        return 'Registro eliminado correctamente';
    }
}
