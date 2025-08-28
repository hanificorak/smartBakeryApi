<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Satış ve Atık Raporu</title>
    <style>
        body {
            font-family: "DejaVu Sans Mono", monospace;
            margin: 0;
            padding: 10px;
            padding-top: 0px;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-logo {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 10px;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #34495e;
            margin: 15px 0;
        }

        .report-meta {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            display: table;
            width: 100%;
            box-sizing: border-box;
        }

        .meta-row {
            display: table-row;
        }

        .meta-cell {
            display: table-cell;
            padding: 5px 15px;
            border-right: 1px solid #bdc3c7;
        }

        .meta-cell:last-child {
            border-right: none;
        }

        .meta-label {
            font-weight: bold;
            color: #2c3e50;
        }

        .meta-value {
            color: #34495e;
        }

        .summary-section {
            margin-bottom: 25px;
        }

        .summary-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .summary-cards {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .summary-card {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            padding: 15px;
            border: 1px solid #bdc3c7;
            background-color: #f8f9fa;
        }

        .summary-card:first-child {
            border-right: none;
        }

        .summary-card:last-child {
            border-left: none;
        }

        .card-title {
            font-weight: bold;
            color: #2c3e50;
            font-size: 11px;
            margin-bottom: 8px;
        }

        .card-value {
            font-size: 16px;
            font-weight: bold;
            color: #27ae60;
        }

        .card-value.danger {
            color: #e74c3c;
        }

        .card-value.warning {
            color: #f39c12;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .data-table th {
            background-color: #34495e;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #2c3e50;
        }

        .data-table td {
            padding: 10px 8px;
            border: 1px solid #bdc3c7;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .data-table tr:hover {
            background-color: #e8f4f8;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #bdc3c7;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }

        .page-break {
            page-break-after: always;
        }

        /* Sayfa numarası için */
        @page {
            margin: 20mm;

            @bottom-right {
                content: "Sayfa " counter(page);
                font-family: "DejaVu Sans Mono", monospace;
                font-size: 10px;
                color: #7f8c8d;
            }
        }
    </style>
</head>
@php
    $totalAmount = 0;
    $totalSales = 0;
    $totalRemove = 0;
    $totalErt = 0;
@endphp
@foreach ($reportData as $item)
    @php
        $totalAmount = $totalAmount + $item->total_amount;
        $totalSales = $totalSales + $item->total_sales_amount;
        $totalRemove = $totalRemove + $item->total_remove_amount;
        $totalErt = $totalErt + $item->total_ert_count;
    @endphp
@endforeach

<body>
    <!-- Header Section -->
    <div class="header">
        <div class="company-logo">{{ $company->company_title ?? 'ŞIRKET ADI' }}</div>
        <div class="company-info">
            {{ $company->company_address ?? 'Şirket Adresi, İl/İlçe' }} |
            Tel: {{ $company->company_phone ?? '+90 XXX XXX XX XX' }} |
        </div>
        <div class="report-title">ÜRÜN SATIŞ VE ATIK RAPORU</div>
    </div>

    <!-- Report Meta Information -->
    <div class="report-meta">
        <div class="meta-row">
            <div class="meta-cell">
                <div class="meta-label">Rapor Tarihi:</div>
                <div class="meta-value">{{ $reportDate ?? date('d.m.Y H:i') }}</div>
            </div>
            <div class="meta-cell">
                <div class="meta-label">Tarih Aralığı:</div>
                <div class="meta-value">{{ $startDate ?? '01.01.2024' }} - {{ $endDate ?? '31.12.2024' }}</div>
            </div>

        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-title">ÖZET BİLGİLER</div>

        <div class="summary-cards">
            <div class="summary-card">
                <div class="card-title">TOPLAM ÜRETİM</div>
                <div class="card-value">{{ $totalAmount }} adet</div>
            </div>
            <div class="summary-card">
                <div class="card-title">TOPLAM SATIŞ</div>
                <div class="card-value">{{ $totalSales }} adet</div>
            </div>
            <div class="summary-card">
                <div class="card-title">TOPLAM ATIK</div>
                <div class="card-value danger">{{ $totalRemove }} adet</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">Ürün Adı</th>
                <th style="width: 15%;" class="text-right">Üretim</th>
                <th style="width: 15%;" class="text-right">Satış</th>
                <th style="width: 15%;" class="text-right">Atık</th>
                <th style="width: 15%;" class="text-right">Ertesi Güne Devir</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($reportData as $item)
                <tr>
                    <th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->total_amount }}</td>
                    <td>{{ $item->total_sales_amount }}</td>
                    <td>{{ $item->total_remove_amount }}</td>
                    <td>{{ $item->total_ert_amount }}</td>
                    </th>
                </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Bu rapor {{ date('d.m.Y H:i') }} tarihinde sistem tarafından otomatik olarak oluşturulmuştur.</p>
        <p>{{ $company->company_title ?? 'Şirket Adı' }} - Tüm hakları saklıdır.</p>
    </div>
</body>

</html>
