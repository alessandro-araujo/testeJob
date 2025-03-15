@php
    $title = "Spreadsheets";
@endphp

@extends('layouts.default')
@section('content')

<div>
<div class="max-w-full mx-auto bg-white p-6 rounded-2xl shadow-md">
  <h2 class="text-2xl font-bold text-gray-800 mb-4">Carregar Notas de Alunos</h2>

  <form action="{{ route('spreadsheet.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('POST')
    <label class="block text-sm font-medium text-gray-700">Importar Excel (xls, xlsx, xlsm):</label>
    <input
      type="file"
      name="file"
      accept=".xls,.xlsx,.xlsm"
      class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none"
      required
    />

    <button
      type="submit"
      class="cursor-pointer w-full p-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
      Enviar
    </button>

  </form>
  <div class="max-w-full" >
      <x-alert />
  </div>
  <br><br><br><br>
  @if ($latestFile)
        <p>Arquivo: {{ $latestFile }}</p>
        <a href="{{ route('spreadsheet.download', ['filename' => $latestFile]) }}" download>
            📥 Baixar Planilha
        </a>
    @else
        <p>Nenhuma planilha disponível.</p>
    @endif
</div>


</div>

@endsection
