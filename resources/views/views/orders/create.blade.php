@extends('base')

@section('title', 'Make an order')

@section('class', 'flex flex-col items-center py-8')

@section('body')
    <div class="max-w-5xl w-full flex flex-col gap-4 border-[1px] border-solid border-[#3d3d3d23] rounded-lg p-6">
        <div class="flex flex-col gap-4 pb-6 border-b-[#3d3d3d23] border-dashed border-b-2">
            <div class="flex items-center justify-between">
                <p class="text-5xl font-semibold">New order</p>
                <p class="cursor-pointer bg-red-600 text-white px-5 py-2 rounded" id="cancel">Cancel order</p>
            </div>
            <p>
                <span class="font-semibold">Delivery address:</span>
                <span class="font-light">{{ $address['street'] }}, {{ $address['city'] }}</span>
            </p>
        </div>
        <div class="pt-5">
            <p class="text-5xl font-semibold">Pick meals</p>
            <form action="{{ route('order.summary') }}" class="mt-8 flex flex-col gap-6" method="POST">
                <input name="address[street]" type="hidden" value="{{ $address['street'] }}">
                <input name="address[city]" type="hidden" value="{{ $address['city'] }}">
                @foreach ($meals as $meal)
                    <div class="flex flex-col [&:not(:last-of-type)]:pb-4 [&:not(:last-of-type)]:border-b-2 [&:not(:last-of-type)]:border-dashed [&:not(:last-of-type)]:border-b-[#3d3d3d23]">
                        <div class="flex items-center justify-between">
                            <p class="text-3xl">{{ $meal->name }} · ${{ $meal->price }}</p>
                            <input name="meals[{{ $meal->name }}][price]" type="hidden" value="{{ $meal->price }}" />
                            <input class="outline-[#3d3d3d77] rounded w-14 p-1 border-[1px] border-solid border-[#3d3d3d23]" max="999" min="0" name="meals[{{ $meal->name }}][quantity]" placeholder="0" type="number" />
                        </div>
                        <p class="mt-3 text-sm">
                            {{ $meal->ingredients()->orderBy('name')->pluck('name')->implode(', ') }}
                        </p>
                    </div>
                @endforeach
                <div class="flex flex-col gap-2">
                    <p class="text-lg">Select place to serve order:</p>
                    <select class="border-[1px] border-solid border-[#3d3d3dCC] rounded-lg px-2 py-3 cursor-pointer" name="serving-place">
                        @foreach ($places as $id => $place)
                            <option value="{{ ($id * 5 + 3) * 8 }}">{{ $place->street }}, {{ $place->city }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="self-end cursor-pointer bg-orange-700 hover:bg-orange-800 text-white px-5 py-2 rounded">Finish ordering</button>
                @csrf
            </form>
        </div>
    </div>
    @include('components.order-discard')

    <script src="{{ asset('/js/orderCreate.js') }}"></script>
@endsection
