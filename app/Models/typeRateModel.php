<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class typeRateModel extends Model
{
    protected $table = 'type_rate';

    protected $fillable = [
        'name',
        'value',
    ];

    public function invoices(){
        return $this->hasMany(InvoiceModel::class, 'type_rate_id');
    }
}
