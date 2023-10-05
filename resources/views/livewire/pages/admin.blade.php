<div wire:poll.30s="handleOnColumnClick(1)">
    <div class="grid gap-5 md:grid-cols-2">
        <div class="shadow stats">
            <div class="stat">
                <div class="stat-title">Total Produk</div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-desc">Produk yang tersedia</div>
            </div>
        </div>
        <div class="shadow stats">
            <div class="stat">
                <div class="stat-title">Total Transaksi</div>
                <div class="stat-value">{{ $totalSellings }}</div>
                <div class="stat-desc">Transaksi telah dilakukan</div>
            </div>
        </div>
    </div>
    <div class="h-80">
        <livewire:livewire-column-chart key="{{ $columnChartModel->reactiveKey() }}" :column-chart-model="$columnChartModel" />
    </div>
    {{-- <livewire:scripts /> --}}
    @livewireChartsScripts
</div>
