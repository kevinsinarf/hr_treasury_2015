<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$S_NAME = $_REQUEST['S_NAME'];
$key_index = $_REQUEST['key_index'];

$arr_org = GetSqlSelectArray("ORG_ID","ORG_NAME_TH","SETUP_ORG"," ACTIVE_STATUS=1 AND DELETE_FLAG = '0' ","ORG_SEQ" );
$filter = "";
if($S_NAME != ""){
	$filter .= " and (a.PER_FIRSTNAME_TH like '%".ctext($S_NAME)."%' OR a.PER_MIDNAME_TH like '%".ctext($S_NAME)."%' OR a.PER_LASTNAME_TH like '%".ctext($S_NAME)."%') ";
}

if(count($arr_perid) > 0){
	$filter .= " and PER_ID NOT IN ('".implode("','",$arr_perid)."') ";
}

if($PER_STATUS_PROBATION != ""){
	$filter .= " and PER_STATUS_PROBATION = '".$PER_STATUS_PROBATION."' ";
}

$field="a.PER_ID, a.PER_IDCARD, a.PREFIX_ID, a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH, a.PER_DATE_BIRTH, 
		b.POS_NO, d.LINE_NAME_TH, e.TYPE_NAME_TH, f.LEVEL_NAME_TH, a.ORG_ID_3, a.ORG_ID_4 ";
$table="PER_PROFILE a 
		LEFT JOIN POSITION_FRAME b ON b.POS_ID = a.POS_ID 
		LEFT JOIN SETUP_POS_LINE d ON d.LINE_ID = a.LINE_ID 
		LEFT JOIN SETUP_POS_TYPE e ON e.TYPE_ID = a.TYPE_ID
		LEFT JOIN SETUP_POS_LEVEL f ON f.LEVEL_ID = a.LEVEL_ID
		";
$pk_id="a.PER_ID";
$wh="1=1 AND a.DELETE_FLAG='0' AND a.ACTIVE_STATUS = '1' AND PT_ID = '1' {$not} {$filter}";
$orderby="order by a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
?>
<input type="hidden" id="key_index" name="key_index" value="<?php echo $key_index ?>" >
<input type="hidden" id="PER_STATUS_PROBATION" name="PER_STATUS_PROBATION" value="<?php echo $PER_STATUS_PROBATION ?>" >
<div class="row">
    <div class="col-xs-12 col-md-3"><?php echo $arr_txt['name'];?></div>
    <div class="col-xs-12 col-md-4">
        <div class="input-group" >
            <input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $S_NAME; ?>"><span class="input-group-addon"  ><span class="glyphicon glyphicon-search" onClick="search_pop('form_PER_profile_popup.php','show_display',$('#S_NAME').val(),$('#key_index').val());"></span></span>
        </div>
    </div>
</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center"><small>เลือก&nbsp;<input type="checkbox" id="chk_all" name="chk_all" onclick="checkbox_all();"></small></div></th> 
				<th width="16%"><div align="center"><small><?php echo $arr_txt['name'];?></small></div></th>
                <th width="24%"><div align="center"><small>ตำแหน่ง</small></div></th>
				<?php if($PER_STATUS_PROBATION > 1){?>
                <th width="12%"><div align="center"><strong>ผลประเมินครั้งที่ 1</strong></div></th>
                <?php } ?>
                <?php if($PER_STATUS_PROBATION > 2){?>
                <th width="12%"><div align="center"><strong>ผลประเมินครั้งที่ 2</strong></div></th>
                <?php } ?> 
			</tr>
		</thead>
		<tbody>
		<?php
		if($nums > 0){
			$i=1;
			$arr_pro_result = array(1=>"ผ่าน", 2=>"ไม่ผ่าน");
			while($rec = $db->db_fetch_array($exc)){
				$name = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
				$PER_IDCARD = get_idCard($rec['PER_IDCARD']);
				$PER_NAME = $name;
				$PER_NAME .= "<br><br>".$arr_txt['idcard']." : <br>".$PER_IDCARD;
				$PER_NAME .= "<br><br>วัน/เดือน/ปีเกิด : ".conv_date($rec['PER_DATE_BIRTH'],'short');
				
				$POS_DETAIL  = "เลขที่ตำแหน่ง : ".text($rec['POS_NO']);
				$POS_DETAIL .= "<br>ตำแหน่งทางการบริหาร(ถ้ามี) : ".text($rec['MANAGE_NAME_TH']);
				$POS_DETAIL .= "<br>ประเภทตำแหน่ง : ".text($rec['TYPE_NAME_TH']);
				$POS_DETAIL .= "<br>ตำแหน่งในสายงาน : ".text($rec['LINE_NAME_TH']);
				$POS_DETAIL .= "<br>ระดับ : ".text($rec['LEVEL_NAME_TH']);
				$POS_DETAIL .= "<br>".text($arr_org[$rec['ORG_ID_3']]);
				$POS_DETAIL .= "<br>".text($arr_org[$rec['ORG_ID_4']]);
				
				if($PER_STATUS_PROBATION >= 2 || $PER_STATUS_PROBATION == 4){
					$r_pro1 = $db->get_data_rec("SELECT PRO_RESULT, PRO_COMMENT FROM PER_PROBATION WHERE PER_ID = '".$rec['PER_ID']."' AND PRO_SEQ = 1");
					$PRO1 = "<lable id=\"PRO_1".$i."\">".$arr_pro_result[$r_pro1['PRO_RESULT']]."<br>หมายเหตุ : ".text($r_pro1['PRO_COMMENT'])."</lable>";
				}else{
					$PRO1 = "<lable id=\"PRO_1".$i."\"></lable>";
				}
				if($PER_STATUS_PROBATION == 3 || $PER_STATUS_PROBATION == 4){
					$r_pro2 = $db->get_data_rec("SELECT PRO_RESULT, PRO_COMMENT FROM PER_PROBATION WHERE PER_ID = '".$rec['PER_ID']."' AND PRO_SEQ = 2");
					$PRO2 = "<lable id=\"PRO_2".$i."\">".$arr_pro_result[$r_pro2['PRO_RESULT']]."<br>หมายเหตุ : ".text($r_pro2['PRO_COMMENT'])."</lable>";
				}else{
					$PRO2 = "<lable id=\"PRO_2".$i."\"></lable>";
				}
				?>
				<tr>
					<td align="center">
                    <input type="checkbox" id="chk<?php echo $i;?>" name="chk" value="<?php echo $i;?>">
                    <input type="hidden" id="POP_PER_ID<?php echo $i;?>" value="<?php echo $rec["PER_ID"];?>">
					</td>
					<td align="left"><label id="POP_PER_NAME<?php echo $i;?>" ><?php echo $PER_NAME; ?></label></td>
					<td align="left"><label id="POP_POS_NO_NAME<?php echo $i;?>" ><?php echo $POS_DETAIL; ?></label></td>
					<?php if($PER_STATUS_PROBATION > 1){?>
                    <td align="left"><?php echo $PRO1;?></td>
					<?php } ?>
                    <?php if($PER_STATUS_PROBATION > 2){?>
                    <td align="left"><?php echo $PRO2;?></td>
					<?php } ?>
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