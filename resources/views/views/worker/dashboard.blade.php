@extends('base')

@section('title', 'Dashboard')

@section('class', 'flex h-screen bg-slate-700 text-white')

@section('body')
    <div class="w-1/6 h-screen bg-slate-800">
        <p class="">Dashboard</p>
        <div class="">
            <a class="" href="">Home</a>
            <a class="" href="">Orders</a>
            <a class="" href=""></a>
            <a class="" href=""></a>
            @if (auth()->user()->position === 'owner')
                <a class="" href=""></a>
                <a class="" href=""></a>
            @endif
        </div>
        <div class="">
            <p class="">
                <span class="">Logged as,</span>
                <span class="">{{ auth()->user()->name }}</span>
            </p>
            <a href="{{ route('staff.auth.logout') }}">Logout</a>
        </div>
    </div>
    <div class="w-5/6 h-screen">@yield('content')</div>
@endsection
