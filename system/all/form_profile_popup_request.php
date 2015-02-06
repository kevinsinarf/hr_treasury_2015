<?php
$path = "../../";
include($path."include/config_header_top.php");
ini_set("max_execution_time" , 160);

$page = $_REQUEST['page'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
$SS_IDCARD = trim($_GET['SS_IDCARD']);
$TYPE = $_GET['TYPE'];

$filter = "";
if($S_CARD != ""){
	$filter .= " and SS_IDCARD = '".ctext($S_CARD)."' ";
}
if($S_NAME != ""){
	$filter .= searchName("SS_FIRSTNAME_TH","SS_MIDNAME_TH","SS_LASTNAME_TH",ctext($S_NAME));
}

$field="*";
$table="V_SAPA_LIST";
$pk_id="SSP_ID";
$wh="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' {$not} {$filter}";
$orderby="order by SS_FIRSTNAME_TH, (case when Rtrim(SS_MIDNAME_TH)!='' then SS_MIDNAME_TH else '' end), SS_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
$nums=$db->db_num_rows($exc);

$arr_prov=GetSqlSelectArray("PROV_ID", "PROV_TH_NAME", "SETUP_PROV", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PROV_TH_NAME"); //จังหวัด
?>
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
					<th width="5%"><div align="center"><small>เลือก</small></div></th> 
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
						$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
						$party_name=text($arr_party[$rec["PARTY_ID"]]);

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
											<input type="hidden" id="f_sapa_<?php echo $rec['SS_ID'];?>" name="f_sapa[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SAPA_NUMBER"]); ?>">
						<input type="hidden" id="f_party_<?php echo $rec['SS_ID'];?>" name="f_party[<?php echo $rec['SS_ID'];?>]" value="<?php echo $party_name; ?>">
						<input type="hidden" id="f_type_<?php echo $rec['SS_ID'];?>" name="f_type[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($arr_type_ss[$rec['SS_TYPE_ID']]); ?>">
						<input type="hidden" id="n_list_<?php echo $rec['SS_ID'];?>" name="n_list[<?php echo $rec['SS_ID'];?>]" value="<?php echo ($rec['SS_TYPE_ID']=='1'?$arr_txt['borough']:$arr_txt['listroster']); ?>">
						<input type="hidden" id="f_list_<?php echo $rec['SS_ID'];?>" name="f_list[<?php echo $rec['SS_ID'];?>]" value="<?php echo ($rec['SS_TYPE_ID']=='1'?text($arr_prov[$rec['PROV_ID']])." เขต ".$rec['SSP_DISTRICT_ID']:$rec['SSP_PARTY_LIST']); ?>">
					</td>
					<td align="center"><small><?php echo $rec["SS_IDCARD"]; ?></small></td>
					<td align="left"><small><?php echo $name; ?></small></td>
					
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
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>