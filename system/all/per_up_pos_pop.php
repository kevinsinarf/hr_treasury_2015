<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", " ACTIVE_STATUS = '1' and DELETE_FLAG = '0'", "ORG_SEQ");

$filter = "";
if(count($arr_posmove_id) > 0){
	$filter .= " AND POSMOVE_ID NOT IN ('".implode("','",$arr_posmove_id)."') ";
}

$field = "POSMOVE_ID, A.PER_ID, PREFIX_ID, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, ORG_ID_3, ORG_ID_4,
		  F.TYPE_NAME_TH, H.TYPE_NAME_TH AS TYPE_NEW, E.LEVEL_NAME_TH, C.LEVEL_NAME_TH AS LEVEL_NEW, LINE_NAME_TH, MANAGE_NAME_TH,
		  INNOVATION_NAME, INNOVATION_DESC, POSMOVE_STATUS, INNOVATION_FILE, ASSIGN_RESULT, ASSIGN_NOTE, POS_ID, POSMOVE_NEW_TYPE_ID, POSMOVE_NEW_LEVEL_ID";
$table = "PER_PROFILE A JOIN POSITION_MOVEUP B ON B.POSMOVE_PER_ID = A.PER_ID 
		  JOIN SETUP_POS_TYPE H ON H.TYPE_ID = B.POSMOVE_NEW_TYPE_ID
		  JOIN SETUP_POS_TYPE F ON F.TYPE_ID = B.POSMOVE_LAST_TYPE_ID
		  JOIN SETUP_POS_LEVEL C ON C.LEVEL_ID = B.POSMOVE_NEW_LEVEL_ID
		  JOIN SETUP_POS_LEVEL E ON E.LEVEL_ID = B.POSMOVE_LAST_LEVEL_ID
		  JOIN SETUP_POS_LINE D ON D.LINE_ID = A.LINE_ID
		  LEFT JOIN SETUP_POS_MANAGE G ON G.MANAGE_ID = A.MANAGE_ID";
$pk_id = "POSMOVE_ID";
$wh = "B.DELETE_FLAG = '0' AND PER_STATUS_MOVEUP = '1' AND ASSIGN_RESULT = '1' AND POSMOVE_STATUS = '3' AND B.POSMOVE_LAST_TYPE_ID = '".$POSCOM_LAST_TYPE_ID."' {$filter}";
$orderby = " order by E.LEVEL_SEQ ASC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$groupby.$orderby.") ".$groupby.$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr class="info">
                <th width="3%"><div align="center"><input type="checkbox" id="all_chk" name="all_chk" onclick="checkbox_all();"></div></th>
                <th width="16%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                <th width="16%"><div align="center"><strong>ตำแหน่ง</strong></div></th>
                <th width="14%"><div align="center"><strong>ตำแหน่งที่ขอเลื่อน</strong></div></th>
                <th width="14%"><div align="center"><strong>ชื่อผลงาน/รายละเอียด</strong></div></th>
                <th width="14%"><div align="center"><strong>หมายเหตุ</strong></div></th>
            </tr>
        </thead>
        <tbody >
        <?php
        if($nums > 0){
            $i = 1;
            while($rec = $db->db_fetch_array($exc)){
                $PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
				
				$POS_DETAIL  = 'เลขที่ตำแหน่ง : '.$db->get_pos_no($rec['PER_ID']);
				$POS_DETAIL .= '<br>ตำแหน่งทางการบริหาร (ถ้ามี) : '.text($rec['MANAGE_NAME_TH']);
				$POS_DETAIL .= '<br>ประเภทตำแหน่ง : '.text($rec['TYPE_NAME_TH']);
				$POS_DETAIL .= '<br>ตำแหน่งในสายงาน : '.text($rec['LINE_NAME_TH']);
				$POS_DETAIL .= '<br>ระดับ : '.text($rec['LEVEL_NAME_TH']);
				$POS_DETAIL .= "<br>สำนัก/กลุ่ม : ".text($arr_org[$rec['ORG_ID_3']]);
				$POS_DETAIL .= "<br>กลุ่มงาน : ".text($arr_org[$rec['ORG_ID_4']]);
				
				$INNOVATION_NAME = (trim($rec['INNOVATION_NAME']) != '') ? 'ชื่อผลงาน : '.text($rec['INNOVATION_NAME']) : "-";
				$INNOVATION_DESC = (trim($rec['INNOVATION_DESC']) != '') ? '<br>รายละเอียด : '.text($rec['INNOVATION_DESC']) : "-";
				$download = (trim($rec['INNOVATION_FILE']) != '') ? "<br><a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"".$path."fileupload/file_placement/".trim($rec['INNOVATION_FILE'])."\"><span class=\"glyphicon glyphicon-download\"></span> Download File</a> " : "";
			    $work = $INNOVATION_NAME.$INNOVATION_DESC;
				?>
                <input type="hidden" name="POSMOVE_ID[<?php echo $i;?>]" id="POSMOVE_ID_<?php echo $i;?>" value="<?php echo $rec["POSMOVE_ID"];?>">
                <input type="hidden" name="PER_ID[<?php echo $i;?>]" id="PER_ID_<?php echo $i;?>" value="<?php echo $rec["PER_ID"];?>">
                <input type="hidden" name="PER_NAME[<?php echo $i;?>]" id="PER_NAME_<?php echo $i;?>" value="<?php echo $PER_NAME;?>">
                <input type="hidden" name="POS_ID[<?php echo $i;?>]" id="POS_ID_<?php echo $i;?>" value="<?php echo text($rec['POS_ID']);?>">
                <input type="hidden" name="POS_DETAIL[<?php echo $i;?>]" id="POS_DETAIL_<?php echo $i;?>" value="<?php echo $POS_DETAIL;?>">
                <input type="hidden" name="TYPE_ID[<?php echo $i;?>]" id="TYPE_ID_<?php echo $i;?>" value="<?php echo text($rec['POSMOVE_NEW_TYPE_ID']);?>">
                <input type="hidden" name="LEVEL_ID[<?php echo $i;?>]" id="LEVEL_ID_<?php echo $i;?>" value="<?php echo text($rec['POSMOVE_NEW_LEVEL_ID']);?>">
                <input type="hidden" name="LEVEL[<?php echo $i;?>]" id="LEVEL_<?php echo $i;?>" value="ประเภทตำแหน่ง : <br><?php echo text($rec['TYPE_NEW']);?><br><br>ระดับตำแหน่ง : <br><?php echo text($rec['LEVEL_NEW']);?>">
                <input type="hidden" name="WORK[<?php echo $i;?>]" id="WORK_<?php echo $i;?>" value="<?php echo $work;?>">
                <input type="hidden" name="ASSIGN_NOTE[<?php echo $i;?>]" id="ASSIGN_NOTE_<?php echo $i;?>" value="<?php echo text($rec['ASSIGN_NOTE']);?>">
                <tr>
                    <td align="center"><input type="checkbox" id="chk<?php echo $i;?>" name="chk" value="<?php echo $i;?>"></td>
                    <td align="left"><?php echo $PER_NAME;?></td>
                    <td align="left"><?php echo $POS_DETAIL;?></td>
                    <td align="left">ประเภทตำแหน่ง : <br><?php echo text($rec['TYPE_NEW']);?><br><br>ระดับตำแหน่ง : <br><?php echo text($rec['LEVEL_NEW']);?></td>
                    <td align="left"><?php echo $INNOVATION_NAME.$INNOVATION_DESC.$download;?>&nbsp;</td>
                    <td align="left"><?php echo text($rec['ASSIGN_NOTE']);?>&nbsp;</td>
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