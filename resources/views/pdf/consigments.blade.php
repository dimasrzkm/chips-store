<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Penitipan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div>
        <div class="text-center">
            <h4>Struk Penitipan Produk</h4>
            <h5>Kripik Pisang Asa Cipto Roso</h5>
            <p>Jl. Pagar Alam No.49, Kedaton, Kec. Kedaton</p>
            <p style="margin-top: -20px;">Kota Bandar Lampung, Lampung 35152</p>
        </div>
        <div>
            <p>No Transaksi : {{ $consigment['transaction_code'] }}</p>
            <p style="margin-top: -20px;">Penerima Produk : {{ $consigment['user']['name'] }}</p>
            <p style="margin-top: -20px;">
                Tanggal :
                {{ Carbon\Carbon::parse(date('Y-m-d', strtotime($consigment['consigment_date'])))->format('d/m/Y') }}
            </p>
        </div>
    </div>
    <table class="table table-sm" style="margin-bottom: 50px;">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Produk</th>
                <th scope="col">Total Titipan</th>
                <th scope="col" class="text-center">Pemilik</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consigment['products'] as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['pivot']['total_consigment'] }}</td>
                    @if ($index < 1)
                        <td rowspan="{{ count($consigment['products']) }}" class="text-center align-middle">{{ $product['pivot']['konsinyor_name'] }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-bottom: 150px;">
        <span>Diterima</span>
        <span style="margin-left: 200px;">Dibuat</span>
    </div>
    <div>
        <span>{{ $consigment['products'][0]['pivot']['konsinyor_name'] }}</span>
        <span style="margin-left: 180px;">{{ $consigment['user']['name'] }}</span>
    </div>

    <script>
        setTimeout(() => {
            window.print();
        }, 1000);
    </script>
</body>

</html>
