<section>
    <div class="w-full p-4 bg-white rounded white ">
        <div class="flex justify-center">
            <div
                class="flex items-center justify-center w-20 h-20 text-4xl font-bold capitalize rounded-full shadow bg-slate-800 text-slate-200">
                {{ Auth::user()->name[0] }}
            </div>
        </div>
        <div class="my-5">
            <h3>{{ Auth::user()->name }}</h3>
            <h3>{{ Auth::user()->email }}</h3>

            <div class="my-5">
                <livewire:transaction.balance />
            </div>

            <div class="grid grid-cols-1 gap-1">
                <livewire:transaction.withdrawl />
                <livewire:transaction.deposit />
            </div>
        </div>
    </div>
</section>
