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

        <section class="">

            <form action="{{ route('admin.projects.store') }}" method="POST">
                @csrf

                {{-- name --}}
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control 
      @error('name')
        is-invalid
      @enderror"
                    id="name" name="name" value="{{ old('name') }}" />
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                {{-- git_url --}}
                <label for="git_url" class="form-label">Url repository</label>
                <textarea class="form-control
      @error('git_url')
       is-invalid
      @enderror " id="git_url" name="git_url"
                    rows="1">{{ old('git_url') }}</textarea>
                @error('git_url')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                {{-- description --}}
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control 
      @error('description')
        is-invalid
      @enderror" id="description"
                    name="description" rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                {{-- select del Type --}}
                <label for="type_id" class="form-label">Categoria</label>
                <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror">
                    <option value="">no Type</option>

                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" @if (old('type_id') == $type->id) selected @endif>
                            {{ $type->label }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                {{-- bottone di invio form --}}
                <button type="submit" class="btn btn-primary my-3">Salva</button>
            </form>
    </div>
    </section>

@endsection
