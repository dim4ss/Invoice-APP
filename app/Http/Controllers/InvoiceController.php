<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\InvoiceItem;


class InvoiceController extends Controller
{
    public function create()
{
    return view('invoices.create');
}

    public function index()
{
    $invoices = Invoice::with(['client', 'items'])->latest()->get();
    return view('invoices.index', compact('invoices'));
}

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

        return redirect()->route('invoices.index');
    }
}