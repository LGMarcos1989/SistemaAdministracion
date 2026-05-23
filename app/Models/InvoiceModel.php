<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoice';

    protected $fillable = [
            'invoice_number',
            'invoice_date',
            'description',
            'tax_base',
            'type_rate_id',
            'total',
            'status',
            'note',
            'client_id',
    ];


    public function type_rate (){
        return $this->belongsTo(typeRateModel::class, 'type_rate_id');
    }


    public function client (){
        return $this->belongsTo (ClientModel::class, 'client_id');
    }


public function cancelledInvoice(){
    return $this->hasOne(cancelledInvoiceModel::class,'invoice_id');
}

}
