@extends('base')

@section('title', 'Dashboard')

@section('class', 'flex h-screen bg-slate-700 text-white')

@section('body')
    <div class="w-1/6 h-screen bg-slate-800 px-4 py-6 flex flex-col gap-10">
        <p class="text-4xl">Dashboard</p>
        <div class="flex flex-col gap-4">
            <a class="{{ Route::is('staff.dashboard') ? 'active-link' : 'inactive-link' }} rounded-md p-4 duration-150" href="{{ route('staff.dashboard') }}">Home</a>
            <a class="{{ Route::is('staff.orders.*') ? 'active-link' : 'inactive-link' }} rounded-md p-4 duration-150" href="{{ route('staff.orders.view') }}">Orders</a>
            <a class="{{ Route::is('staff.meals.*') ? 'active-link' : 'inactive-link' }} rounded-md p-4 duration-150" href="{{ route('staff.meals.view') }}">Meals</a>
            <a class="{{ Route::is('staff.ingredients.*') ? 'active-link' : 'inactive-link' }} rounded-md p-4 duration-150" href="{{ route('staff.ingredients.view') }}">Ingredients</a>
            <a class="{{ Route::is('staff.locations.*') ? 'active-link' : 'inactive-link' }} rounded-md p-4 duration-150" href="{{ route('staff.locations.view') }}">Locations</a>
            <a class="{{ Route::is('') ? 'active-link' : 'inactive-link' }} rounded-md p-4 duration-150" href="">Employees</a>
        </div>
        @if (Route::is('staff.dashboard'))
            <a class="mt-auto w-full bg-slate-900 text-white rounded-lg p-4 text-center hover:bg-slate-700 duration-150" href="{{ route('staff.auth.logout') }}">Logout</a>
        @else
            <div class="mt-auto flex flex-col gap-3">
                <p class="flex flex-col gap-1">
                    <span class="font-light text-sm">Logged as,</span>
                    <span class="text-lg font-semibold">{{ auth()->user()->name }}</span>
                </p>
                <a class="w-full bg-slate-900 text-white rounded-lg p-4 text-center hover:bg-slate-700 duration-150" href="{{ route('staff.auth.logout') }}">Logout</a>
            </div>
        @endif
    </div>
    <div class="w-5/6 h-screen overflow-auto [&>div]:p-6 flex flex-col gap-6">@yield('content')</div>
@endsection
