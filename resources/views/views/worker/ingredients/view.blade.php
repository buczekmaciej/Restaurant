@extends('views.worker.base')

@section('title', 'Ingredients')

@section('content')
    <div class="flex flex-col gap-8 h-full overflow-auto">
        <p class="font-semibold text-4xl">Ingredients</p>
        <div class="flex flex-col">
            <div class="grid grid-cols-3 gap-3 sticky -top-6 bg-slate-800 p-6">
                <p class="font-semibold{{ auth()->user()->position === 'owner' ? '' : ' col-span-2' }}">Name</p>
                <p class="font-semibold text-center">Meals using it</p>
                @if (auth()->user()->position === 'owner')
                    <p class="font-semibold text-center">Actions</p>
                @endif
            </div>
            @foreach ($ingredients as $ingredient)
                <div class="grid grid-cols-3 gap-3 py-4 border-y border-y-[#dadada33] px-6{{ auth()->user()->position === 'owner' ? ' group' : '' }}">
                    <p class="{{ auth()->user()->position === 'owner' ? '' : 'col-span-2 ' }}truncate">{{ $ingredient->name }}</p>
                    <p class="text-center">{{ $ingredient->meals()->count() }}</p>
                    @if (auth()->user()->position === 'owner')
                        <div class="hidden group-hover:flex gap-4 justify-center">
                            <a class="font-semibold" href="{{ route('staff.ingredients.manage', ['ingredient' => strtolower($ingredient->name)]) }}">Manage</a>
                        </div>
                    @endif
                </div>
            @endforeach
            {{ $ingredients->links() }}
        </div>
    </div>
@endsection
