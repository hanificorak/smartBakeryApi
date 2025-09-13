<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ __('general_report') }} - smartBakery</title>

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
            width: 210mm;
            margin: 0 auto;
            position: relative;
            padding-bottom: 50px;
            box-sizing: border-box;
            page-break-inside: avoid;
            page-break-after: always;
            overflow: hidden;
        }

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

        .content {
            padding: 10px 20px;
        }

        .section-title {
            font-size: 14px;
            color: #2d3748;
            margin-bottom: 8px;
            font-weight: 600;
            border-bottom: 2px solid #3182ce;
            padding-bottom: 5px;
            display: inline-block;
        }

        .table-container {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 0;
            overflow: hidden;
            margin: 10px 0;
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
            padding: 6px 3px;
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
            padding: 5px35px;
            font-size: 12px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #f1f5f9;
        }

        tbody td:last-child {
            border-right: none;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .product-name {
            font-weight: 600;
            color: #2d3748;
            text-align: left !important;
            max-width: 120px;
        }

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

        .totals-summary {
            display: table;
            width: 100%;
            margin-top: 6px;
            font-size: 12px;
        }

        .totals-summary div {
            display: table-cell;
            text-align: center;
            padding: 5px;
            border: 1px solid #e2e8f0;
            font-weight: 600;
        }

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

        .footer .company-name {
            font-weight: 700;
            color: #90cdf4;
        }

        .empty-state {
            text-align: center;
            color: #a0aec0;
            font-style: italic;
            padding: 30px 0;
            font-size: 12px;
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
                        <p>{{ __('report.report_date') }}: {{ $day['date'] }}</p>
                        @if ($weather_view == 'view')
                            <p>{{ __('report.weather') }}:
                                {{ $day['data'] != null && count($day['data']) ? $day['data'][0]->weather->description : '' }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="totals-summary">
                <div>{{ __('report.waste_ratio') }}:
                    {{ number_format(($day['data']->sum('remove_amount') / max($day['data']->sum('amount'), 1)) * 100, 1) }}%
                </div>
                <div>{{ __('report.sales_ratio') }}:
                    {{ number_format(($day['data']->sum('sales_amount') / max($day['data']->sum('amount'), 1)) * 100, 1) }}%
                </div>
                <div>{{ __('report.turnover_ratio') }}:
                    {{ number_format(($day['data']->sum('ert_count') / max($day['data']->sum('amount'), 1)) * 100, 1) }}%
                </div>
                <div>{{ __('report.waste_sales_ratio') }}:
                    {{ number_format(($day['data']->sum('remove_amount') / max($day['data']->sum('sales_amount'), 1)) * 100, 1) }}%
                </div>
            </div>
        
            <div class="content">
                <h2 class="section-title">@lang('report.detailed_product_analysis') </h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 20%;">@lang('report.product')</th>
                                <th style="width: 12%;">@lang('report.produced') </th>
                                <th style="width: 12%;">@lang('report.sold') </th>
                                <th style="width: 12%;">@lang('report.waste') </th>
                                <th style="width: 12%;">@lang('report.next_day') </th>

                        </thead>
                        <tbody>
                            @forelse ($day['data'] as $data)
                                <tr>
                                    <td class="product-name">{{ $data->product->name }}</td>
                                    <td class="quantity-produced">{{ number_format($data->amount) }}</td>
                                    <td class="quantity-sold">{{ number_format($data->sales_amount) }}</td>
                                    <td class="quantity-waste">{{ number_format($data->remove_amount) }}</td>
                                    <td class="quantity-carry">{{ number_format($data->ert_count) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">@lang('report.no_data_for_date')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Toplam Rakamlar Tablo Altında -->
                @if ($day['data']->count() > 0)
                    <div class="totals-summary">
                        <div>@lang('report.total_production'): {{ $day['data']->sum('amount') }}</div>
                        <div>@lang('report.total_sales') : {{ $day['data']->sum('sales_amount') }}</div>
                        <div>@lang('report.total_waste') : {{ $day['data']->sum('remove_amount') }}</div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="footer">
                        <p><span class="company-name">smartBakery</span> © {{ date('Y') }} - @lang('report.all_rights_reserved').</p>
                <p>@lang('report.report_generated_automatically')  {{ date('d.m.Y H:i') }}  @lang('report.report_generated_automatically').</p>
            </div>
        </div>
    @endforeach
</body>

</html>
