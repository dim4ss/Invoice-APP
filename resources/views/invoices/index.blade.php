<div class="container">

@foreach ($invoices as $invoice)

    <div class="invoice-box">

        <div class="header">
            <h3>{{ $invoice->invoice_number }}</h3>
            <div>
                <b>Client:</b> {{ $invoice->client->name }} <br>
                <b>Tanggal:</b> {{ date('d-m-Y H:i', strtotime($invoice->date)) }}
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoice->items as $item)
                <tr>
                    <td class="nama">{{ $item->item_name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-box">
            <p>Subtotal: <span>Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span></p>
            <p>Pajak (11%): <span>Rp {{ number_format($invoice->tax, 0, ',', '.') }}</span></p>
            <h4>Total: <span>Rp {{ number_format($invoice->total, 0, ',', '.') }}</span></h4>
        </div>

    </div>

@endforeach

</div>

<style>
.container {
    max-width: 800px;
    margin: auto;
    font-family: Arial, sans-serif;
}

.invoice-box {
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 25px;
    background: #fff;
}

.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

th {
    background: #f5f5f5;
}

th, td {
    padding: 8px;
    font-size: 13px;
    border: 1px solid #ddd;
}

td {
    text-align: center;
}

.nama {
    text-align: left;
    max-width: 200px;
    word-wrap: break-word;
}

.total-box {
    margin-top: 15px;
    text-align: right;
}

.total-box p, .total-box h4 {
    margin: 3px 0;
}

.total-box span {
    display: inline-block;
    min-width: 150px;
}
</style>