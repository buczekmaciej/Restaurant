@extends('base')

@section('title', 'Active shift session')

@section('class', 'flex justify-center min-h-screen bg-slate-700 text-white')

@section('body')
    @csrf
    <input id="last-visit" type="hidden" value="{{ now()->timezone('UTC')->format('Y-m-d H:i:s') }}">
    <div class="max-w-6xl w-full py-5 flex flex-col gap-3">
        <div class="flex justify-between items-center w-full bg-slate-800 p-5 rounded-lg">
            <p>
                <span class="font-semibold">Logged as:</span>
                <span>{{ auth()->user()->name }}</span>
                ·
                <span class="text-sm" data-place="{{ (auth()->user()->workplace->id * 5 + 3) * 8 }}" id="place">{{ auth()->user()->workplace->address->street }}, {{ auth()->user()->workplace->address->city }}</span>
            </p>
            <a class="hover:underline" href="{{ route('staff.auth.logout') }}">Logout</a>
        </div>
        <div class="bg-slate-800 p-5 rounded-lg flex flex-col gap-6" id="list">
            <p class="text-3xl">Pending orders</p>
            <div class="flex flex-col gap-3" id="pending-list">
                @foreach ($orders as $i => $order)
                    <div class="bg-slate-700 rounded-md p-4">
                        <div class="flex justify-between items-center cursor-pointer">
                            <p class="text-xl font-semibold">#{{ $order->code }}</p>
                            <svg class="h-6 fill-white rotate-0 duration-200" stroke-width="0" stroke="currentColor" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" d="M1.646 6.646a.5.5 0 01.708 0L8 12.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" fill-rule="evenodd"></path>
                                <path clip-rule="evenodd" d="M1.646 2.646a.5.5 0 01.708 0L8 8.293l5.646-5.647a.5.5 0 01.708.708l-6 6a.5.5 0 01-.708 0l-6-6a.5.5 0 010-.708z" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="max-h-0 overflow-hidden duration-200 flex flex-col gap-4">
                            <p>
                                <span class="font-medium">Order date:</span>
                                <span class="font-light">{{ $order->created_at->format('F d, Y H:i (e)') }}</span>
                            </p>
                            <p>
                                <span class="font-medium">Delivery address:</span>
                                <span class="font-light">{{ $order->address->street }}, {{ $order->address->city }}</span>
                            </p>
                            <p>
                                <span class="font-medium">Total:</span>
                                <span class="font-light">${{ $order->total }}</span>
                            </p>
                            <p class="font-semibold text-2xl">Ordered items</p>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach ($order->meals()->select('name', 'meal_order.quantity AS quantity')->orderBy('name')->get() as $meal)
                                    <div class="w-full flex flex-col gap-4 bg-slate-800 p-3 rounded-md" title="{{ $meal->quantity }}x '{{ ucfirst($meal->name) }}'">
                                        <div class="flex items-center justify-between">
                                            <p class="font-semibold text-xl truncate max-w-[75%]">{{ ucfirst($meal->name) }}</p>
                                            <p class="">x {{ $meal->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/employee/working.js') }}"></script>
@endsection
