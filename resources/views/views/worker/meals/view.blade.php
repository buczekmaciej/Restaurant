@extends('views.worker.base')

@section('title', 'Meals')

@section('content')
    <div class="flex flex-col gap-8 h-full overflow-auto">
        <p class="font-semibold text-4xl">Meals</p>
        <div class="flex flex-col">
            <div class="grid {{ auth()->user()->position === 'owner' ? 'grid-cols-[2fr_1fr_1fr_1fr_1fr]' : 'grid-cols-[2fr_1fr_1fr_1fr]' }} gap-5 sticky -top-6 z-30 bg-slate-800 p-6">
                <p class="font-semibold">Name</p>
                <p class="font-semibold text-center">Price</p>
                <p class="font-semibold text-center">Ingredients used</p>
                <p class="font-semibold text-center">Order count</p>
                @if (auth()->user()->position === 'owner')
                    <p class="font-semibold text-center">Actions</p>
                @endif
            </div>
            @foreach ($meals as $meal)
                <div class="grid {{ auth()->user()->position === 'owner' ? 'grid-cols-[2fr_1fr_1fr_1fr_1fr] group' : 'grid-cols-[2fr_1fr_1fr_1fr]' }} items-center gap-5 py-4 border-y border-y-[#dadada33] px-6">
                    <p class="font-semibold truncate" title="{{ $meal->name }}">{{ $meal->name }}</p>
                    <p class="font-semibold text-center">${{ $meal->price }}</p>
                    <p class="font-semibold text-center">{{ $meal->ingredients()->count() }}</p>
                    <p class="font-semibold text-center">{{ $meal->orders()->count() }}</p>
                    @if (auth()->user()->position === 'owner')
                        <div class="hidden group-hover:flex gap-4 justify-center">
                            <a class="font-semibold" href="{{ route('staff.meals.manage', ['meal' => strtolower($meal->name)]) }}">Manage</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
