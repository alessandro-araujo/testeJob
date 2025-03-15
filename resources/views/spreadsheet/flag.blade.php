@php
    $title = "Spreadsheets";
@endphp

@extends('layouts.default')
@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Alunos com Atualizações Pendentes</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('spreadsheet.update') }}" method="POST">
            @csrf
            @method('POST')
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border p-2">RM</th>
                            <th class="border p-2">Professor</th>
                            <th class="border p-2">Nota 1</th>
                            <th class="border p-2">Nota 2</th>
                            <th class="border p-2">Nota 3</th>
                            <th class="border p-2">Nota 4</th>
                            <th class="border p-2">Nota 5</th>
                            <th class="border p-2">Nota 6</th>
                            <th class="border p-2">Nota Final</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students_with_updates as $student)
                            <tr class="odd:bg-white even:bg-gray-100">
                                <td class="border p-2">{{ $student['original']->rm_student }}</td>
                                <td class="border p-2">{{ $student['update']->rm_teacher }}</td>
                                <td class="border p-2">{{ $student['update']->note1 }}</td>
                                <td class="border p-2">{{ $student['update']->note2 }}</td>
                                <td class="border p-2">{{ $student['update']->note3 }}</td>
                                <td class="border p-2">{{ $student['update']->note4 }}</td>
                                <td class="border p-2">{{ $student['update']->note5 }}</td>
                                <td class="border p-2">{{ $student['update']->note6 }}</td>
                                <td class="border p-2">{{ $student['update']->finalnote }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="cursor-pointer mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Atualizar Notas
            </button>
        </form>
    </div>

    @endsection
