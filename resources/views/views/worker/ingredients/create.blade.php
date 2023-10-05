@extends('views.worker.base')

@section('title', 'Create new ingredient')

@section('content')
    <div class="flex flex-col gap-8 h-full">
        <a class="border-b-[1px] border-solid border-b-white w-fit p-2 duration-150 hover:pl-5" href="{{ route('staff.ingredients.view') }}">Return back to ingredients</a>
        <p class="font-light text-4xl">Assemble new ingredient</p>
        <form class="flex flex-col gap-7 border-t-[1px] border-solid border-t-[#ffffff54] pt-8" method="post">
            <div class="flex flex-col gap-3">
                <label for="i-name">Ingredient name</label>
                <input class="bg-transparent border-2 border-solid border-gray-500 outline-transparent p-3 rounded-lg" id="i-name" name="name" type="text" />
            </div>
            <button class="bg-slate-900 px-7 py-3 rounded-lg self-start hover:bg-slate-800 duration-150">Save new ingredient</button>
            @csrf
        </form>
    </div>
@endsection
