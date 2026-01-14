<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f5f5f5;
        }
        .invoice-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: 0 auto;
        }
        .invoice-header {
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .invoice-number {
            color: #7f8c8d;
            font-size: 14px;
        }
        .company-info {
            color: #7f8c8d;
            font-size: 14px;
            line-height: 1.8;
        }
        .invoice-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .detail-item {
            margin-bottom: 15px;
        }
        .detail-label {
            font-weight: bold;
            color: #2c3e50;
            font-size: 12px;
            text-transform: uppercase;
        }
        .detail-value {
            color: #333;
            font-size: 14px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            margin: 30px 0;
        }
        table thead {
            background-color: #2c3e50;
            color: white;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: bold;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .total-row {
            background-color: #ecf0f1;
            font-weight: bold;
        }
        .total-amount {
            color: #e74c3c;
            font-size: 24px;
            font-weight: bold;
        }
        .signature-area {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 30%;
            border-top: 1px solid #333;
            padding-top: 10px;
            margin-top: 40px;
        }
        .footer {
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
            margin-top: 40px;
            border-top: 1px solid #e0e0e0;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 15px;
            background-color: #27ae60;
            color: white;
            border-radius: 5px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .invoice-container {
                box-shadow: none;
                padding: 20px;
            }
            .no-print {
                display: none;
            }
        }
        .print-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="no-print print-btn">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Cetak Invoice
        </button>
        <a href="javascript:history.back()" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="invoice-title">PropertyHub</div>
                    <div class="invoice-number">Invoice #{{ $order->invoice_number }}</div>
                    <div class="company-info mt-3">
                        <div><strong>PropertyHub</strong></div>
                        <div>Email: info@propertyhub.com</div>
                        <div>Phone: +62 8xx xxxx xxxx</div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div style="font-size: 12px;">
                        <div><strong>Tanggal Pesanan:</strong></div>
                        <div>{{ $order->created_at->format('d F Y') }}</div>
                    </div>
                    <div style="font-size: 12px; margin-top: 20px;">
                        <span class="status-badge">{{ strtoupper($order->status) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="row">
            <div class="col-md-6">
                <h6 style="font-weight: bold; color: #2c3e50; text-transform: uppercase; font-size: 12px;">Dari:</h6>
                <div class="invoice-details">
                    <div class="detail-item">
                        <div class="detail-label">Penjual</div>
                        <div class="detail-value"><strong>{{ $order->seller->name }}</strong></div>
                        <div class="detail-value">{{ $order->seller->email }}</div>
                        @if ($order->seller->phone)
                            <div class="detail-value">{{ $order->seller->phone }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h6 style="font-weight: bold; color: #2c3e50; text-transform: uppercase; font-size: 12px;">Kepada:</h6>
                <div class="invoice-details">
                    <div class="detail-item">
                        <div class="detail-label">Pembeli</div>
                        <div class="detail-value"><strong>{{ $order->buyer->name }}</strong></div>
                        <div class="detail-value">{{ $order->buyer->email }}</div>
                        @if ($order->buyer->phone)
                            <div class="detail-value">{{ $order->buyer->phone }}</div>
                        @endif
                        @if ($order->buyer->address)
                            <div class="detail-value">{{ $order->buyer->address }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Deskripsi Property</th>
                    <th style="text-align: center; width: 15%;">Qty</th>
                    <th style="text-align: right; width: 20%;">Harga Satuan</th>
                    <th style="text-align: right; width: 20%;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $order->property->title }}</strong><br>
                        <small style="color: #7f8c8d;">
                            {{ $order->property->address }}, {{ $order->property->city }}, {{ $order->property->province }}
                        </small><br>
                        <small style="color: #7f8c8d;">
                            Tipe: {{ ucfirst($order->property->type) }} | Luas: {{ $order->property->area }} m²
                        </small>
                    </td>
                    <td style="text-align: center;">{{ $order->quantity }} unit</td>
                    <td style="text-align: right;">{{ 'Rp ' . number_format($order->price, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary -->
        <div style="margin-bottom: 30px;">
            <div style="text-align: right; margin-bottom: 10px;">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <table style="margin: 0; border: none;">
                            <tr class="total-row">
                                <td style="border: none; padding: 15px 10px;">
                                    <strong>TOTAL HARGA:</strong>
                                </td>
                                <td style="text-align: right; border: none; padding: 15px 10px;">
                                    <span class="total-amount">{{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if ($order->notes)
            <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 30px;">
                <strong style="color: #2c3e50;">Catatan:</strong><br>
                <p style="margin: 10px 0 0 0; color: #333;">{{ $order->notes }}</p>
            </div>
        @endif

        <!-- Signature Area -->
        <div class="signature-area">
            <div class="signature-box">
                <div>Penjual</div>
                <p style="margin: 30px 0; color: #7f8c8d; font-size: 12px;">{{ $order->seller->name }}</p>
            </div>
            <div class="signature-box">
                <div>Pembeli</div>
                <p style="margin: 30px 0; color: #7f8c8d; font-size: 12px;">{{ $order->buyer->name }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan PropertyHub. Invoice ini adalah bukti transaksi yang sah.</p>
            <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
