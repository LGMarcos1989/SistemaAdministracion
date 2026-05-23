<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\cancelledInvoiceModel;

class cancelledInvoiceController extends Controller
{
    public function getAnuladas()
    {
        // return cancelledInvoiceModel::with('invoice.client')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);
    }
    
    public function showAbonos($id)
    {
        // $abono = cancelledInvoiceModel::with('invoice.client', 'invoice.type_rate')
        //     ->findOrFail($id);

        // return view('admin.facturacion.showAbonos', compact('abono'));
    }

    public function index()
    {
        // return cancelledInvoiceModel::with('invoice.client')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(10);
    }
}

