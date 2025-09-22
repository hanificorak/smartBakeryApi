<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('customorder.custom_order_list_report') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            color: #34495e;
            margin-bottom: 10px;
        }

        .report-date {
            font-size: 11px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #34495e;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid #2c3e50;
        }

        td {
            padding: 10px 8px;
            border: 1px solid #bdc3c7;
            font-size: 11px;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #ecf0f1;
        }

        .row-number {
            text-align: center;
            width: 40px;
            font-weight: bold;
            color: #7f8c8d;
        }

        .customer-name {
            font-weight: 500;
            color: #2c3e50;
        }

        .product-name {
            color: #34495e;
        }

        .quantity {
            text-align: center;
            font-weight: 500;
            color: #27ae60;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #bdc3c7;
            padding-top: 10px;
        }

        .summary-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #34495e;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 11px;
        }

        .summary-label {
            color: #7f8c8d;
        }

        .summary-value {
            font-weight: bold;
            color: #2c3e50;
        }

        @page {
            margin: 20px;
        }
    </style>
</head>

<body>
    <!-- Başlık Bölümü -->
    <div class="header">
        <div class="company-name">Smart Bakery</div>
        <div class="report-title">{{ __('customorder.custom_order_list_report') }}</div>
        <div class="report-date">{{ __('customorder.report_date') }}: {{ date('d.m.Y H:i') }}</div>
    </div>

    <!-- Tablo Bölümü -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>{{ __('customorder.customer_name') }}</th>
                    <th>{{ __('customorder.product_name') }}</th>
                    <th style="text-align: center;">{{ __('customorder.quantity') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $order)
                    <tr>
                        <td class="customer-name" rowspan="{{ $order->orderProducts->count() }}">
                            {{ $order->name_surname ?? '-' }}
                            <br/>
                            {{ __('customorder.pay_desc') }}: {{ $order->desc }}
                        </td>
                        @if ($order->orderProducts->isNotEmpty())
                            @php $firstProduct = $order->orderProducts->first(); @endphp
                            <td class="product-name">{{ $firstProduct->product->name ?? '-' }}</td>
                            <td class="quantity">{{ $firstProduct->amount }}</td>
                    </tr>
                    @foreach ($order->orderProducts->skip(1) as $orderProduct)
                        <tr>
                            <td class="product-name">{{ $orderProduct->product->name ?? '-' }}</td>
                            <td class="quantity">{{ $orderProduct->amount }}</td>
                        </tr>
                    @endforeach
                @else
                    <td colspan="2" style="text-align:center; color:#7f8c8d;">
                        {{ __('customorder.no_products_found') }}
                    </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="3" style="text-align:center; color:#7f8c8d;">
                        {{ __('customorder.no_records_found') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Özet Bölümü -->
    <div class="summary-section">
        <div class="summary-title">{{ __('customorder.report_summary') }}</div>
        <div class="summary-item">
            <span class="summary-label">{{ __('customorder.total_orders') }}:</span>
            <span class="summary-value">
                {{ $data ? $data->count() : 0 }} {{ __('customorder.pcs') }}
            </span>
        </div>
        <div class="summary-item">
            <span class="summary-label">{{ __('customorder.total_quantity') }}:</span>
            <span class="summary-value">
                {{ $data ? $data->flatMap->orderProducts->sum('amount') : 0 }} {{ __('customorder.pcs') }}
            </span>
        </div>
        <div class="summary-item">
            <span class="summary-label">{{ __('customorder.report_creation_date') }}:</span>
            <span class="summary-value">{{ date('d.m.Y H:i:s') }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>{{ __('customorder.auto_generated_report') }}</div>
    </div>
</body>

</html>
