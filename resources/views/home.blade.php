@extends('layouts.main_layout')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col">

                @include('header')

                <!-- Sem notas disponíveis -->
                @if (count($notes) == 0)
                <div class="row mt-5">
                    <div class="col text-center">
                        <p class="display-6 mb-5 text-secondary opacity-50">Você não tem notas disponíveis!</p>
                        <a href="{{ route('new') }}" class="btn btn-secondary btn-lg p-3 px-5">
                            <i class="fa-regular fa-pen-to-square me-3"></i>Crie Sua Primeira Nota
                        </a>
                    </div>
                </div>

                @else

                <!-- Notas disponíveis -->
                <div class="d-flex justify-content-end my-4">
                    <a href="{{ route('new') }}" class="btn btn-secondary px-3">
                        <i class="fa-regular fa-pen-to-square me-2"></i>Nova Nota
                    </a>
                </div>

                @foreach ($notes as $note)
                    @include('note')
                @endforeach

                @endif

            </div>
        </div>
        @include('footer')
    </div>


@endsection
