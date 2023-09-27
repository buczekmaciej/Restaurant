@extends('base')

@section('title', 'Homepage')

@section('class', 'flex flex-col')

@section('body')
    <div class="absolute top-0 left-0 z-10 text-white w-full h-20 flex items-center justify-between px-40 border-b-[1px] border-solid border-b-[#f7f7f729]">
        <p class="text-2xl font-bold">Restaurant</p>
        <div class="flex items-center gap-6">
            <a class="hover:underline" href="{{ route('menu') }}">Menu</a>
            <a class="hover:underline" href="{{ route('order.track') }}">Track order</a>
        </div>
    </div>
    <div class="h-screen">
        <img alt="Homepage background" class="w-full h-screen object-cover absolute top-0 left-0 -z-10" src="{{ asset('/images/bg.jpg') }}" />
        <div class="w-full h-full bg-[#141414CC] flex flex-col justify-center gap-5 px-40">
            <p class="text-white text-7xl font-semibold">Craving something good?</p>
            <p class="text-white font-light w-[55%] leading-7 tracking-wide">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore velit nihil dicta fuga, inventore eveniet nam quae maxime obcaecati earum perferendis consectetur sunt omnis esse culpa libero deserunt quod saepe? Odio, fugit voluptatibus, doloremque sapiente ex ipsam nihil odit, inventore vitae in harum perferendis neque voluptate cupiditate ipsum dolore temporibus. Soluta quaerat minima iure! Ex cupiditate veniam quae
                voluptatibus
                accusantium.</p>
            <form action="" class="flex flex-wrap gap-2 mt-6" method="POST">
                <p class="text-white w-full">Order online:</p>
                <input class="home-input" placeholder="Street address" type="text" />
                <input class="home-input" list="cities-list" placeholder="City" type="text" />
                <datalist id="cities-list">
                    @foreach (array_values($locations->toArray()) as $city)
                        <option value="{{ $city }}"></option>
                    @endforeach
                </datalist>
                <button class="bg-rose-700 text-white rounded-lg px-6 cursor-pointer hover:bg-rose-800 outline-transparent">Select food</button>
            </form>
        </div>
    </div>
    <div class="px-40 py-20 flex flex-col gap-10">
        <p class="text-7xl font-semibold">Where are we?</p>
        <div class="grid grid-cols-4 gap-9">
            @foreach ($locations as $street => $city)
                <a class="hover:bg-zinc-200 p-3 rounded-lg" href="https://www.google.com/maps/search/{{ $street }},%20{{ $city }}" target="_blank">
                    <div class="flex gap-4 items-center">
                        <svg class="h-8 fill-red-600" stroke-width="0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path>
                        </svg>
                        <div>
                            <p class="text-xl font-medium">{{ $city }}</p>
                            <p class="font-light text-lg">{{ $street }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    <div class="border-t-[#3030302e] border-t-[1px] border-solid flex justify-center py-4">
        <p>All rights reserved · {{ now()->year }}</p>
    </div>
@endsection
