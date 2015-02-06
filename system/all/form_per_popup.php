<?php
$path = "../../";
include($path."include/config_header_top.php");
ini_set("max_execution_time" , 160);

$page = $_REQUEST['page'];
$ss_type = $_GET['ss_type'];
$pt_type = $_GET['pt_type'];
$TYPE = $_GET['TYPE'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
//$PER_IDCARD = trim($_GET['PER_IDCARD']);
print_r($_GET);

$filter = "";
if($S_CARD != ""){
	$filter .= " and PER_IDCARD LIKE '%".ctext($S_CARD)."%' ";
}
if($S_NAME != ""){
	$filter .= searchName(ctext($S_NAME),"a.PER_ID");
}if($sta_public=='2'){
    $filter .= "and SP_STATUS_PUBLIC = '2' ";
    
}
//เงื่อนในการแสดง
if($act <='3'){
	$table_b="";
}else{//ss_sapa_position
	$table_b="join SS_SAPA_POSITION b on a.PER_ID=b.PER_ID and b.ACTIVE_STATUS='1' AND b.DELETE_FLAG='0'";
	if($ss_type=='2'){//ชุดปัจจุบัน
		$table_b.=" and b.SAPA_ID='".@key($arr_sapa)."' and b.SSP_STATUS_3='1'";
		$f_filter.= ",CONVERT(date ,b.SSP_PROMISE_DATE) as SSP_PROMISE_DATE";
	}
}

if($TYPE=='PL'){//การบันทึกข้อมูลสมาชิกสภาผู้แทนราษฎรแบบบัญชีรายชื่อ 
	$not="and a.PER_IDCARD not in (select PL_IDCARD from SS_PARTY_LIST where SAPA_ID='".$SAPA_ID."' and PL_IDCARD is not null AND  DELETE_FLAG='0' )";
}

$field="* {$f_filter}";
$table="PER_PROFILE a ".$table_b;
$pk_id="a.PER_ID";
$wh="1=1 AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' --and a.PER_ID='1' {$not} {$filter}";
$orderby="order by a.PER_FIRSTNAME_TH, (case when Rtrim(a.PER_MIDNAME_TH)!='' then a.PER_MIDNAME_TH else '' end), a.PER_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
//list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", "&S_CARD=".$S_CARD."&S_NAME=".$S_NAME."&ss_type=".$ss_type."&SAPA_ID=".$SAPA_ID."&chk_type=".$chk_type."&per_type=".$per_type,$s_file,$span,$TYPE);
$nums=$db->db_num_rows($exc);

//sapa
$sapa_number=$db->get_data_field("select SAPA_NUMBER from SS_SETUP_SAPA where SAPA_ID='".@key($arr_sapa)."'", "SAPA_NUMBER");
?>
<input type="hidden" id="ss_type" name="ss_type" value="<?php echo $ss_type;?>">
<!--เครื่องราช-->
<input type="hidden" id="YEAR_ID" name="YEAR_ID" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="DEF_ID" name="DEF_ID" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="DEC_ID" name="DEC_ID" value="<?php echo $DEC_ID;?>">
<input type="hidden" id="per_type" name="per_type" value="<?php echo $per_type;?>">

<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['idcard'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_CARD" name="S_CARD" class="form-control" placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $S_CARD; ?>"></div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $S_NAME; ?>"></div>
    <button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button>
</div>
<div class="row">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr class="info">
					<th width="5%"><div align="center"><small>เลือก</small><br><?php if($chk_type=='checkbox'){?><input type="checkbox" id="allchk" name="allchk" value="1" onClick="allChk();"><?php }?></div></th> 
					<th width="20%"><div align="center"><small><?php echo $arr_txt['idcard'];?></small></div></th>
					<th width="45%"><div align="center"><small><?php echo $arr_txt['name'];?></small></div></th>
				</tr>
			</thead>
			<tbody>
			<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($exc)){
						//func แสดงข้อมูลชื่อ
						$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
			?>
				<input type="hidden" id="f1_<?php echo $rec['PER_ID'];?>" name="f1[<?php echo $rec['PER_ID'];?>]" value="<?php echo get_idCard($rec['PER_IDCARD'],'-'); ?>">
				
				<input type="hidden" id="f_name_<?php echo $rec['PER_ID'];?>" name="f_name[<?php echo $rec['PER_ID'];?>]" value="<?php echo $name; ?>">
				
				<tr>    
					<td align="center">
						<?php if($chk_type=='checkbox'){?>
							<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $rec['PER_ID']?>">
						<?php } else {?>
							<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['PER_ID']?>');">
						<?php } ?>
					<!--<td align="center"><input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['PER_ID']?>');"></td>-->
					<td align="center"><small><?php echo get_idCard($rec["PER_IDCARD"]); ?></small></td>
					<td align="left"><small><?php echo $name; ?></small></td>
				</tr>
			<?php 
						$i++;
					}
				}else{
					echo "<tr><td align=\"center\" colspan=\"4\">".$arr_txt['data_not_found']."</td></tr>";
				}
			?>
			</tbody>
		</table>
	</div>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>
<script type="text/javascript">
	function searchpopup(){ //alert(); 
		var file="form_per_popup.php";
		var url ='../../system/all/'+file;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {span:'show_display',s_file:file,page:'1',ss_type:'<?php echo $ss_type;?>',,S_CARD:$('#S_CARD').val(),S_NAME:$('#S_NAME').val(), TYPE:'<?php echo $TYPE;?>', chk_type:'<?php echo $chk_type;?>', per_type:'<?php echo $per_type;?>'},
			async: false,
			success: function(data) {
				$("#show_display").html(data);
			} 
		});
	}
</script>


