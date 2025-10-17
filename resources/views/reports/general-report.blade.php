<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('totalrep.report_title') }}</title>
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
            background: #2d3748;
            color: white;
            padding: 20px 40px;
            margin: 0;
            box-sizing: border-box;
            position: relative;
            text-align: center;
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-logo {
            font-size: 28px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 10px;
            color: #cbd5e0;
            margin-bottom: 15px;
        }

        .header-content {
            display: table;
        }

        .company-info h1 {
            text-align: left;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
            color: #ffffff;
        }

        .company-info p {
            font-size: 14px;
            text-align: left;

            color: #cbd5e0;
            margin: 0;
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

        .card-value.blue {
            color: #0000FF;
        }

        .card-value.warning {
            color: #f39c12;
        }

        /* YENİ: Oranlar için yan yana kart tasarımı */
        .ratios-section {
            margin: 20px 0;
        }

        .ratios-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: center;
        }

        .ratios-grid {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
        }

        .ratios-row {
            display: table-row;
        }

        .ratio-card {
            display: table-cell;
            width: 25%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 4px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            vertical-align: middle;
        }

        .ratio-card.waste {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        }

        .ratio-card.sales {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .ratio-card.turnover {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .ratio-card.waste-sales {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #333;
        }

        .ratio-label {
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            color: black;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            opacity: 0.9;
        }

        .ratio-value {
            font-size: 13px;
            font-weight: bold;
            color: black;

            margin-bottom: 4px;
        }

        .ratio-subtitle {
            font-size: 6px;
            color: black;
            opacity: 0.8;
            font-style: italic;
        }

        /* Alternatif: Daha basit tasarım */
        .ratios-simple {
            display: table;
            width: 100%;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
        }

        .ratios-simple-row {
            display: table-row;
        }

        .ratio-simple-cell {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 8px;
            border-right: 1px solid #dee2e6;
        }

        .ratio-simple-cell:last-child {
            border-right: none;
        }

        .ratio-simple-label {
            font-size: 10px;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .ratio-simple-value {
            font-size: 16px;
            font-weight: bold;
            color: #495057;
        }

        .ratio-simple-value.danger {
            color: #dc3545;
        }

        .ratio-simple-value.success {
            color: #28a745;
        }

        .ratio-simple-value.warning {
            color: #ffc107;
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
    </style>
</head>

@php
    $totalAmount = 0;
    $totalSales = 0;
    $totalRemove = 0;
    $totalErt = 0;

    foreach ($reportData as $item) {
        $totalAmount += $item->total_amount; // Üretim adedi toplanıyor
        $totalSales += $item->total_sales_amount; // Satış adedi toplanıyor
        $totalErt += $item->total_ert_count;
    }


    $yuzdeSatis = ($totalSales / $totalAmount) * 100;
    $yuzdeAtik = ($totalRemove / $totalAmount) * 100;


@endphp

<body>

    <div class="header">
        <div class="header-content">
            <div class="company-info">
                <h1>{{ $company->company_title }}</h1>
                <p>{{ $company->company_address }} - {{ $company->company_phone }}</p>
            </div>
        </div>
    </div>

    <!-- Report Meta Information -->
    <div class="report-meta">
        <div class="meta-row">
            <div class="meta-cell">
                <div class="meta-label">{{ __('totalrep.report_date') }}:</div>
                <div class="meta-value">{{ $reportDate ?? date('d.m.Y H:i') }}</div>
            </div>
            <div class="meta-cell">
                <div class="meta-label">{{ __('totalrep.date_range') }}:</div>
                <div class="meta-value">
                    {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y H:i') ?? '01.01.2024' }}
                    -
                    {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y H:i') ?? '31.12.2024' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-title">{{ __('totalrep.summary') }}</div>

        <div class="summary-cards">
            <div class="summary-card">
                <div class="card-title">{{ __('totalrep.total_production') }}</div>
                <div class="card-value blue">{{ $totalAmount }} {{ __('totalrep.piece') }}</div>
            </div>
            <div class="summary-card">
                <div class="card-title">{{ __('totalrep.total_sales') }}</div>
                <div class="card-value">{{ $totalSales }} {{ __('totalrep.piece') }}</div>
            </div>
            <div class="summary-card">
                <div class="card-title">{{ __('totalrep.total_waste') }}</div>
                <div class="card-value danger">{{ $totalRemove }} {{ __('totalrep.piece') }}</div>
            </div>
        </div>

        <div class="summary-cards">
            <div class="summary-card">
                <div class="card-title">{{ __('report.waste_ratio') }}</div>
                <div class="card-value danger"> {{ number_format($yuzdeAtik, 1) }}% </div>
            </div>
            <div class="summary-card">
                <div class="card-title">{{ __('report.sales_ratio') }}</div>
                <div class="card-value">{{ number_format($yuzdeSatis, 1) }}%</div>
            </div>

        </div>




    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 25%;">{{ __('totalrep.product_name') }}</th>
                <th style="width: 15%;" class="text-right">{{ __('totalrep.production') }}</th>
                <th style="width: 15%;" class="text-right">{{ __('totalrep.sales') }}</th>
                <th style="width: 15%;" class="text-right">{{ __('totalrep.waste') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="text-right">{{ $item->total_amount }}</td>
                    <td class="text-right">{{ $item->total_sales_amount }}</td>
                    <td class="text-right">{{ $item->total_remove_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>{{ __('totalrep.generated_on') }} {{ date('d.m.Y H:i') }} {{ __('totalrep.generated_on_2') }} </p>
        <p>{{ $company->company_title ?? __('totalrep.company_name') }} - {{ __('totalrep.rights_reserved') }}</p>
    </div>
</body>

</html>
