@extends('layouts.app')

@section('import-cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container mt-5">
        <a class="my-3" href="{{ route('admin.types.create') }}">
            <div class="btn btn-success">
                create new types
            </div>
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">label</th>
                    <th scope="col">color</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>

            @foreach ($types as $type)
                <tbody>
                    <tr>
                        <th scope="row">{{ $type->id }}</th>
                        <td>{{ $type->label }}</td>
                        <td>
                            <span class="badge" style="background-color: {{ $type->color }}">{{ $type->color }}</span>
                        </td>

                        {{-- da qui in poi i bottoni per le interazioni --}}
                        <td>
                            <div class="d-flex gap-2 my-1  justify-content-center align-items-center">
                                <a href="{{ route('admin.types.show', $type) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.types.edit', $type) }}">
                                    <i class="fa-solid fa-file-pen"></i>
                                </a>

                                <!-- Button trigger modal -->
                                <span class="delete-btn" data-bs-toggle="modal" data-bs-target="#modal-{{ $type->id }}">
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
        @foreach ($types as $type)
            <div class="modal fade" id="modal-{{ $type->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"> Cancellare
                                {{ $type->label }}</h1>
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
        @endforeach
    </section>
@endsection
