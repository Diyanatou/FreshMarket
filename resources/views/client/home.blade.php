@extends('layouts.client')

@section('content')

<!-- HERO -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-10 flex items-center justify-between">
        <div class="flex flex-col justify-center z-10">
        <h1 class="text-4xl font-bold mb-4">
            Whooping <span class="text-yellow-300">60%</span> Off
        </h1>
        <p class="text-lg mb-6">On everyday items</p>
        <button class="bg-blue-500 hover:bg-blue-600 px-6 py-3 rounded-full">
            Shop Now
        </button>
        </div>
    <!-- RIGHT IMAGE -->
    <div class="relative z-0 flex justify-center items-center">
        <img src="{{ asset('images/food4.png') }}" class="w-full max-w-md h-auto object-contain" alt="Food Bag Image">
    </div>
</div>

@endsection
