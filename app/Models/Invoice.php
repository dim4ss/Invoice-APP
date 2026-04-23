<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
        public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    protected $fillable = [
        'client_id',
        'invoice_number',
        'date',
        'subtotal',
        'tax',
        'total'
    ];
}
