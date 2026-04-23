<h1>Buat Invoice</h1>

<form method="POST" action="{{ route('invoices.store') }}">
    @csrf

    <!--  INPUT CLIENT -->
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

    <!--  ITEM -->
    <label>Nama Item</label>
    <input type="text" name="item_name[]" placeholder="Nama Barang">
    <input type="number" name="qty[]" placeholder="Qty">
    <input type="text" name="unit[]" placeholder="kg / pcs / liter">
    <input type="number" name="price[]" placeholder="Harga">

    <br>

    <button type="submit">Simpan</button>
</form>