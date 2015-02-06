<?php
$path = "../../";
include($path."include/config_header_top.php");

if($s_type=='1'){
	if($EWT_ROOT_HOST=='192.168.0.223'){
		$WS_Path = "http://192.168.0.223/parliament_law/services/SS_SETUP_COMMISSION.php"; 
	}else{
		$WS_Path = "http://10.156.2.223/services/SS_SETUP_COMMISSION.php"; 
	}
}elseif($s_type=='2'){
	if($EWT_ROOT_HOST=='192.168.0.223'){
		$WS_Path = "http://192.168.0.223/parliament_law/services/SS_SETUP_COMMISSION_TYPE.php"; 
	}else{
		$WS_Path = "http://10.156.2.223/services/SS_SETUP_COMMISSION_TYPE.php"; 
	}
}elseif($s_type=='3'){
	if($EWT_ROOT_HOST=='192.168.0.223'){
		$WS_Path = "http://192.168.0.223/parliament_law/services/SS_SETUP_COMMISSION_POSITION.php"; 
	}else{
		$WS_Path = "http://10.156.2.223/services/SS_SETUP_COMMISSION_POSITION.php"; 
	}
}
ini_set("max_execution_time" , 160);

// ถ้าไม่ส่งค่าให้เซ็ทเป็น idcard = ''
$idcard = ""; 

$ch = curl_init();
$values = array(
	"idcard"=>$idcard   
);
$options = array(
	CURLOPT_URL => $WS_Path,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_POST=>1,
	CURLOPT_POSTFIELDS => http_build_query($values) 
);
curl_setopt_array($ch, $options);
$res = curl_exec($ch);

////////////////////// XML Parser ///////////////////////
function HandleXmlError($errno, $errstr, $errfile, $errline){
	if ($errno==E_WARNING && (substr_count($errstr,"DOMDocument::loadXML()")>0)){
		throw new DOMException($errstr);
	}else{ 
		return false;
	}
} 

$doc = new DOMDocument();
set_error_handler('HandleXmlError');
if ($doc->LoadXML($res) == false){
	echo "Error";
	exit;
}
restore_error_handler();
?>

<!--<input type="hidden" id="ss_type" name="ss_type" value="<?php echo $ss_type;?>">
<div class="row">
	<div class="col-xs-12 col-md-4">รหัส MASTER</div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_MASTER" name="S_MASTER" class="form-control" placeholder="รหัส MASTER" value="<?php echo $S_MASTER; ?>"></div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-4">ชื่อ</div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="ชื่อ" value="<?php echo $S_NAME; ?>"></div>
    <button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button>
</div>-->

<input type="hidden" id="s_type" name="s_type" value="<?php echo $s_type?>">
<div class="row">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr class="info">
					<th width="5%"><div align="center"><small>เลือก</small><br><input type="checkbox" id="allchk" name="allchk" value="1" onClick="getChk();"></div></th> 
					<th width="10%"><div align="center"><small>รหัส</small></div></th>
					<th width="30%"><div align="center"><small>ชื่อ (<?php echo $arr_txt['th'];?>)</small></div></th>
					<th width="30%"><div align="center"><small>ชื่อ (<?php echo $arr_txt['en'];?>)</small></div></th>
				</tr>
			</thead>
			<tbody>
			<?php
				$items = $doc->getElementsByTagName("item");
				if($items->length>0){
					for($i=0;$i < $items->length;$i++){
						$master_id = $items->item($i)->getAttribute("id");
						//$SSCOM_ID = $items->item($i)->getElementsByTagName("SSCOM_ID")->item(0)->nodeValue;
						
						if($s_type=='1'){
							$th="SSCOM_NAME_TH";
							$en="SSCOM_NAME_EN";
						}elseif($s_type=='2'){
							$th="SSCOMT_NAME_TH";
							$en="SSCOMT_NAME_EN";
						}elseif($s_type=='3'){
							$th="SSCOMP_NAME_TH";
							$en="SSCOMP_NAME_EN";
						}
						
						$name_th = $items->item($i)->getElementsByTagName($th)->item(0)->nodeValue;
						$name_en = $items->item($i)->getElementsByTagName($en)->item(0)->nodeValue;
			?>
				<tr>    
					<td align="center">
						<input type="hidden" id="name_th<?php echo $i;?>" name="name_th[<?php echo $i;?>]" value="<?php echo $name_th;?>">
						<input type="hidden" id="name_en<?php echo $i;?>" name="name_en[<?php echo $i;?>]" value="<?php echo $name_en;?>">
						<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $master_id?>">
					</td>
					<td align="center"><small><?php echo $master_id; ?></small></td>
					<td align="left"><small><?php echo $name_th; ?></small></td>
					<td align="left"><small><?php echo $name_en; ?></small></td>
				</tr>
			<?php 
						$i++;
					}
				}else{
					echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
				}
			?>
			</tbody>
		</table>
	</div>
</div>
<!--<div><?php echo $pagination;?></div>-->
<?php $db->db_close();?>
<script type="text/javascript">
	function getChk(){
		$("input[id^=chk]").each(function(){
			this.checked=$('#allchk').is(":checked");
		});
	}
	
	
	
	
	/*function searchpopup(){ //alert(); 
		var file="form_relate_popup.php";
		var url ='../../system/all/'+file;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {span:'show_display',s_file:file,page:'1',ss_type:'<?php echo $ss_type;?>',SAPA_ID:'<?php echo $SAPA_ID;?>',S_CARD:$('#S_CARD').val(),S_NAME:$('#S_NAME').val(), TYPE:'<?php echo $TYPE;?>', chk_type:'<?php echo $chk_type;?>', dec_page:'<?php echo $dec_page;?>'},
			async: false,
			success: function(data) {
				$("#show_display").html(data);
			} 
		});
	}*/
</script>