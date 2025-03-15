@php
    $title = "Students Reports";
@endphp

@extends('layouts.default')
@section('content')

<div class="flex justify-center items-center min-h-screen p-6">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
        <h2 class="text-3xl font-bold mb-4">Total de alunos sem cadastro: {{ $notRegisteredCount }}</h2>
        <h2 class="text-3xl font-bold mb-6">Alunos Cadastrados sem Associação:</h2>

        @forelse ($responseArray as $data)
            <form action="{{ route('student.store') }}" method="POST" class="flex flex-wrap items-center gap-4 mb-4">
                @csrf
                @method('POST')
                <input type="hidden" value="{{ $data['rm_student'] }}" name="rm_student">

                <div class="flex-1 min-w-[200px]">
                    <label for="professor" class="text-gray-700 font-semibold block">{{ $data['name'] }}</label>
                </div>

                <div class="flex-1 min-w-[250px]">
                    <select name="rm_teacher" id="professor" required class="w-full p-2 border border-gray-300 rounded-lg">
                        <option value="">-- Selecione --</option>
                        @forelse ($teachers as $teacher)
                            <option value="{{ $teacher->rm }}">{{ $teacher->name }} - RM: {{ $teacher->rm }}</option>
                        @empty
                            <option disabled>Sem professores cadastrados</option>
                        @endforelse
                    </select>
                </div>

                <button type="submit" class="cursor-pointer bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">
                    Vincular
                </button>
            </form>
        @empty
            <p class="text-gray-600"><strong>Sem registro</strong></p>
        @endforelse

        <x-alert />
    </div>
</div>


@endsection
