<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);


$filter = "";
if(count($arr_app_id) > 0){
	$filter .= " AND APP_ID NOT IN ('".implode("','",$arr_app_id)."') ";
}

if(!empty($s_name_th)  && ($s_name_th!='undefined')){
   $filter.=" AND (A.PER_FIRSTNAME_TH LIKE '%".ctext(trim($s_name_th))."%' OR A.PER_LASTNAME_TH LIKE '%".ctext(trim($s_name_th))."%')";
}

$field = " A.PER_ID, A.PER_IDCARD, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, B.TYPE_NAME_TH,
C.LEVEL_NAME_TH, D.LINE_NAME_TH, E.ORG_NAME_TH AS ORG_NAME_3, G.ORG_NAME_TH AS ORG_NAME_4 ";
$table = "PER_PROFILE A 
LEFT JOIN SETUP_POS_TYPE B ON A.TYPE_ID = B.TYPE_ID
LEFT JOIN SETUP_POS_LEVEL C  ON A.LEVEL_ID = C.LEVEL_ID
LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID
LEFT JOIN SETUP_ORG E ON A.ORG_ID_3 = E.ORG_ID
LEFT JOIN SETUP_ORG G ON A.ORG_ID_4 = G.ORG_ID  ";
$pk_id = "A.PER_ID";
$wh = "A.DELETE_FLAG = '0' AND A.ACTIVE_STATUS = 1 AND A.PER_STATUS_CIVIL = 2 AND A.POSTYPE_ID = 1 {$filter}";
$orderby = "order by A.PER_FIRSTNAME_TH ASC  ";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);

?>
<div class="row">
	<div class="col-xs-12 col-md-3">ชื่อ-สกุล</div>
	<div class="col-xs-12 col-md-5"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="ชื่อ-สกุล" value="<?php echo $s_name_th;?>" ></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10" align="center">
    <button type="button" class="btn btn-primary" onClick="search_pop('form_retirement_disappear_pop_form.php','show_display',$('#S_NAME').val());">ค้นหา</button>
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
            </tr>
        </thead>
        <tbody >
        <?php

        if($nums > 0){
            $i = 1;
            while($rec = $db->db_fetch_array($exc)){
				$POS_DETAIL = "";
				
                $INFROM_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
				$POS_DETAIL .= '<strong>ประเภทตำแหน่ง :</strong> '.text($rec['TYPE_NAME_TH']);
                $POS_DETAIL .= '<br><strong>ตำแหน่งในสายงาน :</strong> '.text($rec['LINE_NAME_TH']);
                $POS_DETAIL .= '<br><strong>ระดับ :</strong> '.text($rec['LEVEL_NAME_TH']);
                $POS_DETAIL .= '<br><strong>สำนัก/กลุ่ม :</strong> '.text($rec['ORG_NAME_3']);
                $POS_DETAIL .= '<br><strong>กลุ่มงาน :</strong> '.text($rec['ORG_NAME_4']);
                ?>
                <tr>
                    <td align="center"><input type="checkbox" id="chk_<?php echo $i; ?>"  name="chk[]" value="<?php echo  $rec['PER_ID'];?>"></td>
                    <td align="center"><?php echo get_idCard($rec['PER_IDCARD']); ?></td>
                    <td align="left"><?php echo $INFROM_NAME; ?></td>
                    <td align="left"><?php echo $POS_DETAIL; ?></td>
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