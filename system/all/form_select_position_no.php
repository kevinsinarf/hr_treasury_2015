<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$APPOINT_TYPE_PERSON = $_REQUEST['APPOINT_TYPE_PERSON'];
$id_tb = $_REQUEST['id_tb'];

$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", " 1=1 ", "ORG_SEQ");

if($APPOINT_TYPE_PERSON == 1){
	$ConName = " AND POSITION_FRAME.POSTYPE_ID = '1'";
}else if($APPOINT_TYPE_PERSON == 2){
	$ConName = " AND POSITION_FRAME.POSTYPE_ID = '3'";
}
if(!empty($S_POS_NO)  && ($S_POS_NO!='undefined')){
   $ConName.=" AND POS_NO LIKE '%".ctext(trim($S_POS_NO))."%' ";
}
if(!empty($POS_ID_OLD)  && ($POS_ID_OLD!='undefined')){
   $ConPosIDOld.=" OR ( POS_STATUS = 3 AND POS_ID = '".ctext(trim($POS_ID_OLD))."' ) ";
}

$field = "POS_ID, POS_NO, TYPE_NAME_TH, LEVEL_NAME_TH, LINE_NAME_TH, POSITION_FRAME.LINE_ID, ORG_ID_3, ORG_ID_4";
$table = "POSITION_FRAME JOIN SETUP_POS_TYPE ON SETUP_POS_TYPE.TYPE_ID = POSITION_FRAME.TYPE_ID
		    JOIN SETUP_POS_LEVEL ON SETUP_POS_LEVEL.LEVEL_ID = POSITION_FRAME.LEVEL_ID
		    JOIN SETUP_POS_LINE ON SETUP_POS_LINE.LINE_ID = POSITION_FRAME.LINE_ID ";
$pk_id = "POS_ID";
$wh = " POSITION_FRAME.DELETE_FLAG = '0' AND POSITION_FRAME.ACTIVE_STATUS = '1' AND ( POS_STATUS < '3' ".$ConPosIDOld." ) ".$ConName;
$orderby = "ORDER BY POS_NO ASC";
$notin = $wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
?>
<div class="row">
	<div class="col-xs-12 col-md-4">เลขที่ตำแหน่ง</div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_POS_NO" name="S_POS_NO" class="form-control" placeholder="เลขที่ตำแหน่ง" value="<?php echo $S_POS_NO;?>" ></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10" align="center">
    <button type="button" class="btn btn-primary" onClick="search_pop('form_select_position_no.php','show_display','<?php echo $APPOINT_TYPE_PERSON;?>', '<?php echo $id_tb;?>', $('#S_POS_NO').val());">ค้นหา</button>
    </div>
</div>

<div class="table-responsive">
	<input type="hidden" name="APPOINT_TYPE_PERSON" id="APPOINT_TYPE_PERSON" value="<?php echo $APPOINT_TYPE_PERSON;?>" />
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="4%"><div align="center">เลือก</div></th>
				<th width="6%"><div align="center"><strong>เลขที่ตำแหน่ง</strong></div></th>
                <?php if($APPOINT_TYPE_PERSON == 1){?>
				<th width="12%"><div align="center"><strong>ประเภทตำแหน่ง</strong></div></th>
				<th width="12%"><div align="center"><strong>ระดับ</strong></div></th>
				<th width="14%"><div align="center"><strong>ตำแหน่งในสายงาน</strong></div></th>
                <?php }else if($APPOINT_TYPE_PERSON == 2){?>
				<th width="12%"><div align="center"><strong>ประเภทพนักงานราชการ</strong></div></th>
				<th width="12%"><div align="center"><strong>ประเภทกลุ่มงาน</strong></div></th>
				<th width="14%"><div align="center"><strong>ตำแหน่ง</strong></div></th>
                <?php } ?>
				<th width="14%"><div align="center"><strong>สังกัด/กลุ่ม</strong></div></th>
                <?php if($APPOINT_TYPE_PERSON == 1){?>
				<th width="12%"><div align="center"><strong>กลุ่มงาน</strong></div></th>
                <?php } ?>
			</tr>
		</thead>
		<tbody>
		<?php
		if($nums > 0){
			$i=1;
			while($rec = $db->db_fetch_array($exc)){
				$pos_no = 'เลขที่ตำแหน่ง : '.text($rec['POS_NO']);
				if($APPOINT_TYPE_PERSON == 1){
					$pos_detail = '<strong>ประเภทตำแหน่ง : </strong>'.text($rec['TYPE_NAME_TH']).'<br><strong>ระดับ : </strong>'.text($rec['LEVEL_NAME_TH']).'<br><strong>ตำแหน่งในสายงาน : </strong>'.text($rec['LINE_NAME_TH']).'<br><strong>สังกัด/กลุ่ม : </strong>'.text($arr_org[$rec['ORG_ID_3']]).'<br><strong>กลุ่มงาน : </strong>'.text($arr_org[$rec['ORG_ID_4']]);
				}else if($APPOINT_TYPE_PERSON == 2){
					$pos_detail = '<strong>ประเภทพนักงานราชการ : </strong>'.text($rec['TYPE_NAME_TH']).'<br><strong>ประเภทกลุ่มงาน : </strong>'.text($rec['LEVEL_NAME_TH']).'<br><strong>ตำแหน่ง : </strong>'.text($rec['LINE_NAME_TH']).'<br><strong>สังกัด/กลุ่ม : </strong>'.text($arr_org[$rec['ORG_ID_3']]);
				}
				?>
                <tr>
                    <td align="center"><input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['LINE_ID'];?>" onClick="return_name('<?php echo $rec['LINE_ID'];?>','<?php echo $pos_no;?>','<?php echo $pos_detail;?>','<?php echo $id_tb;?>','<?php echo $rec['POS_ID'];?>');"></td>
                    <td align="center"><?php echo text($rec['POS_NO']); ?></td>
                    <td align="left"><?php echo text($rec['TYPE_NAME_TH']);?>&nbsp;</td>
                    <td align="left"><?php echo text($rec['LEVEL_NAME_TH']);?>&nbsp;</td>
                    <td align="left"><?php echo text($rec["LINE_NAME_TH"]); ?></td>
                    <td align="left"><?php echo text($arr_org[$rec['ORG_ID_3']]); ?></td>
                    <?php if($APPOINT_TYPE_PERSON == 1){?>
                    <td align="left"><?php echo text($arr_org[$rec['ORG_ID_4']]); ?></td>
                    <?php } ?>
                </tr>
				<?php 
				$i++;
			}
		}else{
			echo "<tr><td align=\"center\" colspan=\"6\">ไม่พบข้อมูล</td></tr>";
		}
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>