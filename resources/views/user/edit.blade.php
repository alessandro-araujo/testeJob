@php
    $title = "Edit Account";
@endphp

@extends('layouts.default')
@section('content')
<div>
    <form class="w-full max-w-4xl mx-auto bg-white p-10 rounded-3xl shadow-2xl space-y-8" method="POST" action="{{ route('users.update', ['user' => $user->id]) }}">
        @csrf
        @method('PUT')
        <h2 class="text-2xl font-bold text-center text-gray-800">Edit Account</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Name</label>
                <input type="text" value="{{ $user->name }}"  placeholder="John Doe" name="name"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" value="{{ $user->email }}" placeholder="john@example.com" name="email"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                <input type="password" placeholder="••••••••" name="password"
                    class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>
            @canany(['check-student', 'check-teacher'])
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">RM</label>
                        <input type="text" value="{{ $user->rm }}" placeholder="123456" name="rm"
                        class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>
            @endcanany
            @can('check-teacher')
                <div class="md:col-span-2">
                    <div id="extraField" class="mt-2">
                        <label for="directorship">Directorship:</label>
                        <input type="text" value="{{ $user->directorship }}"  name="directorship" id="directorship" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>
            @endcan
        </div>
        <button type="submit"
            class="cursor-pointer w-full p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-2xl shadow-lg hover:opacity-90 transition">
            Update
        </button>
        <x-alert />
    </form>
</div>
@endsection
