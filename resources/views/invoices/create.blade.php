<x-app-layout>

<x-slot name="header">
    <h2 style="font-weight:bold;">Buat Invoice</h2>
</x-slot>

<div class="container">

<form method="POST" action="{{ route('invoices.store') }}">
    @csrf

    <!-- CLIENT -->
    <div class="card">
        <h3>Data Client</h3>

        <div class="grid">
            <input type="text" name="client_name" placeholder="Nama Client" required>
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="phone" placeholder="No HP">
            <input type="text" name="address" placeholder="Alamat">
        </div>
    </div>

    <!-- ITEM -->
    <div class="card">
        <h3>Item Barang</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody id="item-table">
                <tr>
                    <td><input type="text" name="item_name[]" required></td>
                    <td><input type="number" name="qty[]" required></td>
                    <td><input type="text" name="unit[]" placeholder="pcs/kg"></td>
                    <td><input type="number" name="price[]" required></td>
                    <td>
                        <button type="button" onclick="removeRow(this)" class="btn-red">X</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

        <button type="button" onclick="addRow()" class="btn-green">
            + Tambah Barang
        </button>
    </div>

    <!-- SUBMIT -->
    <div style="display:flex; justify-content:space-between; margin-top:20px;">

    <!-- KEMBALI -->
    <a href="{{ route('dashboard') }}" class="btn-gray">
        Kembali ke Dashboard
    </a>

    <!--  SIMPAN -->
    <button type="submit" class="btn-blue">
        Simpan Invoice
    </button>

</div>
    

</form>

</div>

<!-- JS  -->
<script>
function addRow() {
    let row = `
    <tr>
        <td><input type="text" name="item_name[]" required></td>
        <td><input type="number" name="qty[]" required></td>
        <td><input type="text" name="unit[]"></td>
        <td><input type="number" name="price[]" required></td>
        <td><button type="button" onclick="removeRow(this)" class="btn-red">X</button></td>
    </tr>
    `;
    document.getElementById('item-table').insertAdjacentHTML('beforeend', row);
}

function removeRow(btn) {
    btn.closest('tr').remove();
}
</script>

<!-- CSS -->
<style>
.container {
    max-width: 900px;
    margin: auto;
}

/* CARD */
.card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
}

/* GRID */
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* TABLE */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.table th {
    background: #f5f5f5;
}

/* BUTTON */
.btn-green {
    background: green;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
}

.btn-red {
    background: red;
    color: white;
    padding: 6px 10px;
    border: none;
    border-radius: 5px;
}

.btn-blue {
    background: blue;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
}

.btn-gray {
    background: gray;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
}
</style>

</x-app-layout>