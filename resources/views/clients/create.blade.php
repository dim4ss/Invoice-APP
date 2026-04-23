<h1>Buat Invoice</h1>

<form method="POST" action="{{ route('invoices.store') }}">
    @csrf

    <!-- CLIENT -->
    <label>Nama Client</label>
    <input type="text" name="client_name" required>

    <br>

    <label>Email</label>
    <input type="email" name="email">

    <br>

    <label>Phone</label>
    <input type="text" name="phone">

    <br>

    <label>Address</label>
    <input type="text" name="address">

    <br><br>

    <!-- 🔴 ITEM TABLE -->
    <h3>Item</h3>

    <table border="1" cellpadding="10" id="item-table">
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
            <tr>
                <td><input type="text" name="item_name[]" required></td>
                <td><input type="number" name="qty[]" class="qty" required></td>
                <td><input type="text" name="unit[]" required></td>
                <td><input type="number" name="price[]" class="price" required></td>
                <td><input type="number" class="total" readonly></td>
                <td><button type="button" onclick="removeRow(this)">X</button></td>
            </tr>
        </tbody>
    </table>

    <br>

    <button type="button" onclick="addRow()">+ Tambah Barang</button>

    <br><br>

    <h3>Subtotal: <span id="subtotal">0</span></h3>
    <h3>Pajak (11%): <span id="tax">0</span></h3>
    <h3>Total: <span id="grandTotal">0</span></h3>

    <br>

    <button type="submit">Simpan</button>
</form>

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
        <td><button type="button" onclick="removeRow(this)">X</button></td>
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
</script>