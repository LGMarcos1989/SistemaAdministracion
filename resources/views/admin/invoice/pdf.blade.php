<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $invoice->number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }

        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
        }

        /* Encabezado */
        .header {
            margin-bottom: 30px;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
        }

        .company-info {
            float: left;
            width: 60%;
        }

        .invoice-title {
            float: right;
            width: 40%;
            text-align: right;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }

        .company-details {
            color: #666;
            font-size: 10px;
        }

        .invoice-number {
            font-size: 28px;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 5px;
        }

        .invoice-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-pendiente {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-pagada {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-anulada {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .clearfix {
            clear: both;
        }

        /* Información del cliente y factura */
        .info-section {
            margin-bottom: 30px;
        }

        .client-info {
            float: left;
            width: 50%;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
        }

        .invoice-info {
            float: right;
            width: 45%;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3b82f6;
        }

        .info-row {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #4b5563;
            display: inline-block;
            width: 100px;
            font-size: 11px;
        }

        .info-value {
            color: #1f2937;
            font-size: 11px;
        }

        /* Tabla de detalles */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .details-table th {
            background-color: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
            font-size: 11px;
        }

        .details-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        /* Totales */
        .totals-section {
            float: right;
            width: 40%;
            margin-bottom: 30px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .total-row {
            font-weight: bold;
            font-size: 14px;
            background-color: #f3f4f6;
        }

        .total-amount {
            font-size: 18px;
            color: #3b82f6;
        }

        /* Notas */
        .notes-section {
            clear: both;
            margin-top: 30px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .notes-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #374151;
        }

        .notes-content {
            color: #6b7280;
            font-size: 10px;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }

        /* Utilidades */
        .text-muted {
            color: #6b7280;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mt-2 {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <div class="company-info">
                <div class="company-name">SISTEMA DE FACTURACIÓN</div>
                <div class="company-details">
                    <div>RUC: 12345678901</div>
                    <div>Dirección: Av. Principal #123, Ciudad</div>
                    <div>Teléfono: (123) 456-7890</div>
                    <div>Email: info@sistema.com</div>
                </div>
            </div>
            <div class="invoice-title">
                <div class="invoice-number">FACTURA</div>
                <div class="invoice-number" style="font-size: 20px;">{{ $invoice->number }}</div>
                <div class="mt-2">
                    <span class="invoice-status status-{{ strtolower($invoice->status) }}">
                        {{ $invoice->status }}
                    </span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="info-section">
            <div class="client-info">
                <div class="section-title">DATOS DEL CLIENTE</div>
                <div class="info-row">
                    <span class="info-label">Razón Social:</span>
                    <span class="info-value">{{ $invoice->client->bussiness_name ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">CIF/NIF:</span>
                    <span class="info-value">{{ $invoice->client->cif ?? 'N/A' }}</span>
                </div>
                @if ($invoice->client->email ?? false)
                    <div class="info-row">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $invoice->client->email }}</span>
                    </div>
                @endif
                @if ($invoice->client->phone ?? false)
                    <div class="info-row">
                        <span class="info-label">Teléfono:</span>
                        <span class="info-value">{{ $invoice->client->phone }}</span>
                    </div>
                @endif
                @if ($invoice->client->address ?? false)
                    <div class="info-row">
                        <span class="info-label">Dirección:</span>
                        <span class="info-value">{{ $invoice->client->address }}</span>
                    </div>
                @endif
            </div>

            <div class="invoice-info">
                <div class="section-title">DETALLES DE LA FACTURA</div>
                <div class="info-row">
                    <span class="info-label">N° Factura:</span>
                    <span class="info-value">{{ $invoice->number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha Emisión:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estado:</span>
                    <span class="info-value">{{ $invoice->status }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Fecha Generación:</span>
                    <span class="info-value">{{ $generated_date }}</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th class="text-right">Base Imponible</th>
                    <th class="text-right">Tipo Impositivo</th>
                    <th class="text-right">Importe Impuesto</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->description ?? 'Servicios prestados según contrato' }}</td>
                    <td class="text-right">{{ number_format($subtotal, 2) }} €</td>
                    <td class="text-right">{{ $taxRate }}%</td>
                    <td class="text-right">{{ number_format($taxAmount, 2) }} €</td>
                    <td class="text-right">{{ number_format($total, 2) }} €</td>
                </tr>
            </tbody>
        </table>

        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>SUBTOTAL:</td>
                    <td class="text-right">{{ number_format($subtotal, 2) }} €</td>
                </tr>
                @if ($taxAmount > 0)
                    <tr>
                        <td>IVA ({{ $taxRate }}%):</td>
                        <td class="text-right">{{ number_format($taxAmount, 2) }} €</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td><strong>TOTAL:</strong></td>
                    <td class="text-right total-amount"><strong>{{ number_format($total, 2) }} €</strong></td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>

        @if ($invoice->nota)
            <div class="notes-section">
                <div class="notes-title">NOTAS:</div>
                <div class="notes-content">{{ $invoice->nota }}</div>
            </div>
        @endif

        <div class="footer">
            <div>Documento generado electrónicamente - Factura válida como comprobante fiscal</div>
            <div class="mt-2">© {{ date('Y') }} Sistema de Facturación - Todos los derechos reservados</div>
        </div>
    </div>
</body>

</html>