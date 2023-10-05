@extends('views.worker.base')

@section('title', 'Create new meal')

@section('content')
    <div class="flex flex-col gap-8 h-full">
        <a class="border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.meals.view') }}">Return back to meals</a>
        <p class="font-light text-4xl">Assemble new meal</p>
        <form class="flex flex-col gap-7 border-t-[1px] border-solid border-t-[#ffffff54] pt-8" method="post">
            <div class="grid grid-cols-[2fr_1fr] gap-4">
                <div class="flex flex-col gap-3">
                    <label for="i-name">Meal name</label>
                    <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-name" name="name" type="text" />
                </div>
                <div class="flex flex-col gap-3">
                    <label for="i-price">Meal price</label>
                    <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-price" name="price" type="text" />
                </div>
            </div>
            <div class="flex flex-wrap gap-3">
                <p>Ingredients</p>
                <div class="grid grid-cols-12 gap-y-2 gap-x-4">
                    @foreach ($ingredients as $ingredient)
                        <label class="flex gap-3 cursor-pointer"><input name="ingredients[]" type="checkbox" value="{{ $ingredient }}" /> {{ $ingredient }}</label>
                    @endforeach
                </div>
            </div>
            <button class="bg-slate-900 px-7 py-3 rounded-lg self-start hover:bg-slate-800 duration-150">Save new meal</button>
            @csrf
        </form>
    </div>
@endsection
