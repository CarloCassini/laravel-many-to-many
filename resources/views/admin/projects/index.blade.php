@extends('layouts.app')

@section('import-cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container mt-5">
        <a class="my-3" href="{{ route('admin.projects.create') }}">
            <div class="btn btn-success">
                create new project
            </div>
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Url</th>
                    <th scope="col">Description</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>

            @foreach ($projects as $project)
                <tbody>
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->name }}</td>
                        <td><span class="badge"
                                style="background-color: {{ $project->Type?->color }}">{{ $project->Type?->label }}</span>
                        </td>
                        <td>{{ $project->slug }}</td>
                        <td>{{ $project->git_url }}</td>
                        <td>{{ $project->description }}</td>
                        {{-- da qui in poi i bottoni per le interazioni --}}
                        <td>
                            <div class="d-flex gap-2 my-1  justify-content-center align-items-center">
                                <a href="{{ route('admin.projects.show', $project) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}">
                                    <i class="fa-solid fa-file-pen"></i>
                                </a>

                                <!-- Button trigger modal -->
                                <span class="delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#ciccio{{ $project->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </span>


                            </div>

                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>
@endsection

@section('modals')
    <section class="container my-5">



        <!-- Modal -->
        @foreach ($projects as $project)
            <div class="modal fade" id="ciccio{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"> Cancellare {{ $project->name }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            confermare la cancellazione di <span class="text-danger fw-bolder">{{ $project->name }}</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Decline</button>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
