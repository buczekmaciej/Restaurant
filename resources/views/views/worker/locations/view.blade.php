@extends('views.worker.base')

@section('title', 'Locations')

@section('content')
    <div class="flex flex-col gap-8 h-full overflow-auto">
        <div class="flex justify-between items-center">
            <p class="font-semibold text-4xl">Locations</p>
            <a class="px-4 py-3 rounded-lg bg-slate-500 hover:bg-slate-600 duration-150" href="{{ route('staff.locations.create') }}">Add location</a>
        </div>
        <div class="flex flex-col">
            <div class="grid {{ auth()->user()->position === 'owner' ? 'grid-cols-[3fr_1fr_1fr_1fr]' : 'grid-cols-[3fr_1fr_1fr]' }} gap-3 sticky -top-6 bg-slate-800 p-6">
                <p class="font-semibold">Address</p>
                <p class="font-semibold text-center">Employees</p>
                <p class="font-semibold text-center">Orders</p>
                @if (auth()->user()->position === 'owner')
                    <p class="font-semibold text-center">Actions</p>
                @endif
            </div>
            @foreach ($locations as $location)
                <div class="grid {{ auth()->user()->position === 'owner' ? 'grid-cols-[3fr_1fr_1fr_1fr]' : 'grid-cols-[3fr_1fr_1fr]' }} gap-3 py-4 border-y border-y-[#dadada33] px-6 {{ auth()->user()->position === 'owner' ? ' group' : '' }}">
                    <p class="truncate">{{ $location->address->street }}, {{ $location->address->city }}</p>
                    <p class="text-center">{{ $location->employees()->count() }}</p>
                    <p class="text-center">{{ $location->orders()->count() }}</p>
                    @if (auth()->user()->position === 'owner')
                        <div class="hidden group-hover:flex gap-4 justify-center">
                            <a class="font-semibold" href="{{ route('staff.locations.manage', ['location' => $location->id]) }}">Manage</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
