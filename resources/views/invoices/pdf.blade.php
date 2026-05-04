<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>

    <style>
        @page {
            size: A4;
            margin: 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info p {
            margin: 2px 0;
        }

        /* CLIENT */
        .client-box {
            margin-bottom: 20px;
        }

        .client-box p {
            margin: 2px 0;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background: #f4f6f8;
        }

        th {
            text-align: left;
            padding: 10px;
            font-size: 12px;
            border-bottom: 2px solid #ddd;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .text-right {
            text-align: right;
        }

        /* TOTAL */
        .total-box {
            margin-top: 20px;
            width: 300px;
            float: right;
        }

        .total-box table {
            width: 100%;
        }

        .total-box td {
            padding: 6px;
        }

        .total-final {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #333;
        }

        /* FOOTER */
        .footer {
            position: absolute;
            bottom: 30px;
            left: 30px;
            right: 30px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }

    </style>
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div>
            <div class="title">INVOICE</div>
            <p>{{ $invoice->invoice_number }}</p>
        </div>

        <div class="invoice-info">
            <p><b>Tanggal:</b></p>
            <p>{{ date('d-m-Y', strtotime($invoice->date)) }}</p>
        </div>
    </div>

    <!-- CLIENT -->
    <div class="client-box">
        <p><b>Ditagihkan Kepada:</b></p>
        <p>{{ $invoice->client->name }}</p>
        <p>{{ $invoice->client->email ?? '-' }}</p>
        <p>{{ $invoice->client->phone ?? '-' }}</p>
    </div>

    <!-- TABLE ITEM -->
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->unit }}</td>
                <td class="text-right">Rp {{ number_format($item->price,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($item->total,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total-box">
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="text-right">Rp {{ number_format($invoice->subtotal,0,',','.') }}</td>
            </tr>
            <tr>
                <td>Pajak (11%)</td>
                <td class="text-right">Rp {{ number_format($invoice->tax,0,',','.') }}</td>
            </tr>
            <tr class="total-final">
                <td>Total</td>
                <td class="text-right">Rp {{ number_format($invoice->total,0,',','.') }}</td>
            </tr>
        </table>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    Terima kasih atas kepercayaan Anda.
</div>

</body>
</html>