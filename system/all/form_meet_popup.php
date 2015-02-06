<?php
$path = "../../";
include($path."include/config_header_top.php");
ini_set("max_execution_time" , 160);

$page = $_REQUEST['page'];
$ss_type = $_GET['ss_type'];
//$TYPE = $_GET['TYPE'];
//$S_CARD = $_GET['S_CARD'];
//$S_NAME = $_GET['S_NAME'];
//$SS_IDCARD = trim($_GET['SS_IDCARD']);
//print_r($_REQUEST);

/*$filter = "";
if($S_CARD != ""){
	$filter .= " and SS_IDCARD LIKE '%".ctext($S_CARD)."%' ";
}
if($S_NAME != ""){
	$filter .= searchName(ctext($S_NAME),"a.SS_ID");
}*/

$field="*";
$table="SS_MEETING a join SS_SETUP_SAPA b on a.SAPA_ID=b.SAPA_ID ";
$pk_id="a.MEETING_ID";
$wh="1=1 AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' and a.SAPA_ID='".@key($arr_sapa)."' {$not} {$filter}";
$orderby="order by a.MEETING_SEQ desc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
//list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", "&S_CARD=".$S_CARD."&S_NAME=".$S_NAME,$s_file,$span,$filter);
$nums=$db->db_num_rows($exc);
?>
<!--<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['idcard'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_CARD" name="S_CARD" class="form-control" placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $S_CARD; ?>"></div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $S_NAME; ?>"></div>
    <button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button>
</div>-->
<div class="row">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr class="info">
					<th width="5%"><div align="center"><small>เลือก</small></div></th> 
					<th width="10%"><div align="center"><small>สภาชุดที่</small></div></th>
					<th width="25%"><div align="center"><small>ประเภทการประชุม</small></div></th>
					<th width="10%"><div align="center"><small>ปีที่ของชุดสภา</small></div></th>
					<th width="10%"><div align="center"><small>การประชุมครั้งที่</small></div></th>
					<th width="15%"><div align="center"><small><?php echo $arr_txt['meet_type']?></small></div></th>
					<th width="15%"><div align="center"><small><?php echo $arr_txt['meet_subtype']?></small></div></th>
				</tr>
			</thead>
			<tbody>
			<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($exc)){
			?>
				<input type="hidden" id="f2_<?php echo $rec['MEETING_ID'];?>" name="f2[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo $rec['SAPA_NUMBER'];?>">
				<input type="hidden" id="f3_<?php echo $rec['MEETING_ID'];?>" name="f3[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo text($arr_atttype[$rec['ATTENTYPE_ID']]);?>">
				<input type="hidden" id="f4_<?php echo $rec['MEETING_ID'];?>" name="f4[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo $rec['MEETING_YEAR_2'];?>">
				<input type="hidden" id="f5_<?php echo $rec['MEETING_ID'];?>" name="f5[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo $rec['MEETING_SEQ'];?>">
				<input type="hidden" id="f6_<?php echo $rec['MEETING_ID'];?>" name="f6[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo text($arr_type[$rec['TYPE_ID']]);?>">
				<input type="hidden" id="f7_<?php echo $rec['MEETING_ID'];?>" name="f7[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo text($arr_stype[$rec['SUBTYPE_ID']]);?>">
				<input type="hidden" id="f8_<?php echo $rec['MEETING_ID'];?>" name="f8[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo conv_date($rec['MEETING_SDATE'],'short');?>">
				<input type="hidden" id="f9_<?php echo $rec['MEETING_ID'];?>" name="f9[<?php echo $rec['MEETING_ID'];?>]" value="<?php echo conv_date($rec['MEETING_EDATE'],'short');?>">
				<tr>    
					<td align="center"><input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['MEETING_ID']?>');">
					<td align="center"><small><?php echo $rec["SAPA_NUMBER"]; ?></small></td>
					<td align="left"><small><?php echo text($arr_atttype[$rec['ATTENTYPE_ID']]);?></small></td>
					<td align="center"><small><?php echo $rec['MEETING_YEAR_2']; ?></small></td>
					<td align="center"><small><?php echo $rec['MEETING_SEQ']; ?></small></td>
					<td align="left"><small><?php echo text($arr_type[$rec['TYPE_ID']]);?></small></td>
					<td align="left"><small><?php echo text($arr_stype[$rec['SUBTYPE_ID']]);?></small></td>
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