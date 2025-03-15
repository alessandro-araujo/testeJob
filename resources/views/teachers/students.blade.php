@php
    $title = "Students Reports";
@endphp

@extends('layouts.default')
@section('content')

<div class="flex justify-center items-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-9/10 ">
            <h2 class="text-3xl font-bold">Notas de todos os seus alunos</h2>
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2 text-left">Nome/RM</th>
                        <th class="border-b px-4 py-2 text-left">Nota 1</th>
                        <th class="border-b px-4 py-2 text-left">Nota 2</th>
                        <th class="border-b px-4 py-2 text-left">Nota 3</th>
                        <th class="border-b px-4 py-2 text-left">Nota 4</th>
                        <th class="border-b px-4 py-2 text-left">Nota 5</th>
                        <th class="border-b px-4 py-2 text-left">Nota 6</th>
                        <th class="border-b px-4 py-2 text-left">Nota Final</th>
                        <th class="border-b px-4 py-2 text-left">Media</th>
                        <th class="border-b px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($responseArray as $data)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $data['name'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['note1'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['note2'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['note3'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['note4'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['note5'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['note6'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['finalnote'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['media'] }}</td>
                            <td class="border-b px-4 py-2">{{ $data['status'] }}</td>
                        </tr>
                        @empty
                        <p><strong>Verificamos que você não tem notas registradas</strong></p>
                        @endforelse
                </tbody>
            </table>
        <x-alert />
    </div>
</div>

@endsection
