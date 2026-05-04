<x-app-layout>

<x-slot name="header">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2 style="font-weight:bold;">History Invoice</h2>

        <a href="{{ route('invoices.create') }}"
           class="btn-green">
            + Tambah Invoice
        </a>
    </div>
</x-slot>

<div class="container">

@foreach ($invoices as $invoice)

<!-- MODAL -->
<div id="modal-{{ $invoice->id }}" class="modal">
    <div class="modal-content">

        <h3>Edit {{ $invoice->invoice_number }}</h3>

        <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="edit-table-{{ $invoice->id }}">
                    @foreach ($invoice->items as $item)
                    <tr>
                        <td><input type="text" name="item_name[]" value="{{ $item->item_name }}"></td>
                        <td><input type="number" name="qty[]" value="{{ $item->qty }}"></td>
                        <td><input type="text" name="unit[]" value="{{ $item->unit }}"></td>
                        <td><input type="number" name="price[]" value="{{ $item->price }}"></td>
                        <td>
                            <button type="button" onclick="removeRow(this)" class="btn-red">X</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <br>

            <!-- TAMBAH ITEM -->
            <button type="button"
                onclick="addRow({{ $invoice->id }})"
                class="btn-green">
                + Tambah Barang
            </button>

            <br><br>

            <button type="submit" class="btn-blue">Update</button>
            <button type="button" onclick="closeModal({{ $invoice->id }})" class="btn-gray">
                Tutup
            </button>

        </form>
    </div>
</div>

<!--  CARD  -->
<div class="invoice-box">

    <div class="invoice-header">
        <div>
            <h3>{{ $invoice->invoice_number }}</h3>
            <b>{{ $invoice->client->name }}</b><br>
            {{ date('d-m-Y', strtotime($invoice->date)) }}
        </div>

        <div style="display:flex; gap:5px;">

            <a href="{{ route('invoices.print', $invoice->id) }}
             "class="btn-blue-pdf"> Downdload PDF
            </a>

            <button onclick="openModal({{ $invoice->id }})" class="btn-green-edit">
                Edit
            </button>

            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                  onsubmit="return confirm('Yakin hapus?')">
                @csrf
                @method('DELETE')

                <button class="btn-red">Hapus</button>
            </form>
        </div>
    </div>

    <table class="table">
        <tr>
            <th>Nama</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>

        @foreach ($invoice->items as $item)
        <tr>
            <td>{{ $item->item_name }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->unit }}</td>
            <td>Rp {{ number_format($item->price,0,',','.') }}</td>
            <td>Rp {{ number_format($item->total,0,',','.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="total-box">
        <p>Subtotal: Rp {{ number_format($invoice->subtotal,0,',','.') }}</p>
        <p>Pajak: Rp {{ number_format($invoice->tax,0,',','.') }}</p>
        <h4>Total: Rp {{ number_format($invoice->total,0,',','.') }}</h4>
    </div>

</div>

@endforeach

</div>

<!--  JS  -->
<script>
function openModal(id){
    document.getElementById('modal-'+id).style.display = 'flex';
}

function closeModal(id){
    document.getElementById('modal-'+id).style.display = 'none';
}

function addRow(id){
    let table = document.getElementById('edit-table-'+id);

    let row = `
    <tr>
        <td><input type="text" name="item_name[]"></td>
        <td><input type="number" name="qty[]"></td>
        <td><input type="text" name="unit[]"></td>
        <td><input type="number" name="price[]"></td>
        <td><button type="button" onclick="removeRow(this)" class="btn-red">X</button></td>
    </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);
}

function removeRow(btn){
    btn.closest('tr').remove();
}

// klik luar modal = close
window.onclick = function(e){
    document.querySelectorAll('.modal').forEach(m => {
        if(e.target === m){
            m.style.display = 'none';
        }
    });
}
</script>

<!--CSS -->
<style>
.container {
    max-width: 900px;
    margin: auto;
}

/* CARD */
.invoice-box {
    background: #fff;
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
}

.invoice-header {
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}

/* TABLE */
.table {
    width:100%;
    border-collapse: collapse;
}

.table th, .table td {
    border:1px solid #ddd;
    padding:8px;
    text-align:center;
}

/* BUTTON */
.btn-green { background:green; color:white; padding:6px 10px; border:none; border-radius:5px; }
.btn-green-edit { background:green; color:white; padding:6px 10px; width: 80px; height: 37px; border:none; border-radius:5px; }
.btn-red { background:red; color:white; padding:6px 10px; border:none; border-radius:5px; }
.btn-blue { background:blue; color:white; padding:6px 10px; border:none; border-radius:5px; }
.btn-gray { background:gray; color:white; padding:6px 10px; border:none; border-radius:5px; }
.btn-blue-pdf { background:blue; color:white; padding:6px 10px; width: 140px; height: 37px; border:none; border-radius:5px; }

/* MODAL */
.modal {
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
}

.modal-content {
    background:#fff;
    padding:20px;
    width:600px;
    border-radius:8px;
    max-height:80vh;
    overflow:auto;
}

.total-box {
    text-align:right;
    margin-top:10px;
}
</style>

</x-app-layout>