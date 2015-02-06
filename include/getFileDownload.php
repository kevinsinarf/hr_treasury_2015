<?php
$file = $_GET['path'];
if (file_exists($file)) {
	header('Content-Description: File Transfer');
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".basename($_GET['path']));
	readfile($_GET['path']);
}else{
	echo header("Content-Type:text/html; charset=windows-874");
	echo "The file $filename does not exist !!!<br>";
	echo "<a href = \"Javascript:void(0);\" onclick=\"window.history.go(-1);\">กลับหน้าเดิม</a>";
}
?>
