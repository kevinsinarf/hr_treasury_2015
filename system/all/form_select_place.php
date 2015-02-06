<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$s_name_th = $_REQUEST['s_name_th'];
$PT_ID = $_REQUEST['PT_ID'];
$ORG_ID_3 = $_REQUEST['ORG_ID_3'];
$ORG_ID_4 = $_REQUEST['ORG_ID_4'];

if(!empty($S_PLACE_ROOM)  && ($S_PLACE_ROOM!='undefined')){
   $ConName.=" AND PLACE_ROOM LIKE '%".ctext(trim($S_PLACE_ROOM))."%' ";
}

$field = "PLACE_ID, PLACE_BUILDING, PLACE_FLOOR, PLACE_ROOM, PLACE_AMOUNT";
$table = "ANNOUNCE_SETUP_PLACE";
$pk_id = "PLACE_ID";
$wh = " 1=1 AND DELETE_FLAG = '0' AND ACTIVE_STATUS = '1'".$ConName;
$orderby = "ORDER BY PLACE_BUILDING, PLACE_FLOOR, PLACE_ROOM ASC";
$notin = $wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
?>

<div class="row">
	<div class="col-xs-12 col-md-4">เลขที่ห้อง</div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_PLACE_ROOM" name="S_PLACE_ROOM" class="form-control" placeholder="เลขที่ห้อง" value="<?php echo $S_PLACE_ROOM;?>" ></div>
</div>
<div class="row">
<div class="col-xs-12 col-md-10" align="center">
<button type="button" class="btn btn-primary" onClick="search_pop('form_select_place.php','show_display',$('#S_PLACE_ROOM').val());">ค้นหา</button>
</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="4%"><div align="center">เลือก</div></th>
				<th width="8%"><div align="center"><strong>เลขที่ห้อง</strong></div></th>
				<th width="6%"><div align="center"><strong>ชั้น</strong></div></th>
				<th width="20%"><div align="center"><strong>อาคาร</strong></div></th>
				<th width="6%"><div align="center"><strong>จำนวนที่รองรับ</strong></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if($nums > 0){
			$i=1;
			while($rec = $db->db_fetch_array($exc)){
				$name = text($rec["PLACE_ROOM"]).' ชั้น '.text($rec["PLACE_FLOOR"]).' อาคาร '.text($rec["PLACE_BUILDING"]);
				?>
                <tr>
                    <td align="center"><input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['PLACE_ID'];?>" onClick="return_name('<?php echo $rec['PLACE_ID'];?>','<?php echo $name;?>','<?php echo $rec['PLACE_AMOUNT'];?>');"></td>
                    <td align="center"><?php echo text($rec['PLACE_ROOM']); ?></td>
                    <td align="center"><?php echo text($rec["PLACE_FLOOR"]); ?></td>
                    <td align="left"><?php echo text($rec["PLACE_BUILDING"]); ?></td>
                    <td align="center"><?php echo $rec['PLACE_AMOUNT']; ?></td>
                </tr>
				<?php 
				$i++;
			}
		}else{
			echo "<tr><td align=\"center\" colspan=\"5\">ไม่พบข้อมูล</td></tr>";
		}
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>