@extends('layouts.app')

@section('import-cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container mt-5">

        {{-- mostra tutti gli errori riscontrati nella validazione --}}
        @if ($errors->any())
            <div class="alert alert-warning">
                <h5>correggi i seguenti errori</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <a class="" href="{{ route('admin.projects.index') }}">
            <div class="my-3 btn btn-success">
                back to index
            </div>
        </a>

        {{-- per il delete --}}
        <div class="my-3 btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-{{ $project->id }}">
            delete item
        </div>


        <section>
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- immagine --}}
                <div>
                    <div class="row">
                        <div class="col-4">
                            <img class="img-fluid" src="{{ asset('/storage/' . $project->cover_image) }}" alt=""
                                id="cover_image_prew">
                        </div>
                        <div class="col-8">
                            <label for="cover_image" class="form-label">immagine</label>
                            <input type="file"
                                class=" mb-2 form-control 
                                            @error('cover_image') is-invalid @enderror"
                                id="cover_image" name="cover_image"
                                value="{{ old('cover_image') ?? $project->cover_image }}" />
                            @error('cover_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                </div>



                {{-- name --}}
                <div>
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control
      @error('name')
       is-invalid
      @enderror"
                        id="name" name="name" value="{{ old('name') ?? $project->name }}" />
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- git_url --}}
                <div>
                    <label for="git_url" class="form-label">Url repository</label>
                    <textarea class="form-control
      @error('git_url')
        is-invalid
      @enderror" id="git_url" name="git_url"
                        rows="1">{{ old('git_url') ?? $project->git_url }}</textarea>
                    @error('git_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- description --}}
                <div>
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control
      @error('description')
        is-invalid
      @enderror" id="description"
                        name="description" rows="5">{{ old('description') ?? $project->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- inserimento select --}}
                <div>
                    <label for="type_id" class="form-label">Categoria</label>
                    <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror">
                        <option value="">Non categorizzato</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" @if (old('type_id') ?? $project->Type?->id == $type->id) selected @endif>
                                {{ $type->id }} - {{ $type->label }}
                            </option>
                        @endforeach
                    </select>
                    @error('type_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- gestione delle checkbox x le tecnologie --}}
                <div>
                    <label class="form-label">Tecnologie</label>

                    <div class="form-check @error('tecnologies') is-invalid @enderror p-0">
                        @foreach ($tecnologies as $tecnology)
                            <input type="checkbox" id="tecnology-{{ $tecnology->id }}" value="{{ $tecnology->id }}"
                                name="tecnologies[]" class="form-check-control"
                                @if (in_array($tecnology->id, old('tecnologies', $project_tecnologies ?? []))) checked @endif>
                            <label class="me-3" for="tecnology-{{ $tecnology->id }}">
                                {{ $tecnology->label }}
                            </label>
                        @endforeach
                    </div>
                    @error('tecnologies')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- bottone invio form --}}
                <div>
                    <button type="submit" class="btn btn-primary my-3">modifica</button>
                </div>
            </form>
    </div>
    </section>
@endsection

@section('modals')
    <!-- Modal -->
    <div class="modal fade" id="modal-{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
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
        const inputFileElement = document.getElementById('cover_image');
        const coverImagePrew = document.getElementById('cover_image_prew');

        inputFileElement.addEventListener('change', function() {
            const [file] = this.files;
            coverImagePrew.src = URL.createObjectURL(file);

            // alert('img cambiata');
        })
    </script>
@endsection
