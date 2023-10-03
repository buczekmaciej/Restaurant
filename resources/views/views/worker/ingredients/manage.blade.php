@extends('views.worker.base')

@section('title')
    Ingredient manage: "{{ $ingredient->name }}"
@endsection

@section('content')
    <div class="flex flex-col gap-8 h-full">
        <a class="text-lg border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.ingredients.view') }}">Return back to ingredients</a>
        <p class="font-light text-6xl">Manage ingredient with name: <i class="font-semibold">{{ $ingredient->name }}</i></p>
        <div class="flex flex-col gap-8 max-w-5xl border-y-[1px] border-solid border-y-[#ffffff54] py-8">
            <p class="text-4xl font-semibold">Change ingredient name</p>
            <form action="{{ route('staff.ingredients.update', ['ingredient' => $ingredient->name]) }}" class="flex flex-col gap-4" method="post">
                <div class="flex flex-col gap-3">
                    <label for="i-name">Ingredient name</label>
                    <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-name" name="name" type="text" value="{{ strtolower($ingredient->name) }}" />
                </div>
                <button class="bg-slate-900 px-8 py-4 rounded-lg self-start hover:bg-slate-800 duration-150">Update name</button>
                @csrf
            </form>
        </div>
        <div class="flex flex-col gap-3 max-w-5xl">
            <p class="text-4xl font-semibold">Delete ingredient</p>
            <p class="">This action has no undo possibility. Make sure you know know what you are doing and are aware of consequences</p>
            <form action="{{ route('staff.ingredients.delete', ['ingredient' => $ingredient->name]) }}" method="post">
                @method('DELETE')
                @csrf
                <button class="bg-red-700 px-8 py-4 rounded-lg hover:bg-red-600 duration-150">Delete ingredient</button>
            </form>
        </div>
    </div>
@endsection
