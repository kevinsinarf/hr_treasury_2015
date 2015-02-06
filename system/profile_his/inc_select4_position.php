<?php

$label_type_name = $arr_txt['type_pos']; // ประเภทตำแหน่ง

if($postype_id_is==5){
	$label_type_name = "กลุ่มงาน";
}

?>

		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?PHP echo $label_type_name; ?> :</div>
			<div class="col-xs-12 col-sm-3"> 
			<?php  

//ประเภทตำแหน่ง
$arr_pos_type=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "DELETE_FLAG='0' AND TYPE_ID != 24  AND POSTYPE_ID = '".$postype_id_is."'  ", "TYPE_SEQ");
//ระดับตำแหน่ง/กลุ่มงาน
$arr_poss_level=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "DELETE_FLAG='0'  AND TYPE_ID = '".$_POST['TYPE_ID']."' AND POSTYPE_ID = '".$postype_id_is."' ", "LEVEL_SEQ");

//สายงาน
//ตำแหน่งในสายงาน
$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "DELETE_FLAG='0'  AND POSTYPE_ID = '".$postype_id_is."'  AND LG_ID = '".$_POST['LG_ID']."'", "LINE_NAME_TH","DISTINCT");

			echo GetHtmlSelect('TYPE_ID','TYPE_ID',$arr_pos_type,'ทั้งหมด',$_POST['TYPE_ID'],'onchange="getlevel(this.value,\''.$postype_id_is.'\'); getLineGroup(this.value,\''.$postype_id_is.'\'); getPosLine(this.value,\''.$postype_id_is.'\');"','','1');?>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">  ระดับ :			 </div>
			<div class="col-xs-12 col-sm-2">
             <div id="LEVEL_AREA" NAME="LEVEL_AREA" >
<span id='ss_pos_level'><?php  echo GetHtmlSelect('LEVEL_ID','LEVEL_ID',$arr_poss_level,'ทั้งหมด',$_POST['LEVEL_ID'],'','','1');?></span>
                    </div>
			</div>
        </div>
        
        
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> สายงาน :</div>
			<div class="col-xs-12 col-sm-3"> 
<?php 
//สายงาน
$arr_pos_lg=GetSqlSelectArray("LG_ID", "LG_NAME_TH", "SETUP_POS_LINE_GROUP", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$postype_id_is."'  AND TYPE_ID = '".$_POST['TYPE_ID']."' ", "LG_NAME_TH","DISTINCT");
  echo GetHtmlSelect('LG_ID','LG_ID',$arr_pos_lg,'ทั้งหมด',$_POST['LG_ID'],'onChange="GetLineGov(this.value,\''.$postype_id_is.'\');"','','1');?>
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">  ตำแหน่งในสายงาน :			 </div>
			<div class="col-xs-12 col-sm-2"><span id='ss_pos_line'> 
<?php
//ตำแหน่งในสายงาน
$arr_line_gov = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS = 1 AND DELETE_FLAG = 0 AND TYPE_ID = '".$_POST['TYPE_ID']."' AND POSTYPE_ID = '".$postype_id_is."'  ", "LINE_NAME_TH","DISTINCT");
   echo GetHtmlSelect('LINE_ID','LINE_ID',$arr_pos_line,'ทั้งหมด',$_POST['LINE_ID'],'','','1');?> </span>
			</div>
        </div>
