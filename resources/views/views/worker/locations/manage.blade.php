@extends('views.worker.base')

@section('title')
    Location manage: "#{{ $location->id }}"
@endsection

@section('content')
    <div class="flex flex-col gap-8">
        <a class="text-lg border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.locations.view') }}">Return back to locations</a>
        <p class="font-light text-6xl">Manage location with id: <i class="font-semibold">{{ $location->id }}</i></p>
        <div class="flex flex-col gap-8 max-w-5xl border-y-[1px] border-solid border-y-[#ffffff54] py-8">
            <p class="text-4xl font-semibold">Change location address</p>
            <form action="{{ route('staff.locations.update', ['location' => $location->id]) }}" class="flex flex-col gap-4" method="post">
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-3">
                        <label for="i-address-street">Street</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-street" name="address[street]" type="text" value="{{ $location->address->street }}" />
                    </div>
                    <div class="flex flex-col gap-3">
                        <label for="i-address-city">City</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-city" name="address[city]" type="text" value="{{ $location->address->city }}" />
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <p>Employees</p>
                    <div class="grid grid-cols-4 gap-4 max-h-64 overflow-auto">
                        @foreach ($employees as $name => $id)
                            <label class="flex gap-3 cursor-pointer"><input {{ $location->employees->contains('name', $name) ? 'checked' : '' }} name="employees[]" type="checkbox" value="{{ $id }}" /> {{ $name }}</label>
                        @endforeach
                    </div>
                </div>
                <button class="bg-slate-900 px-8 py-4 rounded-lg self-start hover:bg-slate-800 duration-150">Update location</button>
                @csrf
            </form>
        </div>
        <div class="flex flex-col gap-3 max-w-5xl">
            <p class="text-4xl font-semibold">Delete location</p>
            <p>This action has no undo possibility. Make sure you know know what you are doing and are aware of consequences</p>
            <form action="{{ route('staff.locations.delete', ['location' => $location->id]) }}" method="post">
                @method('DELETE')
                @csrf
                <button class="bg-red-700 px-8 py-4 rounded-lg hover:bg-red-600 duration-150">Delete location</button>
            </form>
        </div>
    </div>
@endsection
