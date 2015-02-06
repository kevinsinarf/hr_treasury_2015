<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$arr_org = GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", " DELETE_FLAG = '0' AND ACTIVE_STATUS = '1' ", "ORG_SEQ");

$filter = "";
if(count($arr_app_id) > 0){
	$filter .= " AND APP_ID NOT IN ('".implode("','",$arr_app_id)."') ";
}
if(!empty($S_NAME)  && ($S_NAME!='undefined')){
   $filter.=" AND (CAN_FIRSTNAME_TH LIKE '%".ctext(trim($S_NAME))."%' OR CAN_LASTNAME_TH LIKE '%".ctext(trim($S_NAME))."%')";
}

$field = "APP_ID, APP_NO, CAN_IDCARD, PREFIX_ID, CAN_FIRSTNAME_TH, CAN_MIDNAME_TH, CAN_LASTNAME_TH, CAN_BRITH_DATE, A.POS_ID, POS_NO, A.LINE_ID, TYPE_NAME_TH, LEVEL_NAME_TH, LINE_NAME_TH, ORG_ID_3, ORG_ID_4, POS_FRAME_SALARY, APP_STATUS_CIVIL, APPOINT_NO, APPOINT_DATE";
$table = "APPLIED A JOIN CANDIDATE_PROFILE B ON B.CAN_ID = A.CAN_ID 
		  JOIN POSITION_FRAME C ON C.POS_ID = A.POS_ID
		  JOIN SETUP_POS_TYPE F ON F.TYPE_ID = C.TYPE_ID
		  JOIN SETUP_POS_LEVEL G ON G.LEVEL_ID = C.LEVEL_ID
		  JOIN SETUP_POS_LINE D ON D.LINE_ID = C.LINE_ID
		  JOIN APPOINT_COMMAND E ON E.APPOINT_ID = A.APPOINT_ID";
$pk_id = "APP_ID";
$wh = "A.DELETE_FLAG = '0' AND APP_STATUS = '8' AND APP_STATUS_CIVIL = '1' {$filter}";
$orderby = "order by APP_FINAL_SEQ ASC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
?>
<div class="row">
	<div class="col-xs-12 col-md-3">ชื่อ-สกุล</div>
	<div class="col-xs-12 col-md-5"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="ชื่อ-สกุล" value="<?php echo $S_NAME;?>" ></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10" align="center">
    <button type="button" class="btn btn-primary" onClick="search_pop('transfer_pop.php','show_display',$('#S_NAME').val());">ค้นหา</button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr class="info">
                <th width="4%"><div align="center"><input type="checkbox" id="all_chk" name="all_chk" onclick="checkbox_all();"></div></th>
                <th width="14%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>                                                            
                <th width="20%"><div align="center"><strong>ตำแหน่งที่รับโอน</strong></div></th>
                <th width="10%" nowrap><div align="center"><strong>เลขที่คำสั่ง / วันที่ลงคำสั่ง</strong></div></th>
            </tr>
        </thead>
        <tbody >
        <?php
        if($nums > 0){
            $i = 1;
            while($rec = $db->db_fetch_array($exc)){
                $APP_NAME = Showname($rec["PREFIX_ID"],$rec["CAN_FIRSTNAME_TH"],$rec["CAN_MIDNAME_TH"],$rec["CAN_LASTNAME_TH"]);
				$APP_NAME_DETAIL = $APP_NAME.'<br><br>'.$arr_txt['idcard'].' : '.$rec['CAN_IDCARD'].'<br><br>วัน/เดือน/ปีเกิด : '.conv_date($rec['CAN_BRITH_DATE'],'short');
                $POS_DETAIL  = '<strong>เลขที่ตำแหน่ง :</strong> '.text($rec['POS_NO']);
				$POS_DETAIL .= '<br><strong>ประเภทตำแหน่ง :</strong> '.text($rec['TYPE_NAME_TH']);
                $POS_DETAIL .= '<br><strong>ตำแหน่งในสายงาน :</strong> '.text($rec['LINE_NAME_TH']);
                $POS_DETAIL .= '<br><strong>ระดับ :</strong> '.text($rec['LEVEL_NAME_TH']);
                $POS_DETAIL .= '<br><strong>สำนัก/กลุ่ม :</strong> '.text($arr_org[$rec['ORG_ID_3']]);
                $POS_DETAIL .= '<br><strong>กลุ่มงาน :</strong> '.text($arr_org[$rec['ORG_ID_4']]);
                $POS_DETAIL .= '<br><strong>เงินเดือน :</strong> '.number_format($rec['POS_FRAME_SALARY'],2);
				
                $q_sub = $db->query("SELECT APP_ID, CIVIL_ORG_ID_1, CIVIL_ORG_ID_2, CIVIL_ORG_ID_3, CIVIL_ORG_ID_4 FROM APPLIED WHERE REC_APPOINT_ID = '".$APPOINT_ID."' AND APP_ID = '".$rec['APP_ID']."'");
                $r_sub = $db->db_fetch_array($q_sub);
                ?>
                <input type="hidden" name="APP_ID[<?php echo $i;?>]" id="APP_ID_<?php echo $i;?>" value="<?php echo $rec["APP_ID"];?>">
                <input type="hidden" name="APP_NAME_DETAIL[<?php echo $i;?>]" id="APP_NAME_DETAIL_<?php echo $i;?>" value="<?php echo $APP_NAME_DETAIL;?>">
                <input type="hidden" name="POS_DETAIL[<?php echo $i;?>]" id="POS_DETAIL_<?php echo $i;?>" value="<?php echo $POS_DETAIL;?>">
                <input type="hidden" name="COMMAND[<?php echo $i;?>]" id="COMMAND_<?php echo $i;?>" value="<?php echo text($rec['APPOINT_NO']).' / '.conv_date($rec['APPOINT_DATE'],'short');?>">
                <tr>
                    <td align="center"><input type="checkbox" id="chk<?php echo $i;?>" name="chk" value="<?php echo $i;?>"></td>
                    <td align="left"><?php echo $APP_NAME_DETAIL;?></td>
                    <td align="left"><?php echo $POS_DETAIL;?></td>
                    <td align="center"><?php echo text($rec['APPOINT_NO']).' / '.conv_date($rec['APPOINT_DATE'],'short');?>&nbsp;</td>
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