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

        <section class="">

            <form action="{{ route('admin.types.store') }}" method="POST">
                @csrf

                <div class="row">
                    {{-- color --}}
                    <div class="col-1 h-100">
                        <label for="color" class="form-label">color</label>
                        <input type="color"
                            class="form-control 
                        @error('color')
                                is-invalid
                        @enderror"
                            id="color" name="color" value="{{ old('color') }}" />
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
                            id="label" name="label" value="{{ old('label') }}" />
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
