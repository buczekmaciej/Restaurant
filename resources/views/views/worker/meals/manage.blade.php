@extends('views.worker.base')

@section('title')
    Meal manage: "{{ $meal->name }}"
@endsection

@section('content')
    <div class="flex flex-col gap-8 h-full">
        <a class="border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.meals.view') }}">Return back to meals</a>
        <p class="font-light text-2xl">Manage meal with name: <i class="font-semibold">{{ $meal->name }}</i></p>
        <div class="flex flex-col gap-8 border-y-[1px] border-solid border-y-[#ffffff54] py-8">
            <p class="text-2xl font-semibold">Change meal name</p>
            <form action="{{ route('staff.meals.update', ['meal' => $meal->name]) }}" class="flex flex-col gap-4" method="post">
                <div class="grid grid-cols-[2fr_1fr] gap-4">
                    <div class="flex flex-col gap-3">
                        <label for="i-name">Meal name</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-name" name="name" type="text" value="{{ strtolower($meal->name) }}" />
                    </div>
                    <div class="flex flex-col gap-3">
                        <label for="i-price">Meal price</label>
                        <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-price" name="price" type="text" value="{{ strtolower($meal->price) }}" />
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <p>Ingredients</p>
                    <div class="grid grid-cols-12 gap-y-2 gap-x-4">
                        @foreach ($ingredients as $ingredient)
                            <label class="flex gap-3 cursor-pointer"><input {{ $meal->ingredients->contains('name', $ingredient) ? 'checked' : '' }} name="ingredients[]" type="checkbox" value="{{ $ingredient }}" /> {{ $ingredient }}</label>
                        @endforeach
                    </div>
                </div>
                <button class="bg-slate-900 px-7 py-3 rounded-lg self-start hover:bg-slate-800 duration-150">Update name</button>
                @csrf
            </form>
        </div>
        <div class="flex flex-col gap-3">
            <p class="text-2xl font-semibold">Delete meal</p>
            <p class="">This action has no undo possibility. Make sure you know know what you are doing and are aware of consequences</p>
            <form action="{{ route('staff.meals.delete', ['meal' => $meal->name]) }}" method="post">
                @method('DELETE')
                @csrf
                <button class="bg-red-700 px-7 py-3 rounded-lg hover:bg-red-600 duration-150">Delete meal</button>
            </form>
        </div>
    </div>
@endsection
