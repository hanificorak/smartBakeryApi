<?php
$pdfPath = $_GET['path'] ?? '';
if (!$pdfPath) die('PDF yolu yok.');

$pdfContent = file_get_contents($pdfPath);
$base64 = base64_encode($pdfContent);
?>

<!DOCTYPE html>
<html>

<head>
    <title>PDF Viewer</title>
</head>

<body style="margin:0;">
    <iframe
        src="data:application/pdf;base64,<?php echo $base64; ?>"
        style="width:100%; height:100%; border:none;">
    </iframe>
</body>

</html>