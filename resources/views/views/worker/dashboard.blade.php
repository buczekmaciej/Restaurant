@extends('views.worker.base')

@section('content')
    <div class="grid grid-cols-4 grid-rows-6 gap-3 h-full">
        <div class="col-span-2 bg-slate-800 rounded-lg p-4 flex flex-col gap-3 justify-center">
            <p class="text-3xl font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-lg font-light">{{ ucfirst(auth()->user()->position) }}</p>
        </div>
        @foreach ($data as $label => $value)
            <div class="bg-slate-800 rounded-lg p-4 flex flex-col justify-center gap-3">
                <p class="font-light">{{ $label }}</p>
                <p class="text-5xl">{{ $value }}</p>
            </div>
        @endforeach
        <div class="bg-slate-800 rounded-lg p-4 col-span-4 row-span-4 flex flex-col overflow-auto">
            <p class="font-semibold text-3xl col-span-8">Income statistics</p>
            <div class="grid grid-cols-6 gap-3 sticky -top-4 bg-slate-800 py-6">
                <p class="font-semibold col-span-3 text-xl">Address</p>
                <p class="font-semibold col-span-1 text-xl text-center">Hired employees</p>
                <p class="font-semibold col-span-1 text-xl text-center">Monthly income</p>
                <p class="font-semibold col-span-1 text-xl text-center">Monthly outcome</p>
            </div>
            @foreach ($locations as $location)
                <div class="grid grid-cols-6 gap-3 py-4 border-y border-y-[#dadada33]">
                    <p class="col-span-3 truncate">{{ $location['address'] }}</p>
                    <p class="col-span-1 text-center">{{ $location['employees'] }}</p>
                    <p class="col-span-1 text-center">{{ $location['income'] }}</p>
                    <p class="col-span-1 text-center {{ $location['outcome'] }}">{{ $location['profit'] }}$</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
