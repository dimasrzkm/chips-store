<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembelian</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="text-center">
            <h4>Kripik Pisang Asa Cipto Roso</h4>
            <p>Jl. Pagar Alam No.49, Kedaton, Kec. Kedaton</p>
            <p style="margin-top: -20px;">Kota Bandar Lampung, Lampung 35152</p>
        </div>
        <div>
            <p>No Transaksi : {{ $selling['transaction_code'] }}</p>
            <p style="margin-top: -20px;">Kasir : {{ $selling['user']['name'] }}</p>
            <p style="margin-top: -20px;">
                Tanggal :
                {{ Carbon\Carbon::parse(date('Y-m-d', strtotime($selling['selling_date'])))->format('d/m/Y') }},
                {{ Carbon\Carbon::parse(date('Y-m-d H:i:s', strtotime($selling['created_at'])))->format('H:i:s') }}
            </p>
        </div>
    </div>
    <table class="table table-sm" style="margin-bottom: 50px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($selling['products'] as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['pivot']['quantity'] }}</td>
                    <td>
                        @if ($item['pivot']['purchase_unit'] == 'seperempat')
                            1/4 Kg
                        @elseif ($item['pivot']['purchase_unit'] == 'setengah')
                            1/2 Kg
                        @elseif ($item['pivot']['purchase_unit'] == 'sekilo')
                            1 Kg
                        @else
                            {{ $item['pivot']['purchase_unit'] }}
                        @endif
                    </td>
                    <td>Rp. {{ $item['sale_price'] }}</td>
                    <td>Rp. {{ number_format($item['pivot']['sub_total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5">Total</td>
                <td colspan="5">Rp. {{ number_format($selling['total'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5">Bayar</td>
                <td colspan="5">Rp. {{ number_format($selling['nominal_payment'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5">Kembalian</td>
                <td colspan="5">Rp. {{ number_format($selling['nominal_return'], 0, ',', '.') }}</td>
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
