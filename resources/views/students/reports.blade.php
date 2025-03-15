@php
    $title = "Students";
@endphp

@extends('layouts.default')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-9/10 ">
        @forelse ($associated as $row)
            @foreach ($teachers as $teacher)
                @if ($row->rm_teacher == $teacher->rm)
                    <p><strong>O aluno está associado ao professor:</strong> {{ $teacher->name }}</p>
                @php
                    $found = false;
                @endphp
                @foreach ($spreadsheet as $spreadsheetRow)
                    @if($spreadsheetRow->rm_teacher != $teacher->rm)
                        <p><strong>Você não tem notas com esse professor</strong></p>
                        @php
                            $found = true;
                        @endphp
                    @endif
                @endforeach
                    @if (!$found)
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="border-b px-4 py-2 text-left">Nota 1</th>
                                <th class="border-b px-4 py-2 text-left">Nota 2</th>
                                <th class="border-b px-4 py-2 text-left">Nota 3</th>
                                <th class="border-b px-4 py-2 text-left">Nota 4</th>
                                <th class="border-b px-4 py-2 text-left">Nota 5</th>
                                <th class="border-b px-4 py-2 text-left">Nota 6</th>
                                <th class="border-b px-4 py-2 text-left">Nota Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($spreadsheet as $data)
                                <tr>
                                    <td class="border-b px-4 py-2">{{ $data['note1'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['note2'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['note3'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['note4'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['note5'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['note6'] }}</td>
                                    <td class="border-b px-4 py-2">{{ $data['finalnote'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                @endif
            @endforeach
        @empty
            <p>Você precisa se associar a algum professor <a class="text-blue-500" href="{{ route('student.view') }}">Associar</a></p>
            @foreach ($spreadsheet as $row)
                @php
                    $found = false;
                @endphp
                @foreach ($teachers as $teacher)
                    @if ($row->rm_teacher == $teacher->rm)
                        <p><strong>Verificamos que você tem notas com o professor: </strong>{{ $teacher->name }} </p>
                        @php
                            $found = true;
                        @endphp
                    @endif
                @endforeach
                @if (!$found)
                    <p><strong>Verificamos que você tem notas com o professor de número de matrícula: </strong>{{ $row->rm_teacher }} </p>
                @endif
            @endforeach
        @endforelse
        <x-alert />
    </div>
</div>

@endsection
