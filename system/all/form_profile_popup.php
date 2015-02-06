<?php
$path = "../../";
include($path."include/config_header_top.php");

//print_r($_GET); exit();

$page = $_REQUEST['page'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
$SS_IDCARD = trim($_GET['SS_IDCARD']);
$TYPE = $_GET['TYPE'];

$filter = "";
if($S_CARD != ""){
	$filter .= " and a.SS_IDCARD like '%".ctext($S_CARD)."%' ";
}
if($S_NAME != ""){
	$filter .= searchName(ctext($S_NAME),"a.SS_ID");
}

if($TYPE == 'PL'){
	$not .= "and a.SS_IDCARD not in (SELECT PL_IDCARD from SS_PARTY_LIST where SAPA_ID='".@array_search(max($arr_sapa),$arr_sapa)."' and PL_IDCARD is not null AND  DELETE_FLAG='0' )";
}elseif($TYPE == 'SAPA'){
    $not .= "and a.SS_IDCARD not in (select b.SS_IDCARD from SS_PROFILE b join SS_SAPA_POSITION c on b.SS_ID=c.SS_ID and c.ACTIVE_STATUS='1' and c.DELETE_FLAG='0' where b.SS_IDCARD is not null and c.SAPA_ID='".@array_search(max($arr_sapa),$arr_sapa)."' and b.ACTIVE_STATUS='1' and b.DELETE_FLAG='0')"; 
}
$field="a.*";
$table="SS_PROFILE a";
$pk_id="a.SS_ID";
$wh="1=1 AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' {$not} {$filter}";
$orderby="order by a.SS_FIRSTNAME_TH, (case when Rtrim(SS_MIDNAME_TH)!='' then a.SS_MIDNAME_TH else '' end), a.SS_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
//print_r($_GET);
$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh; 
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
$nums=$db->db_num_rows($exc);
?>
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['idcard'];?></div>
	<div class="col-xs-12 col-md-6">
		<input type="text" id="S_CARD" name="S_CARD" class="form-control" placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $S_CARD; ?>">
	</div>
	</div>
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $S_NAME; ?>"></div>
    <button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button>

</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center"><small>เลือก</small></div></th> 
				<th width="20%"><div align="center"><small><?php echo $arr_txt['idcard'];?></small></div></th>
				<th width="45%"><div align="center"><small><?php echo $arr_txt['name'];?></small></div></th>
				<th width="30%"><div align="center"><small><?php echo $arr_txt['party'];?></small></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					//func แสดงข้อมูลชื่อ
					$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
					$patty_name=text($rec["PARTY_NAME_TH"]);

					//SS_IDCARD
					$SS_IDCARD=substr($rec['SS_IDCARD'],0,1)."-".substr($rec['SS_IDCARD'],1,4)."-".substr($rec['SS_IDCARD'],5,5)."-".substr($rec['SS_IDCARD'],10,2)."-".substr($rec['SS_IDCARD'],12,1);
		?>
			<tr>
				<td align="center">
					<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['SS_ID']?>');">
					<input type="hidden" id="f1_<?php echo $rec['SS_ID'];?>" name="f1[<?php echo $rec['SS_ID'];?>]" value="<?php echo $SS_IDCARD; ?>">
					<input type="hidden" id="f2_<?php echo $rec['SS_ID'];?>" name="f2[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["PREFIX_ID"]; ?>">
					<input type="hidden" id="f3_<?php echo $rec['SS_ID'];?>" name="f3[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_FIRSTNAME_TH"]); ?>">
					<input type="hidden" id="f4_<?php echo $rec['SS_ID'];?>" name="f4[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_MIDNAME_TH"]); ?>">
					<input type="hidden" id="f5_<?php echo $rec['SS_ID'];?>" name="f5[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_LASTNAME_TH"]); ?>">
					<input type="hidden" id="f6_<?php echo $rec['SS_ID'];?>" name="f6[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["PARTY_ID"]); ?>">
					<input type="hidden" id="f_name_<?php echo $rec['SS_ID'];?>" name="f_name[<?php echo $rec['SS_ID'];?>]" value="<?php echo $name; ?>">
				</td>
				<td align="center"><small><?php echo $rec["SS_IDCARD"]; ?></small></td>
				<td align="left"><small><?php echo $name; ?></small></td>
				<td align="left"><small><?php echo $patty_name; ?></small></td>
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
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>