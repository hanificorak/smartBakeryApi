<?php
// PDF URL'sini al
if (!isset($_GET['path'])) {
    die("PDF yolu belirtilmemiş.");
}

$pdfUrl = $_GET['path'];

// Güvenlik için sadece belirli alanlardan veya domainlerden PDF yüklemeye izin vermek iyi olur
$allowedDomains = ['example.com', 'anotherdomain.com', 'nubifysoftware.com','orimi.com'];
$parsedUrl = parse_url($pdfUrl);


?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Viewer</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>
    <iframe src="<?php echo htmlspecialchars($pdfUrl); ?>"></iframe>
</body>

</html>