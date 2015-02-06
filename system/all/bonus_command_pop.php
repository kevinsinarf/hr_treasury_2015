<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
$page = $_REQUEST['page'];
$YEAR_BDG =  $_REQUEST['YEAR_BDG'];
$ConPOST = "&YEAR_BDG=".$YEAR_BDG;

$filter = "";
if(count($arr_app_id) > 0){
	$filter .= "  ";
}

$field = "*";
$table = " BONUS_ADJUST A
              JOIN PER_PROFILE B ON A.PER_ID = B.PER_ID
		      LEFT JOIN SETUP_POS_LINE C ON A.LINE_ID = C.LINE_ID
		      ";
$pk_id = " A.BONUS_ID ";
$wh = " A.YEAR_BDG = '".$YEAR_BDG."' AND BONUS_STATUS = 1 {$filter}";
$orderby = "order by B.PER_FIRSTNAME_TH ASC";
$notin = $wh." and ".$pk_id." not in (select top $goto ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;

$SQLALL = "select * from ".$table." where ".$wh;

list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);

?>
<div class="table-responsive">
    <div class="row">ปีงบประมาณ : <?php echo $YEAR_BDG; ?></div>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr class="info">
                <th width="3%"><div align="center"><input type="checkbox" id="all_chk" name="all_chk" onclick="checkbox_all();"></div></th>
                <th width="16%"><div align="center"><strong>ชื่อ-สกุล</strong></div></th>                                                            
                <th width="16%"><div align="center"><strong>ตำแหน่งในสายงาน</strong></div></th>
                <th width="10%" nowrap><div align="center"><strong>จัดสรรส่วนพื้นฐาน</strong></div></th>
                <th width="10%" nowrap><div align="center"><strong>จัดสรรส่วนผันแปร</strong></div></th>
            </tr>
        </thead>
        <tbody >
        <?php
        if($nums > 0){
            $i = 1;
            while($rec = $db->db_fetch_array($exc)){
                $APP_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
                ?>
                <input type="hidden" name="APP_ID[<?php echo $i;?>]" id="APP_ID_<?php echo $i;?>" value="<?php echo $rec["BONUS_ID"];?>">
                <input type="hidden" name="APP_NAME[<?php echo $i;?>]" id="APP_NAME_<?php echo $i;?>" value="<?php echo $APP_NAME;?>">
                <input type="hidden" name="APP_LINE_NAME[<?php echo $i;?>]" id="APP_LINE_NAME_<?php echo $i;?>" value="<?php echo text($rec['LINE_NAME_TH']);?>">
                <input type="hidden" name="APP_BONUS_M1[<?php echo $i;?>]" id="APP_BONUS_M1_<?php echo $i;?>" value="<?php echo number_format($rec['BONUS_M1'],2);?>">
                <input type="hidden" name="APP_BONUS_M2[<?php echo $i;?>]" id="APP_BONUS_M2_<?php echo $i;?>" value="<?php echo number_format($rec['BONUS_M2'],2);?>">
                <tr>
                    <td align="center"><input type="checkbox" id="chk<?php echo $i;?>" name="chk" value="<?php echo $i;?>"></td>
                    <td align="left"><?php echo $APP_NAME;?></td>
                    <td align="left"><?php echo text($rec['LINE_NAME_TH']);?></td>
                    <td align="right"><?php echo number_format($rec['BONUS_M1'],2); ?></td>
                    <td align="right"><?php echo number_format($rec['BONUS_M2'],2); ?></td>
                </tr>
                <?php
                $i++;
            }
        }else{
            echo "<tr><td align=\"center\" colspan=\"5\">".$arr_txt['data_not_found']."</td></tr>";
        }
        ?>
      </tbody>
    </table>
</div>  
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>