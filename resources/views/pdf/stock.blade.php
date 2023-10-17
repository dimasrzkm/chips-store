<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Bahan Baku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="text-center">
            <h4>Laporan Bahan Baku</h4>
            <h5>Kripik Pisang Asa Cipto Roso</h5>
            <p>Jl. Pagar Alam No.49, Kedaton, Kec. Kedaton, Kota Bandar Lampung, Lampung 35152</p>
        </div>
        <div>
            <p>Laporan per tanggal : {{ "$tanggal_awal s/d $tanggal_akhir" }}</p>
        </div>
    </div>
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Bahan Baku</th>
                <th scope="col">Harga</th>
                <th scope="col">Tanggal Pengadaan</th>
                <th scope="col">Tanggal Pengeluaran</th>
                <th scope="col">Stok</th>
                <th scope="col">Stok Terpakai</th>
                <th scope="col">Total Pembelian</th>
                <th scope="col">Satuan</th>
                <th scope="col">Produk</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 0; @endphp
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $no += 1 }}</td>
                    <td>{{ $stock->name }}</td>
                    <td>Rp. {{ $stock->price }}</td>
                    <td>{{ $stock->purchase_date->format('d/m/Y') }}</td>
                    <td>-</td>
                    <td>{{ $stock->initial_stock }}</td>
                    <td>-</td>
                    <td>Rp. {{ $stock->total_price }}</td>
                    <td>{{ $stock->unit->name }}</td>
                    <td>-</td>
                </tr>
                @foreach ($stock->expenses as $expense)
                    <tr>
                        <td>{{ $no += 1 }}</td>
                        <td>{{ $expense->pivot->stock_name }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ $expense->expense_date->format('d/m/Y') }}</td>
                        <td>{{ $stock->initial_stock -= $expense->pivot->total_used }}</td>
                        <td>{{ $expense->pivot->total_used }}</td>
                        <td>-</td>
                        <td>{{ $stock->unit->name }}</td>
                        <td>{{ $expense->pivot->product_name }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <script>
        setTimeout(() => {
            window.print();
        }, 1000);
    </script>
</body>

</html>
