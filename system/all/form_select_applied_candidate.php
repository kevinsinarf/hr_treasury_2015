<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$LINE_ID = $_REQUEST['LINE_ID'];
$id_tb = $_REQUEST['id_tb'];

if(!empty($S_CAN_NO)  && ($S_CAN_NO!='undefined')){
   $ConName.=" AND APP_NO LIKE '%".ctext(trim($S_CAN_NO))."%' ";
}

$field = "APP_ID, APP_NO, PREFIX_ID, CAN_FIRSTNAME_TH, CAN_LASTNAME_TH, APP_STATUS_CIVIL";
$table = "APPLIED JOIN CANDIDATE_PROFILE ON CANDIDATE_PROFILE.CAN_ID = APPLIED.CAN_ID";
$pk_id = "APP_ID";
$wh = " APPLIED.DELETE_FLAG = '0' AND LINE_ID = '".$LINE_ID."' AND APP_FINAL_USED = '1' AND DATEADD(year, 2, APP_FINAL_DATE) >= '".$date_now_db."'".$ConName;
$orderby = "ORDER BY APP_FINAL_SEQ ASC";
$notin = $wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
?>

<div class="row">
	<div class="col-xs-12 col-md-4">เลขที่ผู้สมัคร</div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_CAN_NO" name="S_CAN_NO" class="form-control" placeholder="เลขที่ผู้สมัคร" value="<?php echo $S_CAN_NO;?>" ></div>
</div>
<div class="row">
<div class="col-xs-12 col-md-10" align="center">
<button type="button" class="btn btn-primary" onClick="search_pop2('form_select_applied_candidate.php','show_display2','<?php echo $id_tb;?>', '<?php echo $LINE_ID;?>', $('#S_CAN_NO').val());">ค้นหา</button>
</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center">เลือก</div></th>
				<th width="12%"><div align="center"><strong>เลขที่ผู้สมัคร</strong></div></th>
				<th width="30%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if($nums > 0){
			$i=1;
			while($rec = $db->db_fetch_array($exc)){
				$CAN_NAME = Showname($rec["PREFIX_ID"],$rec["CAN_FIRSTNAME_TH"],$rec["CAN_MIDNAME_TH"],$rec["CAN_LASTNAME_TH"]);
				?>
                <tr>
                    <td align="center"><input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['APP_ID'];?>" onClick="return_name2('<?php echo $rec['APP_ID'];?>', '<?php echo $CAN_NAME;?>', '<?php echo $id_tb;?>', '<?php echo $rec['APP_STATUS_CIVIL'];?>');"></td>
                    <td align="center"><?php echo text($rec['APP_NO']); ?></td>
                    <td align="left"><?php echo $CAN_NAME; ?></td>
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