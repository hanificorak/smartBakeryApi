<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <title>Günlük Tahmini Üretim Raporu</title>
    <style>
        @page {
            margin: 80px 40px 80px 40px;
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            color: #202124;
        }

        /* Üst bilgi */
        .header {
            position: fixed;
            top: -60px;
            left: 0;
            right: 0;
            height: 60px;
            border-bottom: 1px solid #e5e7eb;
        }

        .brand {
            display: inline-block;
        }

        .brand img {
            height: 38px;
            vertical-align: middle;
            margin-right: 12px;
        }

        .brand .name {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .report-title {
            text-align: right;
            font-size: 16px;
            font-weight: 800;
            margin-top: 6px;
        }

        .report-date {
            text-align: right;
            font-size: 11px;
            color: #6b7280;
        }

        /* Alt bilgi */
        .footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 60px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
            padding-top: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
        }

        th {
            background: #f3f4f6;
            font-size: 12px;
            text-align: left;
        }

        td {
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="brand">

            <span class="name">smartBakery</span>
        </div>
        <div class="report-title">Günlük Tahmini Üretim Raporu</div>
        <div class="report-date"> {{ \Carbon\Carbon::now()->format('d.m.Y') }}</div>
    </div>

    <main>
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Tarih</th>
                    <th style="width: 30%;">Ürün Adı</th>
                    <th style="width: 50%;">Mesaj</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::now()->format('d.m.Y') }}</td>
                        <td>{{ $row['prod_name'] }}</td>
                        <td>{{ $row['msg'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
