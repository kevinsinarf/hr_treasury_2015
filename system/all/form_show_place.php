<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page']=1;
$S_INST = $_REQUEST['S_INST'];

if($S_INST!= "" && $S_INST!="undefined"){
	$filter .= " AND a.INST_NAME LIKE '%".ctext($S_INST)."%' " ;
}//if

$field="a.*,
		b.COUNTRY_NAME_TH";
		
$table="DEV_INST_OBSERVE a LEFT JOIN
		SETUP_COUNTRY b ON b.COUNTRY_ID=a.COUNTRY_ID";

$pk_id=" a.INST_ID ";
$wh=" 1=1 ".$filter;
$orderby="ORDER BY a.INST_ID";
$notin=$wh." AND ".$pk_id." NOT IN (SELECT TOP ".($goto/2)." ".$pk_id." FROM ".$table." WHERE ".$wh." ".$orderby.") ".$orderby;

$SQL = "SELECT TOP 10 ".$field." FROM ".$table." WHERE ".$notin;
$SQLALL = "SELECT * FROM ".$table." WHERE ".$wh;

list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);

?>
<div class="row">
	<div class="col-xs-12 col-md-4">ชื่อสถานที่</div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_INST" name="S_INST" class="form-control" placeholder="ชื่อสถานที่" value="<?php echo $S_INST; ?>" ></div>
</div>
<div class="row">
<div class="col-xs-12 col-md-10" align="center">
<button type="button" class="btn btn-primary" onClick="FncLoad_Form('show_display_place','form_show_place.php','page=1&S_INST='+$('#S_INST').val());">ค้นหา</button>
</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center">เลือก</div></th>
				<th width="45%"><div align="center"><strong>ชื่อสถานที่</strong></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
		?>
			<tr>
				<td align="center">
                <input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['INST_ID'];?>" onClick="add_place('<?php echo text($rec["INST_NAME"]); ?>');"></td>
				<td align="left"><?php echo text($rec["INST_NAME"]); ?></td>
			</tr>
		<?php 
					$i++;
				}//while
			}else{
				echo "<tr><td align=\"center\" colspan=\"2\">ไม่พบข้อมูล</td></tr>";
			}//if
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>