<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Genel Rapor - smartBakery</title>

    <style>
        * {
            font-family: "DejaVu Sans Mono", monospace;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "DejaVu Sans Mono", monospace;
            background: #ffffff;
            color: #1a202c;
            line-height: 1.5;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            background: white;
            min-height: auto;
            max-height: 297mm;
            /* A4 height */
            width: 210mm;
            /* A4 width */
            margin: 0 auto;
            position: relative;
            padding-bottom: 50px;
            box-sizing: border-box;
            page-break-inside: avoid;
            page-break-after: always;
            overflow: hidden;
        }

        .container:last-child {
            page-break-after: auto;
        }

        /* Header Styles */
        .header {
            background: #2d3748;
            color: white;
            padding: 20px 40px;
            margin: 0;
            box-sizing: border-box;
            position: relative;
        }

        .header-content {
            display: table;
        }

        .company-info {
            /* display: table-cell;
            vertical-align: middle; */
        }

        .company-info h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
            color: #ffffff;
        }

        .company-info p {
            font-size: 14px;
            color: #cbd5e0;
            margin: 0;
        }

        .report-date {
            background: #4a5568;
            padding: 15px;
            border-radius: 6px;
            float: right;
        }

        .report-date h3 {
            font-size: 18px;
            margin: 0 0 3px 0;
            color: #ffffff;
        }

        .report-date p {
            font-size: 12px;
            color: #cbd5e0;
            margin: 0;
        }

        /* Summary Section */
        .summary-section {
            background: #f8fafc;
            padding: 30px 40px;
            border-bottom: 1px solid #e2e8f0;
            margin: 0;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-info {
            display: table-cell;
            vertical-align: top;
            width: 60%;
            padding-right: 30px;
        }

        .summary-info h3 {
            font-size: 20px;
            color: #2d3748;
            margin: 0 0 15px 0;
            font-weight: 700;
        }

        .summary-info p {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.6;
            margin: 8px 0;
        }

        .stats-cards {
            display: table-cell;
            vertical-align: top;
            width: 40%;
        }

        .stats-grid {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px;
        }

        .stat-row {
            display: table-row;
        }

        .stat-card {
            display: table-cell;
            background: white;
            padding: 18px 12px;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            width: 50%;
        }

        .stat-card .number {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin: 0 0 5px 0;
            display: block;
        }

        .stat-card .label {
            font-size: 11px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .stat-card.production .number {
            color: #38a169;
        }

        .stat-card.sales .number {
            color: #3182ce;
        }

        .stat-card.waste .number {
            color: #e53e3e;
        }

        .stat-card.carry .number {
            color: #d69e2e;
        }

        /* Content Styles */
        .content {
            padding: 20px 40px;
        }

        .section-title {
            font-size: 14px;
            color: #2d3748;
            margin-bottom: 15px;
            font-weight: 600;
            border-bottom: 2px solid #3182ce;
            padding-bottom: 5px;
            display: inline-block;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 0;
            overflow: hidden;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        thead {
            background: #2d3748;
        }

        thead th {
            color: white;
            padding: 15px 10px;
            font-size: 12px;
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-right: 1px solid #4a5568;
        }

        thead th:last-child {
            border-right: none;
        }

        tbody td {
            padding: 12px 10px;
            font-size: 12px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #f1f5f9;
        }

        tbody td:last-child {
            border-right: none;
        }

        tbody tr {
            background: white;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:nth-child(odd) {
            background: white;
        }

        /* Product name styling */
        .product-name {
            font-weight: 600;
            color: #2d3748;
            text-align: left !important;
            max-width: 120px;
        }

        /* Quantity styling */
        .quantity-produced {
            color: #38a169;
            font-weight: 600;
        }

        .quantity-sold {
            color: #3182ce;
            font-weight: 600;
        }

        .quantity-waste {
            color: #e53e3e;
            font-weight: 600;
        }

        .quantity-carry {
            color: #d69e2e;
            font-weight: 600;
        }

        /* Weather styling */
        .weather {
            background: #edf2f7;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            color: #4a5568;
            font-weight: 500;
        }

        .date {
            color: #718096;
            font-size: 10px;
        }

        /* Footer Styles */
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #2d3748;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 9px;
            box-sizing: border-box;
        }

        .footer p {
            margin: 2px 0;
        }

        .footer .company-name {
            font-weight: 700;
            color: #90cdf4;
        }

        /* Page break */
        .page-break {
            page-break-after: always;
            height: 0;
            margin: 0;
            padding: 0;
        }

        /* Empty state styling */
        .empty-state {
            text-align: center;
            color: #a0aec0;
            font-style: italic;
            padding: 30px 0;
            font-size: 12px;
        }

        /* Responsive adjustments for PDF */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                font-size: 11px;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                min-height: auto;
                box-shadow: none;
                margin: 0;
            }

            .header-content {
                display: block;
            }

            .company-info,
            .report-date {
                display: block;
                width: 100%;
                text-align: left;
                margin-bottom: 15px;
                float: right;
            }

            .summary-grid {
                display: block;
            }

            .summary-info,
            .stats-cards {
                display: block;
                width: 100%;
                padding: 0;
                margin-bottom: 20px;
            }

            .stats-grid {
                display: block;
            }

            .stat-row {
                display: block;
                margin-bottom: 10px;
            }

            .stat-card {
                display: inline-block;
                width: 22%;
                margin-right: 2%;
                vertical-align: top;
            }
        }

        /* Utility classes */
        .text-success {
            color: #38a169;
        }

        .text-warning {
            color: #d69e2e;
        }

        .text-danger {
            color: #e53e3e;
        }

        .text-info {
            color: #3182ce;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    @foreach ($dailyReports as $day)
        <div class="container">
            <!-- Header Section -->
            <div class="header">
                <div class="header-content">
                    <div class="company-info">
                        <h1>{{ $company->company_title }}</h1>
                        <p>{{ $company->company_address }} - {{ $company->company_phone }}</p>
                    </div>

                </div>
            </div>

            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-grid">
                    <div class="summary-info">
                        <h3>Rapor Özeti</h3>
                        <p><strong>Tarih:</strong> {{ $day['date'] }}</p>
                        <p>Bu rapor {{ $day['date'] }} tarihine ait üretim, satış, atık ve stok devir verilerini
                            içermektedir.
                            Hava durumu bilgileri ile birlikte analiz edilebilecek detaylı veriler sunulmaktadır.</p>
                    </div>
                    <div class="stats-cards">
                        <div class="stats-grid">
                            <div class="stat-row">
                                <div class="stat-card production">
                                    <div class="number">{{ $day['data']->sum('amount') }}</div>
                                    <div class="label">Toplam Üretim</div>
                                </div>
                                <div class="stat-card sales">
                                    <div class="number">{{ $day['data']->sum('sales_amount') }}</div>
                                    <div class="label">Toplam Satış</div>
                                </div>
                            </div>
                            <div class="stat-row">
                                <div class="stat-card waste">
                                    <div class="number">{{ $day['data']->sum('remove_amount') }}</div>
                                    <div class="label">Toplam Atık</div>
                                </div>
                                <div class="stat-card carry">
                                    <div class="number">{{ $day['data']->sum('ert_count') }}</div>
                                    <div class="label">Ertesi Güne</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="content">
                <h2 class="section-title">Detaylı Ürün Analizi</h2>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 20%;">Ürün Adı</th>
                                <th style="width: 12%;">Üretilen</th>
                                <th style="width: 12%;">Satılan</th>
                                <th style="width: 12%;">Atık</th>
                                <th style="width: 12%;">Ertesi Güne</th>
                                @if ($weather_view == 'view')
                                    <th style="width: 15%;">Hava Durumu</th>
                                @endif
                                <th style="width: 17%;">Kayıt Tarihi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($day['data'] as $data)
                                <tr>
                                    <td class="product-name">{{ $data->product->name }}</td>
                                    <td class="quantity-produced">{{ number_format($data->amount) }}</td>
                                    <td class="quantity-sold">{{ number_format($data->sales_amount) }}</td>
                                    <td class="quantity-waste">{{ number_format($data->remove_amount) }}</td>
                                    <td class="quantity-carry">{{ number_format($data->ert_count) }}</td>
                                    @if ($weather_view == 'view')
                                        <td>
                                            <span class="weather">{{ $data->weather->description }}</span>
                                        </td>
                                    @endif

                                    <td class="date">
                                        {{ \Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        Bu tarih için kayıtlı veri bulunmamaktadır
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($day['data']->count() > 0)
                    <div
                        style="margin-top: 15px; padding: 12px; background: #f7fafc; border-radius: 6px; border-left: 4px solid #3182ce;">
                        <h4 style="color: #2d3748; margin-bottom: 6px; font-size: 12px; font-weight: 600;">Günlük Özet:
                        </h4>
                        <div style="display: table; width: 100%; font-size: 10px;">
                            <div style="display: table-cell; width: 33.33%; color: #4a5568;">
                                <strong>Atık Oranı:</strong>
                                %{{ number_format(($day['data']->sum('remove_amount') / max($day['data']->sum('amount'), 1)) * 100, 1) }}
                            </div>
                            <div style="display: table-cell; width: 33.33%; color: #4a5568;">
                                <strong>Satış Oranı:</strong>
                                %{{ number_format(($day['data']->sum('sales_amount') / max($day['data']->sum('amount'), 1)) * 100, 1) }}
                            </div>
                            <div style="display: table-cell; width: 33.33%; color: #4a5568;">
                                <strong>Devir Oranı:</strong>
                                %{{ number_format(($day['data']->sum('ert_count') / max($day['data']->sum('amount'), 1)) * 100, 1) }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="footer">
                <p><span class="company-name">smartBakery</span> © {{ date('Y') }} - Tüm hakları saklıdır.</p>
                <p>Bu rapor sistem tarafından otomatik olarak {{ date('d.m.Y H:i') }} tarihinde oluşturulmuştur.</p>
            </div>
        </div>

        {{-- Her gün yeni sayfa, son gün hariç --}}
        @unless ($loop->last)
            <!-- Sayfa sonu zorlaması -->
        @endunless
    @endforeach
</body>

</html>
