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

if(!empty($s_name_th)  && ($s_name_th!='undefined')){
   $filter.=" AND (INFORM_TO_FIRSTNAME LIKE '%".ctext(trim($s_name_th))."%' OR INFORM_TO_LASTNAME LIKE '%".ctext(trim($s_name_th))."%')";
}

$field = " PENALTY_ID, INFORM_TO_IDCARD, INFORM_TO_PREFIX_ID, INFORM_TO_FIRSTNAME, INFORM_TO_LASTNAME, INFORM_TO_POS_LEVEL_NAME, PENALTY_STATUS,		INFORM_TO_POS_TYPE_NAME,INFORM_TO_POS_LINE_NAME,INFORM_TO_POS_LEVEL_NAME
,INFORM_TO_ORG_NAME_3,INFORM_TO_ORG_NAME_4";
$table = "PENALTY_PETITION_FORM";
$pk_id = "PENALTY_ID";
$wh = "DELETE_FLAG = '0' AND PENALTY_STATUS = '6' OR PENALTY_STATUS = '7' {$filter}";
$orderby = "order by INFORM_TO_IDCARD ";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
$arr_penalty_status = array( '6'=>'มีคำสั่งลงโทษทางวินัยแล้ว', '7'=>'มีคำสั่งจาก ก.พ. แล้ว');
?>
<div class="row">
	<div class="col-xs-12 col-md-3">ชื่อ-สกุล</div>
	<div class="col-xs-12 col-md-5"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="ชื่อ-สกุล" value="<?php echo $s_name_th;?>" ></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10" align="center">
    <button type="button" class="btn btn-primary" onClick="search_pop('form_rule_examine_cancel_punnish_main_form.php','show_display',$('#S_NAME').val());">ค้นหา</button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr class="info">
                <th width="4%"><div align="center"><input type="checkbox" id="all_chk" name="all_chk" onclick="checkbox_all();"></div></th>
                <th width="12%"><div align="center"><strong>เลขที่ประจำตัวประชาชน</strong></div></th>                                                            
                <th width="13%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>
                <th width="25%" nowrap><div align="center"><strong>ตำแหน่ง / สังกัด</strong></div></th>
                    <th width="10%"><div align="center"><strong>ขั้นตอน</strong></div></th>                                                            
            </tr>
        </thead>
        <tbody >
        <?php

        if($nums > 0){
            $i = 1;
            while($rec = $db->db_fetch_array($exc)){
				$POS_DETAIL = "";
				$INFORM_TO_IDCARD = $APP_NAME.'<br><br>'.$arr_txt['idcard'].' : '.$rec['INFORM_TO_IDCARD'];
                $INFROM_NAME = Showname($rec["INFORM_TO_PREFIX_ID"],$rec["INFORM_TO_FIRSTNAME"],$rec["INFORM_TO_MIDNAME"],$rec["INFORM_TO_LASTNAME"]);
				$POS_DETAIL .= '<strong>ประเภทตำแหน่ง :</strong> '.text($rec['INFORM_TO_POS_TYPE_NAME']);
                $POS_DETAIL .= '<br><strong>ตำแหน่งในสายงาน :</strong> '.text($rec['INFORM_TO_POS_LINE_NAME']);
                $POS_DETAIL .= '<br><strong>ระดับ :</strong> '.text($rec['INFORM_TO_POS_LEVEL_NAME']);
                $POS_DETAIL .= '<br><strong>สำนัก/กลุ่ม :</strong> '.text($rec['INFORM_TO_ORG_NAME_3']);
                $POS_DETAIL .= '<br><strong>กลุ่มงาน :</strong> '.text($rec['INFORM_TO_ORG_NAME_4']);
                ?>
                <tr>
                    <td align="center"><input type="checkbox" id="chk_<?php echo $i; ?>"  name="chk[]" value="<?php echo  $rec['PENALTY_ID'];?>"></td>
                    <td align="center"><?php echo get_idCard($rec['INFORM_TO_IDCARD']); ?></td>
                    <td align="left"><?php echo $INFROM_NAME; ?></td>
                    <td align="left"><?php echo $POS_DETAIL; ?></td>
                    <td align="center"><?php echo $arr_penalty_status[$rec['PENALTY_STATUS']];?></td>
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