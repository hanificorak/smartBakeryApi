<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Genel Rapor - smartBakery</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #f5f7fa;
            color: #2d3748;
            line-height: 1.6;
            padding: 0;
            margin: 0;
        }

        .container {
            background: white;
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
        }

        .header {
            background: #667eea;
            color: white;
            text-align: center;
            padding: 20px 10px;
            margin: 0;
        }

        .main-title {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: -1px;
        }

        .subtitle {
            font-size: 18px;
            opacity: 0.95;
            font-weight: 300;
        }

        .report-info {
            background: #f8fafc;
            padding: 30px;
            margin: 0;
            border-left: 4px solid #667eea;
            border-bottom: 1px solid #e2e8f0;
        }

        .content {
            padding: 30px 40px 40px 40px;
        }

        .report-info h3 {
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: 600;
        }

        .report-info p {
            color: #4a5568;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .summary-cards {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .summary-card {
            flex: 1;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
        }

        .summary-card h4 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
            color: #667eea;
        }

        .summary-card p {
            font-size: 14px;
            color: #718096;
            font-weight: 400;
        }

        .table-container {
            margin-top: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: #667eea;
        }

        thead th {
            color: white;
            font-weight: 600;
            padding: 20px 15px;
            text-align: left;
            font-size: 14px;
            letter-spacing: 0.5px;
            border: none;
        }

        tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody td {
            padding: 18px 15px;
            font-size: 14px;
            color: #4a5568;
        }

        .product-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 15px;
        }

        .quantity-produced {
            color: #4299e1;
            font-weight: 600;
        }

        .quantity-sold {
            color: #38a169;
            font-weight: 600;
        }

        .quantity-waste {
            color: #e53e3e;
            font-weight: 600;
        }

        .weather {
            background: #edf2f7;
            color: #4a5568;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .weather-sunny {
            background: #fef5e7;
            color: #c05621;
            border-color: #f6ad55;
        }

        .weather-cloudy {
            background: #f7fafc;
            color: #4a5568;
            border-color: #cbd5e0;
        }

        .weather-rainy {
            background: #ebf8ff;
            color: #2b6cb0;
            border-color: #63b3ed;
        }

        .weather-partly-cloudy {
            background: #f0fff4;
            color: #276749;
            border-color: #9ae6b4;
        }

        .date {
            color: #718096;
            font-size: 13px;
            font-weight: 500;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #718096;
            font-size: 12px;
            border-top: 2px solid #e2e8f0;
            padding: 25px 40px;
            background: #f8fafc;
            margin-left: -40px;
            margin-right: -40px;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .info-badge {
            background: #667eea;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            margin-left: 8px;
        }

        .section-title {
            color: #2d3748;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }

        /* Dompdf için özel ayarlar */
        @page {
            margin: 15mm;
        }

        /* Performans metrikleri için renkler */
        .metric-excellent { color: #38a169; }
        .metric-good { color: #4299e1; }
        .metric-warning { color: #ed8936; }
        .metric-danger { color: #e53e3e; }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 class="main-title">smartBakery</h1>
            <p class="subtitle">Atık Raporu</p>
        </div>

        <div class="report-info">
            <h3>Rapor Özeti</h3>
            <p>Bu rapor, fırın işletmesinin atık raporunu, üretim verilerini ve hava durumu etkilerini kapsamlı bir şekilde analiz etmektedir.</p>
            <p><strong>Rapor Tarihi:</strong> Başlangıç: {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - Bitiş: {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</p>
        </div>

        <div class="content">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Ürün Adı</th>
                            <th>Üretilen</th>
                            <th>Satılan</th>
                            <th>Atık</th>
                            <th>Hava Durumu</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reportData as $data)
                            <tr>
                                <td class="product-name">{{ $data->product->name }}</td>
                                <td class="quantity-produced">{{ $data->amount }}</td>
                                <td class="quantity-sold">{{ $data->current }}</td>
                                <td class="quantity-waste">{{ $data->amount - $data->current }}</td>
                                <td>
                                    <span class="weather weather-sunny">{{ $data->weather->description }}</span>
                                </td>
                                <td class="date">{{ \Carbon\Carbon::parse($data->created_at)->format('d.m.Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="footer">
                <p><strong>© {{ date('Y') }} smartBakery</strong> - Tüm hakları saklıdır.</p>
                <p>Bu rapor sistem tarafından otomatik olarak oluşturulmuştur.</p>
                <p>Detaylı analiz için sistem yöneticisi ile iletişime geçebilirsiniz.</p>
            </div>
        </div>
    </div>
</body>

</html>