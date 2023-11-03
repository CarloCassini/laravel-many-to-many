<?php

// bisogna aggiornare la netspace con admin alla fine
namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Type;
use App\Models\Tecnology;
use Illuminate\Http\Request;

// deve andare a perscare il controller dalla cartella controllers
use App\Http\Controllers\Controller;

// per usare la classe STR
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

// per usare lo storage delle immagini
use Illuminate\Support\Facades\Storage;

// per gestire l'invio della mail
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectPublished;


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

        // archivio l'immagine arrivata dall'utente
        if ($request->hasFile('cover_image')) {
            $cover_image_path = Storage::put('uploads/projects/cover_image', $data['cover_image']);
            $project->cover_image = $cover_image_path;
        }

        $project->save();

        // collego il post creato alla tabella delle tecnologie usate
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

        $project->fill($data);

        // gestione della cancellazione dell'immagine
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            $cover_image_path = Storage::put('uploads/projects/cover_image', $data['cover_image']);
            $project->cover_image = $cover_image_path;
        }

        if (Arr::exists($data, 'tecnologies')) {
            $project->tecnologies()->sync($data['tecnologies']);
        } else {
            $project->tecnologies()->detach();
        }

        $project->save();

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

        // gestisco la cancellazione dell'immagine
        // contorllo se esiste un'immagine del post
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index');
        //
    }

    // metodo per la cancellazione dell'immagine
    public function deleteImage(Project $project)
    {
        Storage::delete($project->cover_image);
        $project->cover_image = null;
        $project->save();

        return redirect()->back();
    }

    public function publish(Project $project, Request $request)
    {

        $data = $request->all();
        // dd($data);
        $project->published = Arr::exists($data, 'published') ? '1' : null;

        $project->save();

        // da aggiungere l'invio della mail

        // per sapere chi è l'utente loggato
        $user = Auth::user();

        $published_project_mail = new ProjectPublished($project);
        Mail::to($user->email)->send($published_project_mail);


        return redirect()->back();
        // sono arrivato al minuto 00:32 della lezione
    }

}