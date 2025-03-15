@php
    $title = "Login TestFrellas";
@endphp


@extends('layouts.auth')
@section('content')

@if (auth()->check())
    <script>
        window.location.href = "{{ route('dashboard.view') }}";
    </script>
@endif
   <!-- Layout flex com duas colunas -->
   <!-- Parede fina -->
   <div class="w-[30rem] h-[0.4rem]  bg-[#AFB3FF] fixed z-10 rounded-full top-[23.1rem] left-[37.2rem] transform rotate-[-90.4deg] shadow-lg"></div>

    <!-- item de cima -->
   <div class="w-[30rem] h-20 bg-[#AFB3FF] fixed z-10 rounded-full top-[-6rem] left-[57.2rem] transform rotate-[-37.4deg] shadow-lg"></div>

    <!-- item background img -->
   <div class="w-[48rem] h-[30rem] bg-[#AFB3FF] fixed z-10 rounded-full top-[-5rem] left-[1.2rem] transform rotate-[-90.4deg] shadow-lg"></div>
   <div class="w-[48rem] h-[30rem] bg-[#838CF1] fixed z-5 rounded-full top-[-7rem] left-[-1rem] transform rotate-[-100.4deg] shadow-lg"></div>



   <div class="flex min-h-screen">
    <!-- Imagem à direita -->
    <div class="w-[35.3%] fixed z-20 translate-x-[25%] translate-y-[20%] ">
      <img src="{{ asset('images/pc2.png') }}" alt="Descrição" />
    </div>

    <!-- Item sombra (retângulo com sombra) -->
    <div class="w-[40rem] h-32 bg-[#B1DBDB] rounded-full fixed z-20 top-[42rem] left-[58.4rem] transform rotate-[-37.4deg] translate-x-4 translate-y-4 opacity-[50%]"></div>

    <!-- Item principal do retângulo -->
    <div class="w-[40rem] h-32 bg-[#AFB3FF] rounded-full fixed z-30 top-[42.1rem] left-[54.2rem] transform rotate-[-37.4deg] shadow-lg"></div>

    <!-- Formulário à direita -->
    <div class="flex w-full justify-end items-center p-4">
      <div class="p-8 rounded-2xl w-[98.6%] max-w-[39rem]">
        <h2 class="text-5xl font-bold text-center mb-6">Login</h2>
        <form  method="POST" action="{{ route('login.authenticate') }}" id="loginForm" class="space-y-6">
            @csrf
            @method('POST')
          <div>
            <label for="email" class="block text-sm font-medium mb-2">E-mail</label>
            <input type="email" id="email" name="email" required class="border-purple-500 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Digite seu e-mail" />
          </div>
          <div>
            <label for="password" class="block text-sm font-medium mb-2">Senha</label>
            <input type="password" id="password" name="password" required class="border-purple-500 w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Digite sua senha" />
          </div>
          <x-alert />
          <button type="submit" class="cursor-pointer w-full bg-[#838CF1] hover:bg-[#3bac6d] text-white font-bold py-2 px-4 rounded-lg transition duration-300">Entrar</button>
        </form>

        <p class="mt-6 text-sm text-center">
          Não tem uma conta? <a href="{{ route('register.view') }}" class="text-blue-500 hover:underline">Cadastre-se</a>
        </p>
      </div>
    </div>
  </div>
@endsection
