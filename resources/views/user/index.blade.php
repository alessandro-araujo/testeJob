@php
    $title = "Create Account";
@endphp

@extends('layouts.default')
@section('content')
<div>
    <form class="w-full max-w-4xl mx-auto bg-white p-10 rounded-3xl shadow-2xl space-y-8" method="POST" action="{{ route('users.store') }}">
        @csrf
        @method('POST')
        <h2 class="text-2xl font-bold text-center text-gray-800">Create Account</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Name</label>
                <input type="text" placeholder="John Doe" name="name"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" placeholder="john@example.com" name="email"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                <input type="password" placeholder="••••••••" name="password"
                    class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Role</label>
                <select name="role" id="userType"
                    class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <option value="">Selecione ...</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600 mb-1">RM</label>
                <input type="text" placeholder="123456" name="rm"
                class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" required>

                <div id="extraField" class="mt-2" style="display: none;">
                    <label for="directorship">Directorship:</label>
                    <input type="text" name="directorship" id="directorship" class="w-full p-3 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

            </div>
        </div>
        <button type="submit"
            class="cursor-pointer w-full p-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-2xl shadow-lg hover:opacity-90 transition">
            Register
        </button>
        <x-alert />
    </form>
    <script>
        document.getElementById("userType").addEventListener("change", function() {
            const extraField = document.getElementById("extraField");
            if (this.value === "teacher") {
            extraField.style.display = "block";
            } else {
            extraField.style.display = "none";
            }
        });
    </script>
</div>
@endsection
