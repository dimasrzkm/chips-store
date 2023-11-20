<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pelunasan Penitipan Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="text-center">
            <h4>Pelunasan Penitipan Produk</h4>
            <h5>Kripik Pisang Asa Cipto Roso</h5>
            <p>Jl. Pagar Alam No.49, Kedaton, Kec. Kedaton, Kota Bandar Lampung, Lampung 35152</p>
        </div>
        <div>
            <p>Pelunasan per tanggal : {{ $consigmentDate->format('d F Y') . ' s/d ' . now()->format('d F Y') }}</p>
        </div>
    </div>
    <table class="table table-sm" style="margin-bottom: 50px;">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Barang</th>
                <th scope="col">Total Titipan</th>
                <th scope="col">Jumlah Terjual</th>
                <th scope="col">Jumlah Kembali</th>
                <th scope="col">Harga Awal</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Pemilik</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPenjualanKotor = 0;
                $totalPenjualanBersih = 0;
            @endphp
            @foreach ($products as $index => $product)
                @php
                    $productYangTerjualSelamaPenitipan = $product->sellings->filter(function ($prod) use ($consigmentDate) {
                        return $prod->selling_date->format('Y-m-d') >= $consigmentDate->format('Y-m-d') && $prod->selling_date->format('Y-m-d') <= now()->format('Y-m-d');
                    });
                    $quantityProduct = $productYangTerjualSelamaPenitipan->reduce(function ($acc, $next) {
                        return $acc + $next->pivot->quantity;
                    });
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->total_consigment }}</td>
                    <td>{{ $quantityProduct ? $quantityProduct : 0 }}</td>
                    <td>{{ $jumlahKembali = $product->pivot->total_consigment - $quantityProduct }}</td>
                    <td>Rp. {{ $product->initial_price }}</td>
                    <td>Rp. {{ $product->sale_price }}</td>
                    <td>{{ $product->pivot->konsinyor_name }}</td>
                    @php
                        $totalPenjualanKotor += $quantityProduct * str_replace('.', '', $product->sale_price);
                        $totalPenjualanBersih += $quantityProduct * str_replace('.', '', $product->initial_price);
                    @endphp
                </tr>
            @endforeach
            <tr>
                <td colspan="6">Total Terjual</td>
                <td colspan="2">Rp. {{ number_format($totalPenjualanKotor, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5">Total Terjual Berdasarkan Harga Dasar</td>
                <td colspan="3">Rp. {{ number_format($totalPenjualanBersih, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="7">Total Dibayarkan</td>
                <td>Rp. {{ number_format($totalPenjualanKotor - $totalPenjualanBersih, 0, ',', '.') }} </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-bottom: 150px;">
        <span>Diterima</span>
        <span style="margin-left: 200px;">Dibuat</span>
    </div>
    <div>
        <span>{{ $konsinyorName }}</span>
        <span style="margin-left: 180px;">{{ $nameMakingReport }}</span>
    </div>
    <script>
        setTimeout(() => {
            window.print();
        }, 1000);
    </script>
</body>

</html>
