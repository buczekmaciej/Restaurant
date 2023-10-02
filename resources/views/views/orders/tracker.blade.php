@extends('base')

@section('title')
    @if ($order)
        Checking order with code: {{ $order->code }}
    @else
        Check your order
    @endif
@endsection

@section('class', 'flex flex-col items-center py-8 gap-4')

@section('body')
    <div class="sticky top-0 left-0 max-w-5xl w-full flex justify-between items-center py-5 bg-white">
        <a class="hover:underline" href="{{ route('homepage') }}">Return to homepage</a>
    </div>
    <form action="{{ route('order.track') }}" class="max-w-5xl w-full flex flex-col gap-3 border-[1px] border-solid border-[#3d3d3d23] rounded-lg p-8" id="tracker-form" method="POST">
        <p class="text-5xl font-semibold">Find your order</p>
        <p class="font-light">To receive details about your order you need to provide code given at end of ordering</p>
        <div class="flex flex-col gap-1">
            <div class="flex gap-2 items-end mt-5">
                <div class="flex flex-col gap-1 flex-[2]">
                    <label for="tracker-input">Order code</label>
                    <input class="border-solid border-[1px] border-[#3d3d3d23] px-3 py-2 outline-[#3d3d3d7d] rounded-md" id="tracker-input" type="text" value="{{ $order ? $order->code : (session()->has('code') ? session()->get('code') : '') }}" />
                </div>
                <button class="px-4 py-[calc(0.5rem+1px)] rounded-md bg-rose-600 text-white">Find order</button>
            </div>
            @if (session()->has('code'))
                <p class="text-sm font-semibold text-[#929292]">Your order number has been automatically added into input. Save it to track this order in future</p>
            @endif
        </div>

        @csrf
    </form>

    @if ($order)
        <div class="max-w-5xl w-full flex flex-col gap-8 border-[1px] border-solid border-[#3d3d3d23] rounded-lg p-8">
            <div class="flex items-center justify-between">
                <p class="text-5xl font-semibold">Your order</p>
                <p class="{{ $order->status }}">{{ ucfirst($order->status) }}</p>
            </div>
            <div class="flex flex-col gap-2">
                <p>
                    <span class="font-medium">Order code:</span>
                    <span class="font-light">{{ $order->code }}</span>
                </p>
                <p>
                    <span class="font-medium">Order date:</span>
                    <span class="font-light">{{ $order->created_at->format('F d, Y H:i (e)') }}</span>
                </p>
                <p>
                    <span class="font-medium">Total:</span>
                    <span class="font-light">${{ $order->total }}</span>
                </p>
                <p>
                    <span class="font-medium">Delivery address:</span>
                    <span class="font-light">{{ $order->address->street }}, {{ $order->address->city }}</span>
                </p>
                <p>
                    <span class="font-medium">Served by:</span>
                    <span class="font-light">{{ $order->servingPlace->address->street }}, {{ $order->servingPlace->address->city }}</span>
                </p>
            </div>
            <div class="flex flex-col gap-4">
                <p class="font-semibold text-2xl">Ordered items</p>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($order->meals()->select('name', 'price', 'meal_order.quantity AS quantity')->orderBy('name')->get() as $meal)
                        <div class="w-full flex flex-col gap-4 border-solid border-[1px] border-[#3d3d3d23] p-3 rounded-md">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-xl">{{ ucfirst($meal->name) }}</p>
                                <p class="">
                                    <span>${{ $meal->price }} x {{ $meal->quantity }} =</span>
                                    <span class="font-semibold">${{ $meal->price * $meal->quantity }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <script src="{{ asset('/js/tracker.js') }}"></script>
@endsection
