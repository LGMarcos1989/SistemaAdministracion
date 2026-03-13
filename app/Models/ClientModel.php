<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientModel extends Model
{
    protected $table = 'client';

    protected $fillable = [
        'bussiness_name',
        'cif',
        'address',
        'phone',
        'email',
        'status',
    ];


    public function invoices (){
        return $this-> hasMany (InvoiceModel::class, 'client_id');
    }
}
