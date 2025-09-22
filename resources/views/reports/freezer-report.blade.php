<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('freezer.smartbakery_freezer_report') }}</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }

        * {
            font-family: "DejaVu Sans Mono", monospace;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e5e5;
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
            font-weight: normal;
        }

        .content {
            margin-top: 20px;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: bold;
            padding: 12px 8px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-size: 12px;
        }

        td {
            padding: 10px 8px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .status-high {
            color: #27ae60;
            font-weight: bold;
        }

        .status-medium {
            color: #f39c12;
            font-weight: bold;
        }

        .status-low {
            color: #e74c3c;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e5e5;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }

        .summary-box {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">SmartBakery</div>
        <div class="report-title">{{ __('freezer.freezer_report') }}</div>
        <div class="report-date">{{ __('freezer.report_date') }}: {{ date('d.m.Y H:i') }}</div>
    </div>

    <div class="content">
        <div class="summary-box">
            <div class="summary-title">{{ __('freezer.report_summary') }}</div>
            <div>{{ __('freezer.freezer_summary_text') }}</div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 25%;">{{ __('freezer.report_date') }}</th>
                        @foreach ($freezers as $item)
                            <th style="width: 25%;">{{ $item->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $period = new DatePeriod(
                            new DateTime($startDate),
                            new DateInterval('P1D'),
                            new DateTime($endDate)->modify('+1 day'),
                        );
                    @endphp

                    @foreach ($period as $date)
                        <tr>
                            <td>{{ $date->format('d.m.Y') }}</td>

                            @foreach ($freezers as $freezer)
                                @php

                               $item = DB::table('freezers')->where('fr_id',$freezer->id)->whereDate('created_at',$date->format('Y-m-d'))->first(); 
                       
                                @endphp

                                <td>
                                   
                                    {{($item == null ? '-' : $item->temp . ' °')}}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>


            {{-- <table>
                <thead>
                    <tr>
                        <th style="width: 25%;">{{ __('freezer.freezer_name') }}</th>

                        <th style="width: 25%;">{{ __('freezer.freezer_name') }}</th>
                        <th style="width: 20%;">{{ __('freezer.working_degree') }}</th>
                        <th style="width: 40%;">{{ __('freezer.description') }}</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($query as $item)
                        <tr>
                        <td>{{ $item->fr_name }}</td>
                        <td>{{ $item->temp }}</td>
                        <td>{{ $item->desc }}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>

    <div class="footer">
        <div>{{ __('freezer.smartbakery_management_system') }}</div>
        <div>{{ __('freezer.auto_generated_report') }}</div>
    </div>
</body>

</html>
