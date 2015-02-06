<?php 
$postype_id_csv = (int)$_POST['postype_id_csv'] ; 
 
if($postype_id_csv==1){ $filename = "รายงานข้อมูลข้าราชการ";  }
if($postype_id_csv==3){ $filename = "รายงานข้อมูลพนักงานราชการ";  }
if($postype_id_csv==5){ $filename = "รายงานข้อมูลลูกจ้างประจำ";   }
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream'); 
header('Content-Disposition: attachment; filename='.$filename.'.csv');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

echo "\xEF\xBB\xBF"; // UTF-8 BOM
 

//echo "Test <pre>"; print_r($_POST);
 
echo $_POST['listme'];
?>