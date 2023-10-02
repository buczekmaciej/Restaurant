@extends('base')

@section('title', 'Employee login')

@section('class', 'flex items-center justify-center h-screen bg-gradient-to-br from-emerald-800 to-green-400')

@section('body')
    <form action="{{ route('staff.auth.login') }}" class="bg-white p-6 w-1/3 rounded-lg shadow-xl flex flex-col gap-8" method="post">
        <p class="text-5xl">Login for worker access</p>
        <div class="flex flex-col gap-2 w-full">
            <label for="code">Employee code</label>
            <input class="outline-transparent border-2 border-solid border-gray-200 px-3 py-2" id="code" name="code" required type="text" />
        </div>
        <div class="flex flex-col gap-2 w-full">
            <label for="password">Password</label>
            <input class="outline-transparent border-2 border-solid border-gray-200 px-3 py-2" id="password" name="password" required type="password" />
        </div>
        @if (session()->has('failed'))
            <p class="border-2 border-solid border-red-600 bg-red-600 bg-opacity-10 text-red-600 font-semibold rounded-md p-3">{{ session()->get('failed') }}</p>
        @endif
        <button class="bg-amber-700 text-white py-3 cursor-pointer rounded-md">Sign in</button>
        @csrf
    </form>
@endsection
