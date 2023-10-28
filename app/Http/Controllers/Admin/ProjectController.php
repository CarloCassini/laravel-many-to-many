<?php

// bisogna aggiornare la netspace con admin alla fine
namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Type;
use App\Models\Tecnology;
// use Illuminate\Http\Request;

// deve andare a perscare il controller dalla cartella controllers
use App\Http\Controllers\Controller;

// per usare la classe STR
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view("admin.projects.index", compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function create()
    {
        $tecnologies = Tecnology::all();
        $types = Type::all();
        return view('admin.projects.create', compact('types', 'tecnologies'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * *@return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        // se la validazione non va a buon fine tutto si blocca qui e rimanda alla pagina di create
        $data = $request->validated();


        $project = new Project();
        $project->fill($data);

        $project->slug = Str::slug($project->name);
        $project->save();

        if (Arr::exists($data, 'tecnologies')) {
            $project->tecnologies()->attach($data['tecnologies']);
        }

        return redirect()->route('admin.projects.show', $project);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * *@return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        return view("admin.projects.show", compact("project"));

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * *@return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $tecnologies = Tecnology::all();
        $project_tecnologies = $project->tecnologies->pluck('id')->toArray();
        return view("admin.projects.edit", compact("project", "types", 'tecnologies', 'project_tecnologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        // gestisco lo slug
        // ma gestito prima di update, evidentemente prende esattamente le righe toccate
        $project->slug = Str::slug($project->name);


        $project->update($data);

        if (Arr::exists($data, 'tecnologies')) {
            $project->tecnologies()->sync($data['tecnologies']);
        } else {
            $project->tecnologies()->detach();
        }


        return redirect()->route("admin.projects.show", $project);
        // dd($data);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->tecnologies()->detach();
        $project->delete();
        return redirect()->route('admin.projects.index');
        //
    }

}