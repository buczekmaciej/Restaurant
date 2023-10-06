@extends('views.worker.base')

@section('title', 'Employees')

@section('content')
    <div class="flex flex-col gap-8 h-full overflow-auto">
        <div class="flex justify-between items-center">
            <p class="font-semibold text-4xl">Employees</p>
            <a class="px-4 py-3 rounded-lg bg-slate-500 hover:bg-slate-600 duration-150" href="{{ route('staff.employees.create') }}">Add employee</a>
        </div>
        <div class="flex flex-col">
            <div class="grid grid-cols-[1fr_2fr_2fr_1fr_3fr_1fr_1fr] gap-3 sticky -top-6 bg-slate-800 p-6">
                <p class="font-semibold">Code</p>
                <p class="font-semibold">Name</p>
                <p class="font-semibold">E-mail</p>
                <p class="font-semibold">Phone</p>
                <p class="font-semibold">Address</p>
                <p class="font-semibold text-center">Position</p>
                <p class="font-semibold text-center">Actions</p>
            </div>
            @foreach ($employees as $employee)
                <div class="grid grid-cols-[1fr_2fr_2fr_1fr_3fr_1fr_1fr] gap-3 py-4 border-y border-y-[#dadada33] px-6 group">
                    <p class="truncate" title="{{ $employee->code }}">{{ $employee->code }}</p>
                    <p class="truncate" title="{{ $employee->name }}">{{ $employee->name }}</p>
                    <p class="truncate" title="{{ $employee->email }}">{{ $employee->email }}</p>
                    <p class="truncate" title="{{ $employee->phone }}">{{ $employee->phone }}</p>
                    <p class="truncate" title="{{ $employee->address->street }}, {{ $employee->address->city }}">{{ $employee->address->street }}, {{ $employee->address->city }}</p>
                    <p class="text-center">{{ $employee->position }}</p>
                    <div class="hidden group-hover:flex gap-4 justify-center">
                        <a class="font-semibold" href="{{ route('staff.employees.manage', ['user' => $employee->code]) }}">Manage</a>
                    </div>
                </div>
            @endforeach
            {{ $employees->links() }}
        </div>
    </div>
@endsection
