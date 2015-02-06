<?php
$path = "../../";
include($path."include/config_header_top.php");
?>
<div class="row">
	<div class="col-xs-6 col-md-3" style="white-space:nowrap;">ตัวอย่างไฟล์นำเข้า : </div>
	<div class="col-xs-2 col-md-5"><a href="javascript:void(0);"><img src="<?php echo $path;?>images/tb_attach.png" onclick="document.location.href='<?php echo $path;?>include/getFileDownload.php?path=../fileupload/import_commission/ex_commission.xls'" title="ตัวอย่างไฟล์นำเข้า"></a>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-3" style="white-space:nowrap;">เลือกไฟล์นำเข้า : <span style="color:red;">*</span></div>
	<div class="col-xs-12 col-md-9">
		<div class="input-group"><input type="file" id="SS_FILE" name="SS_FILE" class="form-control" placeholder="ไฟล์นำเข้า" value="<?php echo text($data["SS_PICTURE"]);?>"><?php echo displayDownloadFileAttach("../fileupload/user_profile/",$data['SS_PICTURE'],$arr_txt['download']);?></div> 
	</div>
</div>						
<?php //$db->close_conn();?>