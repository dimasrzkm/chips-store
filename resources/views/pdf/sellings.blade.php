<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="text-center">
            <h4>Laporan Penjualan</h4>
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
                <th scope="col">Produk</th>
                <th scope="col">Harga Awal</th>
                <th scope="col">Harga Jual</th>
                <th scope="col">Quantity</th>
                <th scope="col">Satuan</th>
                <th scope="col">Total</th>
                <th scope="col">Margin</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_penjualan = 0;
                $total_margin = 0;
            @endphp
            @foreach ($datas as $index => $data)
                @php
                    $total_penjualan += $data['total'];
                    $total_margin += $data['margin'];
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data['product_name'] }}</td>
                    <td>Rp. {{ number_format($data['initial_price'], 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($data['sale_price'], 0, ',', '.') }}</td>
                    <td>{{ $data['quantity'] }}</td>
                    <td>
                        @if ($data['purchase_unit'] == 'seperempat')
                            1/4 Kg
                        @elseif ($data['purchase_unit'] == 'setengah')
                            1/2 Kg
                        @else
                            1 Kg
                        @endif
                    </td>
                    <td>Rp. {{ number_format($data['total'], 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($data['margin'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6">Total Penjualan</td>
                <td>Rp. {{ number_format($total_penjualan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="7">Total Keuntungan Dari Penjualan Produk</td>
                <td>Rp. {{ number_format($total_margin, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <script>
        setTimeout(() => {
            window.print();
        }, 1000);
    </script>
</body>

</html>
