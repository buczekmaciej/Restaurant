@extends('views.worker.base')

@section('title', 'Create new location')

@section('content')
    <div class="flex flex-col gap-8 h-full">
        <a class="border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.locations.view') }}">Return back to locations</a>
        <p class="font-light text-4xl">Set new location</p>
        <form class="flex flex-col gap-7 border-t-[1px] border-solid border-t-[#ffffff54] pt-8" method="post">
            <div class="grid grid-cols-2 gap-3">
                <div class="flex flex-col gap-3">
                    <label for="i-address-street">Street</label>
                    <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-street" name="address[street]" type="text" />
                </div>
                <div class="flex flex-col gap-3">
                    <label for="i-address-city">City</label>
                    <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-city" name="address[city]" type="text" />
                </div>
            </div>
            <button class="bg-slate-900 px-7 py-3 rounded-lg self-start hover:bg-slate-800 duration-150">Save new location</button>
            @csrf
        </form>
    </div>
@endsection
