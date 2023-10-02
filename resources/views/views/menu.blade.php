@extends('base')

@section('title', 'Menu')

@section('class', 'flex flex-col items-center')

@section('body')
    <div class="max-w-5xl flex flex-col gap-8 py-8">
        <div class="sticky top-0 left-0 flex justify-between items-center py-5 bg-white">
            <a class="hover:underline" href="{{ route('homepage') }}">Return to homepage</a>
            <p class="cursor-pointer hidden" id="top-scroll">To top</p>
        </div>
        <div class="w-full flex flex-col gap-3">
            @foreach ($menu as $meal)
                <div class="w-full flex flex-col gap-4 border-solid border-[1px] border-[#3d3d3d23] p-4 rounded-lg">
                    <div class="flex items-center justify-between">
                        <p class="font-semibold text-3xl">{{ $meal->name }}</p>
                        <p class="font-semibold text-lg">${{ $meal->price }}</p>
                    </div>
                    <p class="text-sm">{{ $meal->description }}</p>
                    <p class="mt-3 text-sm">
                        {{ $meal->ingredients()->orderBy('name')->pluck('name')->implode(', ') }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    <script src="{{ asset('/js/menu.js') }}"></script>
@endsection
