<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            padding: 30px;
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: #374151;
            font-size: 12px;
        }

        .accent {
            color: darkcyan;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;

            /** Extra personal styles **/
            background-color: orangered;
            color: white;
            text-align: center;
            line-height: 0.7cm;
            font-size: 12px;
        }

        #footnote {
            position: fixed;
            bottom: 50px;
            text-align: left;
            /*line-height: 0.7cm;*/
            font-size: 10px;
        }

        table {
            width: 100%;
        }

        .text-warning {
            color: orangered;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <td><img src="{{public_path('/assets/images/logo_1.png')}}" alt="logo-text" width="100px"></td>
        <td class="text-warning" style="text-align: right; font-size: 15px" ><b>Nota : {{$facture->number}}</b></td>
    </tr>
</table>

<table style="margin-top: 20px; font-weight: bold; font-size: 18px">
    <tr>
        <td>ARBIE SNACK</td>
        <td style="text-align: right">NOTA PEMBELIAN</td>
    </tr>
</table>

<table style="margin-top: 20px">
    <tr>
        <td>Periode</td>
        <td>: {{$facture->period}}</td>

    </tr>
    <tr>
        <td>Nama Supplier</td>
        <td>: {{$facture->supplier?->nama_suplier}}</td>
    </tr>
    <tr>
        <td>Nomor Nota</td>
        <td>: {{$facture->number}}</td>
    </tr>
    <tr>
        <td>Jumlah Item</td>
        <td>: {{$facture->forecastings()->count()}}</td>
    </tr>
</table>

<table style="margin-top: 50px; border-collapse: collapse; border: solid 0.5px #374151">
    <thead>
    <tr style="background-color: rgba(192, 192, 192, 0.3);">
        <th style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            NAMA PRODUK
        </th>
        <th style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            JENIS PRODUK
        </th>
        <th style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            SATUAN PRODUK
        </th>
        <th style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            JUMLAH PEMBELIAN
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($facture->forecastings as $forecasting)
    <tr style="border: solid 0.5px #374151">
        <td style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            {{$forecasting->product?->nama_produk}}
        </td>
        <td style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            {{$forecasting->product?->jenis_produk}}
        </td>
        <td style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            {{$forecasting->product?->satuan}}
        </td>
        <td style="text-align: left; padding-left: 10px; padding-top:10px; padding-bottom: 10px">
            {{$forecasting->purchasing_plan}}
        </td>
    </tr>
    @endforeach

    </tbody>
</table>

{{--<h2 style="text-align: right; margin-top: 20px">Take Home Pay : {{formatToRupiah($payslip->take_home_pay_amount)}}</h2>--}}
<div id="footnote">
</div>
<footer>Copyright &copy; <b>Arbie Snack</b></footer>
</body>
</html>
