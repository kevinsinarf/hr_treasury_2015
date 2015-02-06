<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$S_NAME = $_REQUEST['S_NAME'];
$key_index = $_REQUEST['key_index'];

$filter = "";
if($S_NAME != ""){
	$filter .= " and (b.SS_FIRSTNAME_TH like '%".ctext($S_NAME)."%' OR b.SS_MIDNAME_TH like '%".ctext($S_NAME)."%' OR b.SS_LASTNAME_TH like '%".ctext($S_NAME)."%') ";
}

$field="a.*, b.SS_IDCARD, b.SS_FIRSTNAME_TH, b.SS_MIDNAME_TH, b.SS_LASTNAME_TH";
$table="SS_SAPA_POSITION a INNER JOIN SS_PROFILE b ON b.SS_ID = a.SS_ID";
$pk_id="a.SSP_ID";
$wh="1=1 AND a.DELETE_FLAG='0' AND a.ACTIVE_STATUS = '1' {$not} {$filter}";
$orderby="order by b.SS_FIRSTNAME_TH, b.SS_MIDNAME_TH, b.SS_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
$nums=$db->db_num_rows($exc);
?>
<input type="hidden" id="key_index" name="key_index" value="<?php echo $key_index ?>" >
<div class="row">
    <div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
    <div class="col-xs-12 col-md-6">
        <div class="input-group" >
            <input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $S_NAME; ?>"><span class="input-group-addon"  ><span class="glyphicon glyphicon-search" onClick="search_pop('form_ss_sapa_position_popup.php','show_display',$('#S_NAME').val(),$('#key_index').val());"></span></span>
        </div>
    </div>
</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="10%"><div align="center"><small>เลือก</small></div></th> 
				<th width="30%"><div align="center"><small><?php echo $arr_txt['idcard'];?></small></div></th>
				<th width="60%"><div align="center"><small><?php echo $arr_txt['name'];?></small></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					//func แสดงข้อมูลชื่อ
					
					$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
					//SS_IDCARD
					$SS_IDCARD=substr($rec['SS_IDCARD'],0,1)."-".substr($rec['SS_IDCARD'],1,4)."-".substr($rec['SS_IDCARD'],5,5)."-".substr($rec['SS_IDCARD'],10,2)."-".substr($rec['SS_IDCARD'],12,1);
		?>
			<tr>
				<td align="center">
					<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="return_val_ss('<?php echo $rec['SSP_ID']?>', '<?php echo $name?>', '<?php echo $key_index?>');">
				</td>
				<td align="center"><small><label id="SS_IDCARD<?php echo $i;?>" ><?php echo $rec["SS_IDCARD"]; ?></label></small></td>
				<td align="left"><small><label id="SS_NAME<?php echo $i;?>" ><?php echo $name; ?></label></small></td>
			</tr>
		<?php 
					$i++;
				}
			}else{
				echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
			}
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>