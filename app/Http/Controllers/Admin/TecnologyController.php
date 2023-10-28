<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tecnology;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class TecnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function index()
    {
        $tecnologies = Tecnology::all();
        return view("admin.tecnologies.index", compact("tecnologies"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tecnologies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validated();

        $type = new Tecnology();
        $type->fill($data);
        $type->save();

        return redirect()->route('admin.tecnologies.show', $type);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tecnology  $tecnology
     * @return \Illuminate\Http\Response
     */
    public function show(Tecnology $tecnology)
    {
        return view("admin.tecnologies.show", compact("tecnology"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tecnology  $tecnology
     * @return \Illuminate\Http\Response
     */
    public function edit(Tecnology $tecnology)
    {
        return view("admin.tecnologies.edit", compact("tecnology"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tecnology  $tecnology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tecnology $tecnology)
    {
        $data = $request->validated();
        $tecnology->update($data);

        return redirect()->route("admin.tecnologies.show", $tecnology);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tecnology  $tecnology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tecnology $tecnology)
    {
        $tecnology->delete();
        return redirect()->route("admin.tecnologies.index");
    }
}