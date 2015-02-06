<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
$PER_IDCARD = $_GET['PER_IDCARD'];


$filter = "";

if($S_CARD != ""){
	$filter .= " and a.PER_IDCARD = '".ctext($S_CARD)."' ";
}
if($S_NAME != ""){
	$filter .= " and (a.PER_FIRSTNAME_TH like '%".ctext($S_NAME)."%' OR a.PER_MIDNAME_TH like '%".ctext($S_NAME)."%' OR a.PER_LASTNAME_TH like '%".ctext($S_NAME)."%') ";
}
//if($SS_IDCARD != ""){
//	$filter .= " and a.SS_IDCARD NOT IN (".($SS_IDCARD).") ";
//}


$field="a.PER_ID,a.PER_IDCARD,a.PREFIX_ID,a.PER_FIRSTNAME_TH,a.PER_MIDNAME_TH ,a.PER_LASTNAME_TH";
$table="PER_PROFILE a ";
$pk_id="a.PER_ID";
$wh=" a.DELETE_FLAG='0' {$not} {$filter}";
$orderby="order by a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

  $SQL = "select top 10 ".$field." from ".$table." where ".$notin;
 
    $SQLALL = "select * from ".$table." where ".$wh; 
	
 $ConPOST = "&S_CARD=".($S_CARD)."&S_NAME=".($S_NAME);
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,"");
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
				<th width="5%"><div align="center"><small>ลำดับ</small></div></th>
				<th width="20%"><div align="center"><small><?php echo $arr_txt['idcard'];?></small></div></th>
				<th width="45%"><div align="center"><small><?php echo $arr_txt['name'];?></small></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
					$SS_IDCARD=substr($rec['PER_IDCARD'],0,1)."-".substr($rec['PER_IDCARD'],1,4)."-".substr($rec['PER_IDCARD'],5,5)."-".substr($rec['PER_IDCARD'],10,2)."-".substr($rec['PER_IDCARD'],12,1);
		?>
			<tr>
				<td align="center">
					<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['PER_ID']?>');">
					<input type="hidden" id="f1_<?php echo $rec['PER_ID'];?>" name="f1[<?php echo $rec['PER_ID'];?>]" value="<?php echo $SS_IDCARD; ?>">  
					<input type="hidden" id="f2_<?php echo $rec['PER_ID'];?>" name="f1[<?php echo $rec['PER_ID'];?>]" value="<?php echo $rec['PER_ID']; ?>">  
				</td>
				<td align="center"><small><?php echo $rec["PER_IDCARD"]; ?></small></td>
				<td align="left"><small><?php echo $name; ?></small></td>
			</tr>
		<?php 
					$i++;
				}
			}else{
				echo "<tr><td align=\"center\" colspan=\"4\">ไม่มีข้อมูล</td></tr>";
			}
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>