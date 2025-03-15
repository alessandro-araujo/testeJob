@php
    $title = "Students";
@endphp

@extends('layouts.default')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        @forelse ($associated as $row)
            @foreach ($teachers as $teacher)
                @if ($row->rm_teacher == $teacher->rm)
                    <p><strong>O aluno está associado ao professor:</strong> {{ $teacher->name }}
                        <form action="{{ route('student.destroy', ['rm_student' => $row->rm_student, 'rm_teacher' => $teacher->rm]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cursor-pointer text-red-500 hover:text-red-700">Remover Professor</button>
                        </form>
                    </p>
                @endif
            @endforeach


        @empty
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Vincular Perfis</h1>
            <form action="{{ route('student.store') }}" method="POST" class="space-y-4">
                @csrf
                @method('POST')
                <input type="hidden" value="{{ $user->rm }}" name="rm_student">
                <label for="professor" class="block text-gray-700 font-semibold">Selecione um Professor:</label>
                <select name="rm_teacher" id="professor" required class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="">-- Selecione --</option>
                    @forelse ($teachers as $teacher)
                        <option value="{{ $teacher->rm }}">{{ $teacher->name }} - RM: {{ $teacher->rm }}</option>
                    @empty
                        <option disabled>Sem professores cadastrados</option>
                    @endforelse
                </select>
                <button type="submit" class="cursor-pointer w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Vincular</button>
            </form>
        @endforelse
        <x-alert />
    </div>
</div>

@endsection
