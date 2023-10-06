@extends('views.worker.base')

@section('title', 'Add employee')

@section('content')
    <div class="flex flex-col gap-8">
        <a class="text-lg border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.employees.view') }}">Return back to employees</a>
        <p class="font-light text-3xl">Add new employee</p>
        <div class="flex flex-col gap-8 border-t-[1px] border-solid border-t-[#ffffff54] pt-8">
            <form action="{{ route('staff.employees.create') }}" class="flex flex-col gap-4" method="post">
                <div class="grid grid-cols-6 gap-3">
                    <div class="flex flex-col gap-3 col-span-3">
                        <label for="i-name">Name</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-name" name="name" type="text" />
                    </div>
                    <div class="flex flex-col gap-3">
                        <label for="i-position">Position</label>
                        <select class="cursor-pointer bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-position" name="position">
                            @foreach ($positions as $position)
                                <option class="bg-slate-800" value="{{ $position }}">{{ ucfirst($position) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-3 col-span-2">
                        <label for="i-workplace">Workplace</label>
                        <select class="cursor-pointer bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-workplace" name="workplace">
                            @foreach ($locations as $location)
                                <option class="bg-slate-800" value="{{ $location->id }}">{{ $location->address->street }}, {{ $location->address->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-3 col-span-2">
                        <label for="i-password">Password</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-password" name="password" type="password" />
                    </div>
                    <div class="flex flex-col gap-3 col-span-2">
                        <label for="i-email">E-mail</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-email" name="email" type="email" />
                    </div>
                    <div class="flex flex-col gap-3 col-span-2">
                        <label for="i-phone">Phone</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-phone" name="phone" type="tel" />
                    </div>
                    <div class="flex flex-col gap-3 col-span-3">
                        <label for="i-address-street">Street</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-street" name="address[street]" type="text" />
                    </div>
                    <div class="flex flex-col gap-3 col-span-3">
                        <label for="i-address-city">City</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-city" name="address[city]" type="text" />
                    </div>
                </div>
                <button class="bg-slate-900 px-8 py-4 rounded-lg self-start hover:bg-slate-800 duration-150">Save employee</button>
                @csrf
            </form>
        </div>
    </div>
@endsection
