<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$tb_id = $_REQUEST['tb_id'];
$POSTYPE_ID = $_REQUEST['POSTYPE_ID'];
$S_POS_NO = $_REQUEST['S_POS_NO'];

if(!empty($S_POS_NO)  && ($S_POS_NO!='undefined')){
   $Cond.=" AND POSITION_FRAME.POS_NO = '".ctext(trim($S_POS_NO))."' ";
}
if(!empty($POSTYPE_ID)  && ($POSTYPE_ID!='undefined')){
   $Cond.=" AND POSITION_FRAME.POSTYPE_ID = '".ctext(trim($POSTYPE_ID))."' ";
}
if(!empty($POS_ID_OLD)  && ($POS_ID_OLD!='undefined')){
   $ConPosIDOld.=" OR ( POSITION_FRAME.POS_STATUS = 3 AND POSITION_FRAME.POS_ID = '".ctext(trim($POS_ID_OLD))."' ) ";
}

$field = "POSITION_FRAME.POS_ID, POSITION_FRAME.POS_NO, TYPE_NAME_TH, LEVEL_NAME_TH, LINE_NAME_TH, POSITION_FRAME.LINE_ID";
$table = "POSITION_FRAME 
	LEFT JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = POSITION_FRAME.TYPE_ID 
	LEFT JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = POSITION_FRAME.LEVEL_ID 
	LEFT JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = POSITION_FRAME.LINE_ID 
	";
$pk_id = "POSITION_FRAME.POS_ID";
$wh = " 1=1 AND POSITION_FRAME.DELETE_FLAG = '0' AND POSITION_FRAME.ACTIVE_STATUS = '1' AND POSITION_FRAME.POSTYPE_ID = '".$POSTYPE_ID."' AND ( POSITION_FRAME.POS_STATUS < '3' ".$ConPosIDOld." ) ".$Cond;
$orderby = "ORDER BY POSITION_FRAME.POS_NO ASC";
$notin = $wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);

if($POSTYPE_ID=="3"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
	$TXT_TYPE = "ประเภทพนักงานราชการ";
	$TXT_LEVEL = "ประเภทกลุ่มงาน";
	$TXT_LINE = "ตำแหน่ง";
}elseif($POSTYPE_ID=="5"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
	$TXT_TYPE = "กลุ่มงาน";
	$TXT_LEVEL = "ระดับ";
	$TXT_LINE = "ตำแหน่งในสายงาน";
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
	$TXT_TYPE = "ประเภทตำแหน่ง";
	$TXT_LEVEL = "ระดับตำแหน่ง";
	$TXT_LINE = "ตำแหน่งในสายงาน";
}
?>
<div class="row">
	<div class="col-xs-12 col-md-4">เลขที่ตำแหน่ง</div>
	<div class="col-xs-12 col-md-3"><input type="text" id="S_POS_NO" name="S_POS_NO" class="form-control" placeholder="เลขที่ตำแหน่ง" value="<?php echo $S_POS_NO;?>" ></div>

    <button type="button" class="btn btn-primary" onClick="search_pop2('form_select_position_no_plac_app.php','show_display2','<?php echo $tb_id;?>', $('#S_POS_NO').val(), '<?php echo $POSTYPE_ID;?>');">ค้นหา</button>
</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center">เลือก</div></th>
				<th width="15%"><div align="center"><strong>เลขที่ตำแหน่ง</strong></div></th>
				<th width="25%"><div align="center"><strong><?php echo $TXT_TYPE; ?></strong></div></th>
				<th width="25%"><div align="center"><strong><?php echo $TXT_LEVEL;?></strong></div></th>
                <th width="30%"><div align="center"><strong><?php echo $TXT_LINE;?></strong></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if($nums > 0){
			$i=1;
			while($rec = $db->db_fetch_array($exc)){
				$name = text($rec['POS_NO']);
				?>
                <tr>
                    <td align="center"><input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['LINE_ID'];?>" onClick="return_position('<?php echo $rec['LINE_ID'];?>','<?php echo $name;?>','<?php echo $tb_id;?>','<?php echo $rec['POS_ID'];?>');"></td>
                    <td align="center"><?php echo text($rec['POS_NO']); ?></td>
                    <td align="left"><?php echo text($rec['TYPE_NAME_TH']);?>&nbsp;</td>
                    <td align="left"><?php echo text($rec["LEVEL_NAME_TH"]); ?></td>
                    <td align="left"><?php echo text($rec["LINE_NAME_TH"]); ?></td>
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