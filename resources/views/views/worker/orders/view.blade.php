@extends('views.worker.base')

@section('title', 'Orders')

@section('content')
    <div class="flex flex-col gap-8 h-full overflow-auto">
        <p class="font-semibold text-4xl">Orders</p>
        <div class="flex flex-col">
            <div class="grid grid-cols-[2fr_1fr_2fr_2fr_1fr_1fr] gap-5 sticky -top-6 z-30 bg-slate-800 p-6">
                <p class="font-semibold">Code</p>
                <p class="font-semibold text-center">Status</p>
                <p class="font-semibold">Delivered to</p>
                <p class="font-semibold">Serviced by</p>
                <p class="font-semibold text-center">Total</p>
                <p class="font-semibold text-center">Ordered</p>
            </div>
            @php
                $half = sizeof($orders) / 2;
            @endphp
            @foreach ($orders as $i => $order)
                <div class="grid grid-cols-[2fr_1fr_2fr_2fr_1fr_1fr] items-center gap-5 py-4 border-y border-y-[#dadada33] px-6">
                    <p class="font-semibold truncate" title="{{ $order->code }}">{{ $order->code }}</p>
                    <p class="font-semibold text-center {{ $order->status }} !bg-opacity-10">{{ ucfirst($order->status) }}</p>
                    <p class="font-semibold truncate" title="{{ $order->address->street }}, {{ $order->address->city }}">{{ $order->address->street }}, {{ $order->address->city }}</p>
                    <p class="font-semibold truncate" title="{{ $order->servingPlace->address->street }}, {{ $order->servingPlace->address->city }}">{{ $order->servingPlace->address->street }}, {{ $order->servingPlace->address->city }}</p>
                    <div class="relative group">
                        <p class="font-semibold text-center underline decoration-dotted underline-offset-4 cursor-help">${{ $order->total }}</p>
                        <div class="absolute {{ $i > $half ? 'bottom-full' : 'top-2/3' }} left-1/2 -translate-x-1/2 bg-slate-800 z-20 hidden group-hover:flex flex-col gap-5 p-5 rounded-lg shadow-lg">
                            @foreach ($order->meals()->pluck('name', 'meal_order.quantity AS quantity') as $quantity => $meal)
                                <p class="whitespace-nowrap">{{ $quantity }}x {{ $meal }}</p>
                            @endforeach
                        </div>
                    </div>
                    <p class="font-semibold text-center">{{ $order->created_at->format('d/m/Y') }}</p>
                </div>
            @endforeach
            {{ $orders->links() }}
        </div>
    </div>
@endsection
