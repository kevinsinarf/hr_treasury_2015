<?php
session_start();
$path = "";

$path_out= "index.php";
 

session_destroy();

echo "<script>
	self.location.href='".$path_out."';
</script>";
?>