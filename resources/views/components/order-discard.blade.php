<div class="h-screen w-full absolute top-0 left-0 z-30 bg-[#101010d3] hidden items-center justify-center" id="discard">
    <div class="px-6 py-10 bg-white rounded-lg flex flex-col items-center">
        <p class="text-4xl font-semibold">Are you sure you want to cancel order?</p>
        <p class="font-light text-[#808080] flex flex-col items-center mt-3 mb-8">
            <span>Whole order progress will be deleted and won't be possible to regain</span>
            <span>Make sure you no longer want to make an order before discarding it</span>
        </p>
        <div class="flex gap-2 items-center">
            <button class="border-2 border-solid border-green-700 text-green-700 rounded-md px-4 py-2 hover:-translate-y-1 duration-150" id="cancel-btn" type="button">Keep progress</button>
            <a class="border-2 border-solid border-red-700 bg-red-700 text-white rounded-md px-4 py-2 hover:-translate-y-1 duration-150" href="{{ route('homepage') }}">Discard order</a>
        </div>
        @csrf
    </div>
</div>

<script src="/js/orderDiscard.js"></script>
