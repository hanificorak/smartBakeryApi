<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raporunuz Hazır</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f5f5f5; margin: 0; padding: 20px;">
    
    <!-- Ana Container -->
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border: 1px solid #e0e0e0;">
        
        <!-- Header -->
        <tr>
            <td style="background-color: #2c5aa0; padding: 30px 20px; text-align: center;">
                <h1 style="color: white; margin: 0; font-size: 24px; font-weight: normal;">
                    📊 Raporunuz Hazır
                </h1>
            </td>
        </tr>
        
        <!-- Ana İçerik -->
        <tr>
            <td style="padding: 40px 30px;">
                
                <!-- Selamlama -->
                <h2 style="color: #2c5aa0; font-size: 18px; margin: 0 0 20px 0; font-weight: normal;">
                    Merhaba {{ $user->name ?? 'Değerli Kullanıcımız' }},
                </h2>
                
                <!-- Mesaj -->
                <p style="font-size: 16px; line-height: 1.7; color: #555555; margin-bottom: 25px;">
                    Talebiniz doğrultusunda raporunuz başarıyla oluşturulmuştur.<br>
                    Rapor <strong>{{ now()->format('d.m.Y H:i') }}</strong> tarihinde hazırlanmıştır.
                </p>
                
                <!-- İndirme Bölümü -->
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #f8f9fa; border-left: 4px solid #2c5aa0; margin: 25px 0;">
                    <tr>
                        <td style="padding: 25px;">
                            <p style="margin: 0 0 15px 0; font-weight: bold; color: #2c5aa0; font-size: 16px;">
                                🔗 Raporu İndirin
                            </p>
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="background-color: #2c5aa0; padding: 12px 25px; text-align: center;">
                                        <a href="{{ $data }}" style="color: white; text-decoration: none; font-weight: bold; font-size: 14px; display: block;">
                                            📥 Raporu İndir
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <!-- Bilgi Kutusu -->
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color: #e8f4fd; border: 1px solid #bee5eb; margin: 20px 0;">
                    <tr>
                        <td style="padding: 20px;">
                            <p style="margin: 0 0 10px 0; font-weight: bold; color: #2c5aa0;">
                                ℹ️ Önemli Bilgiler:
                            </p>
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding: 3px 0; color: #555555; font-size: 14px;">
                                        • Rapor linki güvenlik nedeniyle 7 gün süreyle geçerlidir
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0; color: #555555; font-size: 14px;">
                                        • İndirme işlemi için internet bağlantısı gereklidir
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 3px 0; color: #555555; font-size: 14px;">
                                        • Herhangi bir sorun yaşarsanız destek ekibimizle iletişime geçebilirsiniz
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                <!-- Çizgi -->
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 30px 0;">
                    <tr>
                        <td style="height: 1px; background-color: #e9ecef;"></td>
                    </tr>
                </table>
                
                <!-- Alt Bilgi -->
                <p style="color: #6c757d; font-size: 14px; text-align: center; margin: 0;">
                    Bu e-posta otomatik olarak gönderilmiştir. Lütfen yanıtlamayın.
                </p>
                
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td style="background-color: #2c3e50; color: #ecf0f1; text-align: center; padding: 25px 20px;">
                <p style="margin: 0 0 5px 0; font-weight: bold;">{{ config('app.name', 'Şirket Adı') }}</p>
                <p style="margin: 0 0 15px 0; font-size: 14px;">Size daha iyi hizmet verebilmek için buradayız.</p>
                <p style="margin: 0; font-size: 12px; opacity: 0.8;">
                    © {{ date('Y') }} Tüm hakları saklıdır.
                </p>
            </td>
        </tr>
        
    </table>
    
</body>
</html>