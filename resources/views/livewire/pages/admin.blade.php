<div wire:poll.45s="handleOnColumnClick(1)">
    <div class="grid gap-5 md:grid-cols-2">
        <div class="bg-white border border-gray-200 rounded-lg shadow stats dark:bg-gray-800 dark:border-gray-700">
            <div class="stat">
                <div class="stat-title">Total Produk</div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-desc">Produk yang tersedia</div>
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg shadow stats dark:bg-gray-800 dark:border-gray-700">
            <div class="border-none stat ">
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value">{{ $totalSellings }}</div>
                <div class="stat-desc">
                    Per Tanggal
                    @if ($checkRenderDateForToday == 1)
                        {{ $this->date_selling_start->format('Y-m-d') }} s/d
                        {{ $this->date_selling_end->format('Y-m-d') }}
                    @else
                        {{ $this->date_selling_start }} s/d
                        {{ $this->date_selling_end }}
                    @endif
                </div>
            </div>
            <div class="flex flex-col items-center justify-center gap-2">
                @foreach ($datesInWeeks as $index => $dates)
                    <button wire:click="handleOnColumnClickYes('{{ $dates['start'] }}', '{{ $dates['end'] }}')"
                        class="block w-full py-1 text-center transition rounded-sm hover:cursor-pointer hover:bg-slate-200">Minggu
                        {{ $index + 1 }}</button>
                @endforeach
            </div>
        </div>
    </div>
    <div class="h-80">
        <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel" />
    </div>
    {{-- <livewire:scripts /> --}}
    @livewireChartsScripts
</div>
