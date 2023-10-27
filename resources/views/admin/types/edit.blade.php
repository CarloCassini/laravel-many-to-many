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

        <a class="" href="{{ route('admin.types.index') }}">
            <div class="my-3 btn btn-success">
                back to index
            </div>
        </a>

        {{-- per il delete --}}
        <div class="my-3 btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-{{ $type->id }}">
            delete item
        </div>

        <section class="">

            <form action="{{ route('admin.types.update', $type) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- color --}}
                    <div class="col-1 h-100">
                        <label for="color" class="form-label">color</label>
                        <input type="color"
                            class="form-control 
                        @error('color')
                                is-invalid
                        @enderror"
                            id="color" name="color" value="{{ old('color') ?? $type->color }}" />
                        @error('color')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- label --}}
                    <div class="col-11 h-100">
                        <label for="label" class="form-label">label</label>
                        <input type="text"
                            class="form-control 
                            @error('label')
                                is-invalid
                            @enderror"
                            id="label" name="label" value="{{ old('label') ?? $type->label }}" />
                        @error('label')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                {{-- bottone di invio form --}}
                <button type="submit" class="btn btn-primary my-3">Salva</button>
            </form>
    </div>
    </section>

@endsection

@section('modals')
    <!-- Modal -->
    <div class="modal fade" id="modal-{{ $type->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"> Cancellare {{ $type->label }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    confermare la cancellazione di <span class="text-danger fw-bolder">{{ $type->label }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Decline</button>
                    <form action="{{ route('admin.types.destroy', $type) }}" method="POST">
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
