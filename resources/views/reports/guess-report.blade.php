<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>Günlük Tahmini Üretim Raporu</title>
    <style>
        @page {
            margin: 40px 30px 40px 30px; /* Kenar boşlukları azaltıldı */
        }

        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px; /* Font boyutu biraz daha küçültüldü */
            color: #333;
            line-height: 1.4; /* Satır aralığı azaltıldı */
            background-color: #fff; /* Tamamen beyaz arka plan */
        }

        /* Üst bilgi */
        .header {
            position: fixed;
            top: 0; /* Üste sıfırlandı */
            left: 0;
            right: 0;
            height: 50px; /* Yükseklik azaltıldı */
            padding: 0 30px; /* Kenar boşlukları ile uyumlu */
            background-color: #f8f8f8; /* Açık gri arka plan */
            border-bottom: 1px solid #ddd; /* Daha belirgin bir çizgi */
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: none; /* Gölge kaldırıldı */
        }

        .brand {
            display: flex;
            align-items: center;
        }

        .brand img {
            height: 35px; /* Logo boyutu küçültüldü */
            margin-right: 10px;
            filter: none; /* Gri tonlama kaldırıldı */
            opacity: 1; /* Tam opaklık */
        }

        .brand .name {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.2px; /* Harf aralığı azaltıldı */
            color: #212121; /* Koyu renk */
        }

        .report-info {
            text-align: right;
        }

        .report-title {
            font-size: 16px;
            font-weight: 700;
            color: #212121;
            margin-bottom: 3px; /* Boşluk azaltıldı */
        }

        .report-date {
            font-size: 10px; /* Tarih boyutu küçültüldü */
            color: #666;
        }

        /* Alt bilgi */
        .footer {
            position: fixed;
            bottom: 0; /* Alta sıfırlandı */
            left: 0;
            right: 0;
            height: 40px; /* Yükseklik azaltıldı */
            background-color: #f8f8f8;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
            padding-top: 8px; /* İç boşluk azaltıldı */
            box-shadow: none; /* Gölge kaldırıldı */
        }

        /* Ana içerik */
        main {
            padding: 20px 30px 0 30px; /* Üst boşluk ve kenar boşlukları */
            margin-top: 50px; /* Header yüksekliği kadar boşluk */
            margin-bottom: 40px; /* Footer yüksekliği kadar boşluk */
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Tekrar collapse yapıldı */
            margin-top: 20px; /* Boşluk azaltıldı */
            box-shadow: none; /* Gölge kaldırıldı */
            border-radius: 0; /* Yuvarlak köşeler kaldırıldı */
            overflow: visible; /* Köşeler için overflow kaldırıldı */
        }

        th, td {
            padding: 10px 15px; /* İç boşluklar azaltıldı */
            text-align: left;
            border: 1px solid #e0e0e0; /* Tüm kenarlıklara daha ince ve açık bir çizgi */
        }

        th {
            background: #eceff1; /* Daha nötr bir gri tonu */
            color: #212121; /* Koyu renk */
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1px; /* Harf aralığı daha da azaltıldı */
        }

        td {
            background-color: #ffffff;
            font-size: 11px;
            border-bottom: 1px solid #e0e0e0; /* Tüm kenarlıklar için */
        }

        tr:last-child td {
            border-bottom: 1px solid #e0e0e0; /* Son satırın alt çizgisini bırak */
        }

        tr:nth-child(even) td {
            background-color: #fcfcfc; /* Alternatif satır rengi daha açık */
        }

        /* Ekstra bölümler */
        .section-header {
            font-size: 16px;
            font-weight: bold;
            color: #212121;
            margin-bottom: 15px; /* Boşluk azaltıldı */
            border-bottom: 1px solid #ccc; /* Daha ince bir çizgi */
            padding-bottom: 5px;
            display: block; /* Tam genişlikte */
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-box {
            background-color: #f0f4f8; /* Daha nötr bir mavi tonu */
            border-radius: 4px; /* Daha az yuvarlak köşeler */
            padding: 15px; /* İç boşluk azaltıldı */
            margin-top: 20px; /* Boşluk azaltıldı */
            font-size: 12px;
            color: #424242; /* Metin rengi koyu */
            line-height: 1.4;
            border: 1px solid #e0e0e0; /* Kenarlık eklendi */
        }

        .summary-box strong {
            color: #212121;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">
            <!-- Logonuzun yolu burada olmalı -->
            <!-- <img src="{{ public_path('images/your-logo.png') }}" alt="Şirket Logosu"> -->
            <span class="name">SmartBakery</span>
        </div>
        <div class="report-info">
            <br/>
            <div class="report-date">{{ \Carbon\Carbon::now()->format('d.m.Y H:i') }}</div>
        </div>
    </div>

    <main>
        <div class="section-header">Rapor Detayları</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 35%;">Ürün Adı</th>
                    <th style="width: 65%;">Tahmin Mesajı</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $row)
                    <tr>
                        <td>{{ $row['prod_name'] }}</td>
                        <td>{{ $row['msg'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-box">
            <strong>Not:</strong> Bu rapor, yapay zeka destekli tahmin modelimize dayanmaktadır ve üretim planlamanıza yardımcı olmak amacıyla sunulmuştur. Gerçek üretim verileri farklılık gösterebilir.
        </div>
    </main>

    <div class="footer">
        SmartBakery &copy; {{ \Carbon\Carbon::now()->format('Y') }} | Tüm Hakları Saklıdır. | Sayfa <script type="text/php">echo $PAGE_NUM;</script>
    </div>
</body>
</html>