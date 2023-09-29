@extends('base')

@section('title', 'Order summary')

@section('class', 'flex flex-col items-center py-8')

@section('body')
    <div class="max-w-5xl w-full flex flex-col gap-4 border-[1px] border-solid border-[#3d3d3d23] rounded-lg p-6">
        <div class="flex flex-col gap-4 pb-6 border-b-[#3d3d3d23] border-dashed border-b-2">
            <div class="flex items-center justify-between">
                <p class="text-5xl font-semibold">Finalize order</p>
                <p class="cursor-pointer bg-red-600 text-white px-5 py-2 rounded" id="cancel">Cancel order</p>
            </div>
            <p>
                <span class="font-semibold">Delivery address:</span>
                <span class="font-light">{{ $address['street'] }}, {{ $address['city'] }}</span>
            </p>
            <p>
                <span class="font-semibold">Total:</span>
                <span class="font-light">${{ $total }}</span>
            </p>
            <p>
                <span class="font-semibold">Serving place:</span>
                <span class="font-light">{{ $place['address'] }}</span>
            </p>
        </div>
        <div class="pt-5">
            <p class="text-5xl font-semibold">Selected meals</p>
            <form action="{{ route('order.save') }}" class="mt-8 flex flex-col gap-6" method="POST">
                <input name="address[street]" type="hidden" value="{{ $address['street'] }}">
                <input name="address[city]" type="hidden" value="{{ $address['city'] }}">
                <input name="total" type="hidden" value="{{ $total }}">
                <input name="serving-place[value]" type="hidden" value="{{ $place['value'] }}">
                <input name="serving-place[address]" type="hidden" value="{{ $place['address'] }}">
                @foreach ($meals as $meal => $data)
                    <div class="flex justify-between items-center [&:not(:last-of-type)]:pb-4 [&:not(:last-of-type)]:border-b-2 [&:not(:last-of-type)]:border-dashed [&:not(:last-of-type)]:border-b-[#3d3d3d23]">
                        <p class="text-3xl">{{ $meal }}</p>
                        <p class="text-lg">${{ $data['price'] }} x {{ $data['quantity'] }} = ${{ $data['price'] * $data['quantity'] }}</p>
                        <input name="meals[{{ $meal }}][price]" type="hidden" value="{{ $data['price'] }}" />
                        <input name="meals[{{ $meal }}][quantity]" type="hidden" value="{{ $data['quantity'] }}" />
                    </div>
                @endforeach
                <button class="self-end cursor-pointer bg-orange-700 hover:bg-orange-800 text-white px-5 py-2 rounded">Finalize your order</button>
                @csrf
            </form>
        </div>
    </div>
    @include('components.order-discard')
@endsection
