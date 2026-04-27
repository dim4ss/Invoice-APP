<x-app-layout>

    <x-slot name="header">
        <h2>Edit Invoice</h2>
    </x-slot>

    <div style="padding:20px; max-width:800px; margin:auto;">

        <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <h3>Item</h3>

            <table border="1" cellpadding="10" width="100%">
                <tr>
                    <th>Nama</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Harga</th>
                </tr>

                @foreach ($invoice->items as $item)
                <tr>
                    <td>
                        <input type="text" name="item_name[]" value="{{ $item->item_name }}">
                    </td>
                    <td>
                        <input type="number" name="qty[]" value="{{ $item->qty }}">
                    </td>
                    <td>
                        <input type="text" name="unit[]" value="{{ $item->unit }}">
                    </td>
                    <td>
                        <input type="number" name="price[]" value="{{ $item->price }}">
                    </td>
                </tr>
                @endforeach

            </table>

            <br>

            <button type="submit" style="padding:10px; background:blue; color:white;">
                Update Invoice
            </button>

        </form>

    </div>

</x-app-layout>