<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>{{ __('guess.daily_estimated_production_report') }}</title>
    <style>
        @page {
            margin: 40px 30px 40px 30px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
            background-color: #fff;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            padding: 0 30px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
        }

        .brand img {
            height: 35px;
            margin-right: 10px;
            filter: none;
            opacity: 1;
        }

        .brand .name {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: #212121;
        }

        .report-info {
            text-align: right;
        }

        .report-title {
            font-size: 16px;
            font-weight: 700;
            color: #212121;
            margin-bottom: 3px;
        }

        .report-date {
            font-size: 10px;
            color: #666;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40px;
            background-color: #f8f8f8;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
            padding-top: 8px;
        }

        main {
            padding: 20px 30px 0 30px;
            margin-top: 50px;
            margin-bottom: 40px;
        }

        .table-container {
            display: table;
            width: 100%;
            margin-top: 20px;
        }

        .table-column {
            display: table-cell;
            width: 48%;
            vertical-align: top;
        }

        .table-column:first-child {
            padding-right: 15px;
        }

        .table-column:last-child {
            padding-left: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #e0e0e0;
        }

        th {
            background: #eceff1;
            color: #212121;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        td {
            background-color: #ffffff;
            font-size: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:nth-child(even) td {
            background-color: #fcfcfc;
        }

        .section-header {
            font-size: 16px;
            font-weight: bold;
            color: #212121;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            display: block;
            text-transform: uppercase;
        }

        .summary-box {
            background-color: #f0f4f8;
            border-radius: 4px;
            padding: 15px;
            margin-top: 20px;
            font-size: 12px;
            color: #424242;
            line-height: 1.4;
            border: 1px solid #e0e0e0;
        }

        .summary-box strong {
            color: #212121;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="brand">
        <span class="name">SmartBakery</span>
    </div>
    <div class="report-info">
        <br/>
        <div class="report-date">{{ \Carbon\Carbon::now()->format('d.m.Y H:i') }}</div>
        <br/>
        <div class="report-date">Hava Durumu: {{($datas != null ? $datas[0]['weather'] : '') }}</div>
    </div>
</div>

<main>
    <div class="section-header">{{ __('guess.report_details') }}</div>

    @php
        $halfCount = ceil(count($datas) / 2);
        $firstHalf = array_slice($datas, 0, $halfCount);
        $secondHalf = array_slice($datas, $halfCount);
    @endphp

    <div class="table-container">
        <div class="table-column">
            <table>
                <thead>
                <tr>
                    <th style="width: 50%;">{{ __('guess.product_name') }}</th>
                    <th style="width: 25%;">{{__('guess.day')}}</th>
                    <th style="width: 25%;">{{__('guess.amount')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($firstHalf as $row)
                    <tr>
                        <td>{{ $row['prod_name'] }}</td>
                        <td>{{ $row["day"]}}</td>
                        <td>{{ $row["count"]}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-column">
            <table>
                <thead>
                <tr>
                    <th style="width: 50%;">{{ __('guess.product_name') }}</th>
                    <th style="width: 25%;">{{__('guess.day')}}</th>
                    <th style="width: 25%;">{{__('guess.amount')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($secondHalf as $row)
                    <tr>
                        <td>{{ $row['prod_name'] }}</td>
                        <td>{{ $row["day"]}}</td>
                        <td>{{ $row["count"]}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="summary-box">
        <strong>{{ __('guess.note') }}:</strong>
        {{ __('guess.report_note') }}
    </div>
</main>

<div class="footer">
    SmartBakery &copy; {{ \Carbon\Carbon::now()->format('Y') }} |
    {{ __('guess.all_rights_reserved') }} |
    {{ __('guess.page') }} <script type="text/php">echo $PAGE_NUM;</script>
</div>
</body>
</html>
