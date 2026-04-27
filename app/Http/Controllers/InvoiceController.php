<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    // DASHBOARD (history invoice)
    public function dashboard()
    {
        $invoices = Invoice::with(['client', 'items'])
                    ->latest()
                    ->get();

        return view('dashboard', compact('invoices'));
    }

    // FORM CREATE
    public function create()
    {
        return view('invoices.create');
    }

    // LIST (opsional kalau masih dipakai)
    public function index()
    {
        $invoices = Invoice::with(['client', 'items'])->latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    // SIMPAN INVOICE
    public function store(Request $request)
    {
        $subtotal = 0;

        foreach ($request->price as $key => $price) {
            $subtotal += $price * $request->qty[$key];
        }

        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        // nomor invoice otomatis
        $lastInvoice = Invoice::latest()->first();

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, 4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $invoiceNumber = 'INV-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // simpan / ambil client
        $client = Client::firstOrCreate(
            ['name' => $request->client_name],
            [
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]
        );

        // simpan invoice
        $invoice = Invoice::create([
            'client_id' => $client->id,
            'invoice_number' => $invoiceNumber,
            'date' => now(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        // simpan item
        foreach ($request->item_name as $key => $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item,
                'qty' => $request->qty[$key],
                'unit' => $request->unit[$key],
                'price' => $request->price[$key],
                'total' => $request->qty[$key] * $request->price[$key],
            ]);
        }

        return redirect()->route('dashboard');
    }

    // EDIT
    public function edit($id)
    {
        $invoice = Invoice::with(['items', 'client'])->findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // hapus item lama
        InvoiceItem::where('invoice_id', $invoice->id)->delete();

        $subtotal = 0;

        foreach ($request->price as $key => $price) {
            $subtotal += $price * $request->qty[$key];
        }

        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        // update invoice
        $invoice->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);

        // simpan ulang item
        foreach ($request->item_name as $key => $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_name' => $item,
                'qty' => $request->qty[$key],
                'unit' => $request->unit[$key],
                'price' => $request->price[$key],
                'total' => $request->qty[$key] * $request->price[$key],
            ]);
        }

        return redirect()->route('dashboard');
    }

    // HAPUS
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        InvoiceItem::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Invoice berhasil dihapus');
    }
}