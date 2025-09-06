<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Özel Sipariş Listesi Raporu</title>
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

        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            padding: 10px 0;
        }

        .info-section {
            font-size: 11px;
        }

        .info-label {
            color: #7f8c8d;
            font-weight: bold;
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
        <div class="report-title">ÖZEL SİPARİŞ LİSTESİ RAPORU</div>
        <div class="report-date">Rapor Tarihi: {{ date('d.m.Y H:i') }}</div>
    </div>

    <!-- Tablo Bölümü -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Müşteri Adı</th>
                    <th>Ürün Adı</th>
                    <th style="text-align: center;">Miktar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="customer-name">{{ $item->name_surname }}</td>
                        <td class="product-name">{{ $item->product->name }}</td>
                        <td class="quantity">{{ $item->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Özet Bölümü -->
    <div class="summary-section">
        <div class="summary-title">Rapor Özeti</div>
        <div class="summary-item">
            <span class="summary-label">Toplam Sipariş Sayısı:</span>
            <span class="summary-value">{{ count($data) }} Adet</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Toplam Ürün Miktarı:</span>
            <span class="summary-value">{{ ($data == null ? 0 : $data->sum('amount')) }} Adet</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Rapor Oluşturma Tarihi:</span>
            <span class="summary-value">{{ date('d.m.Y H:i:s') }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>Bu rapor otomatik olarak sistem tarafından oluşturulmuştur.</div>
    </div>
</body>

</html>
