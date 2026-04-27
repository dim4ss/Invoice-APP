<x-app-layout>

<x-slot name="header">
    <h2>Edit Invoice</h2>
</x-slot>

<div style="padding:20px; max-width:900px; margin:auto;">

<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
    @csrf
    @method('PUT')

    <h3>Item</h3>

    <table border="1" cellpadding="10" width="100%" id="item-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($invoice->items as $item)
            <tr>
                <td><input type="text" name="item_name[]" value="{{ $item->item_name }}" required></td>
                <td><input type="number" name="qty[]" class="qty" value="{{ $item->qty }}" required></td>
                <td><input type="text" name="unit[]" value="{{ $item->unit }}" required></td>
                <td><input type="number" name="price[]" class="price" value="{{ $item->price }}" required></td>
                <td><input type="number" class="total" value="{{ $item->total }}" readonly></td>
                <td><button type="button" onclick="removeRow(this)" style="background:red;color:white;">X</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br>

    <button type="button" onclick="addRow()" style="background:green;color:white;padding:5px 10px;">
        + Tambah Barang
    </button>

    <br><br>

    <h3>Subtotal: <span id="subtotal">0</span></h3>
    <h3>Pajak (11%): <span id="tax">0</span></h3>
    <h3>Total: <span id="grandTotal">0</span></h3>

    <br>

    <button type="submit" style="padding:10px; background:blue; color:white;">
        Update Invoice
    </button>

</form>

</div>

<script>
function addRow() {
    let table = document.querySelector("#item-table tbody");

    let row = `
    <tr>
        <td><input type="text" name="item_name[]" required></td>
        <td><input type="number" name="qty[]" class="qty" required></td>
        <td><input type="text" name="unit[]" required></td>
        <td><input type="number" name="price[]" class="price" required></td>
        <td><input type="number" class="total" readonly></td>
        <td><button type="button" onclick="removeRow(this)" style="background:red;color:white;">X</button></td>
    </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest('tr').remove();
    calculateTotal();
}

document.addEventListener('input', function () {
    calculateTotal();
});

function calculateTotal() {
    let subtotal = 0;

    document.querySelectorAll('#item-table tbody tr').forEach(row => {
        let qty = row.querySelector('.qty').value || 0;
        let price = row.querySelector('.price').value || 0;

        let total = qty * price;
        row.querySelector('.total').value = total;

        subtotal += total;
    });

    let tax = subtotal * 0.11;
    let grandTotal = subtotal + tax;

    document.getElementById('subtotal').innerText = subtotal;
    document.getElementById('tax').innerText = tax;
    document.getElementById('grandTotal').innerText = grandTotal;
}

// hitung saat pertama load
calculateTotal();
</script>

</x-app-layout>