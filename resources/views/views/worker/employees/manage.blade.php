@extends('views.worker.base')

@section('title')
    Employee manage: "{{ $employee->code }}"
@endsection

@section('content')
    <div class="flex flex-col gap-8">
        <a class="text-lg border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.employees.view') }}">Return back to employees</a>
        <p class="font-light text-3xl">Manage employee with code: <i class="font-semibold">{{ $employee->code }}</i></p>
        <div class="flex flex-col gap-8 border-y-[1px] border-solid border-y-[#ffffff54] py-8">
            <p class="text-4xl font-semibold">Change employee data</p>
            <form action="{{ route('staff.employees.update', ['user' => $employee->code]) }}" class="flex flex-col gap-4" method="post">
                <div class="grid grid-cols-6 gap-3">
                    <div class="flex flex-col gap-3 col-span-3">
                        <label for="i-name">Name</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-name" name="name" type="text" value="{{ $employee->name }}" />
                    </div>
                    <div class="flex flex-col gap-3">
                        <label for="i-position">Position</label>
                        <select class="cursor-pointer bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-position" name="position">
                            @foreach ($positions as $position)
                                <option {{ mb_strtolower($employee->position) === $position ? 'selected' : '' }} class="bg-slate-800" value="{{ $position }}">{{ ucfirst($position) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-3 col-span-2">
                        <label for="i-workplace">Workplace</label>
                        <select class="cursor-pointer bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-workplace" name="workplace">
                            @foreach ($locations as $location)
                                <option {{ $employee->workplace->id === $location->id ? 'selected' : '' }} class="bg-slate-800" value="{{ $location->id }}">{{ $location->address->street }}, {{ $location->address->city }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-3 col-span-4">
                        <label for="i-email">E-mail</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-email" name="email" type="email" value="{{ $employee->email }}" />
                    </div>
                    <div class="flex flex-col gap-3 col-span-2">
                        <label for="i-phone">Phone</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-phone" name="phone" type="tel" value="{{ $employee->phone }}" />
                    </div>
                    <div class="flex flex-col gap-3 col-span-3">
                        <label for="i-address-street">Street</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-street" name="address[street]" type="text" value="{{ $employee->address->street }}" />
                    </div>
                    <div class="flex flex-col gap-3 col-span-3">
                        <label for="i-address-city">City</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-address-city" name="address[city]" type="text" value="{{ $employee->address->city }}" />
                    </div>
                </div>
                <button class="bg-slate-900 px-8 py-4 rounded-lg self-start hover:bg-slate-800 duration-150">Update employee</button>
                @csrf
            </form>
        </div>
        <div class="flex flex-col gap-3">
            <p class="text-4xl font-semibold">Delete employee</p>
            <p>This action has no undo possibility. Make sure you know know what you are doing and are aware of consequences</p>
            <form action="{{ route('staff.employees.delete', ['user' => $employee->code]) }}" method="post">
                @method('DELETE')
                @csrf
                <button class="bg-red-700 px-8 py-4 rounded-lg hover:bg-red-600 duration-150">Delete employee</button>
            </form>
        </div>
    </div>
@endsection
