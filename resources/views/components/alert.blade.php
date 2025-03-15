@if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded-md shadow-md max-w-[35.2rem] mx-auto mt-4" role="alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="bg-red-500 text-white p-4 rounded-md shadow-md max-w-[35.2rem] mx-auto mt-4" role="alert">
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded-md shadow-md max-w-[35.2rem] mx-auto mt-4" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif
