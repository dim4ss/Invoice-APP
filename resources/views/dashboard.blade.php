<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ISI DASHBOARD KAMU DI SINI -->
            <h3>History Invoice</h3>

            <a href="{{ route('invoices.create') }}">+ Tambah Invoice</a>

            <br><br>

            <table border="1" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice</th>
                        <th>Client</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $index => $invoice)
                        @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>{{ $invoice->client->name }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                            <td>{{ $invoice->date }}</td>
                            <td>
                                <!-- EDIT -->
                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn-edit">
                                    Edit
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"
                                        onclick="return confirm('Yakin mau hapus invoice ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</x-app-layout>

<style>
table {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
}

th, td {
    padding: 8px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
}

/* tombol edit */
.btn-edit {
    background-color: green;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
}

/* tombol hapus */
.btn-delete {
    background-color: red;
    color: white;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
</style>