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
                        <p class="font-semibold text-3xl">{{ ucfirst($meal->name) }}</p>
                        <p class="font-semibold text-lg">${{ $meal->price }}</p>
                    </div>
                    <p class="text-sm">{{ ucfirst($meal->description) }}</p>
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                        @foreach ($meal->ingredients as $ingredient)
                            <p class="px-5 py-2 bg-zinc-100 rounded-md">{{ ucfirst($ingredient->name) }}</p>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="/js/menu.js"></script>
@endsection
