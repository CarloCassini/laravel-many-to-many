@extends('layouts.app')

@section('import-cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container mt-5">
        <a class="" href="{{ route('admin.projects.index') }}">
            <div class="my-3 btn btn-success">
                back to index
            </div>
        </a>
        <div class="row">
            <div class="col-4">
                <img class="img-fluid"
                    @if ($project->cover_image) src=" {{ asset('/storage/' . $project->cover_image) }}"    
                @else
                src="" @endif
                    alt="" id="cover_image_prew">
            </div>
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Url</th>
                            <th scope="col">Description</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th scope="row">{{ $project->id }}</th>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->slug }}</td>
                            <td>{{ $project->git_url }}</td>
                            <td>{{ $project->description }}</td>

                            {{-- da qui in poi i bottoni per le interazioni --}}
                            <td>
                                <div class="d-flex gap-2 my-1  justify-content-center align-items-center">
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

                </table>
            </div>
        </div>


        {{-- spazio per le tecnologie/tipi --}}
        <div class="row gap-3">
            <div class=" col ">
                <h4> project Type</h4>
                <h5>
                    <span class="{{ $project->Type ? 'badge' : ' ' }}"
                        style="background-color: {{ $project->Type?->color }}">
                        {{-- ternario che prevede la possibilità che non ci sia nessun type  --}}
                        {{ $project->Type ? $project->Type->label : '-No Type known' }}
                    </span>
                </h5>
            </div>
            <div class=" col d-wrap">
                <h4> project tecnologies</h4>

                <h5>
                    @forelse ($project->Tecnologies as $tecnology)
                        <span class="badge me-2" style="background-color: {{ $tecnology->color }}">
                            {{ $tecnology->label }}</li>
                        </span>
                    @empty
                        -No Type known
                    @endforelse
                </h5>
            </div>

        </div>
    </div>
@endsection

@section('modals')
    <!-- Modal -->
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
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        const coverImagePrew = document.getElementById('cover_image_prew');

        if (!coverImagePrew.getAttribute('src') || coverImagePrew.getAttribute('src') == 'https://placehold.co/400') {
            coverImagePrew.src = 'https://placehold.co/400';
        }
    </script>
@endsection
