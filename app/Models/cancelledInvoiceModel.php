<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cancelledInvoiceModel extends Model
{
    protected $table = 'cancelled_invoice_models';

    protected $fillable = [
        'invoice_id',
        'total'
    ];

    public function invoice (){
        return $this->belongsTo(InvoiceModel::class,'invoice_id');
    }
}