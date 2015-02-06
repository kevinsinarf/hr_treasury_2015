<?php
$path = "../../";
include($path."include/config_header_top.php");

#print_r($_GET); 

$page = $_REQUEST['page'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
$SP_IDCARD = trim($_GET['SP_IDCARD']);
$YEAR_ID = $_GET['YEAR_ID'];
$DEF_ID = $_GET['DEF_ID'];
$DEC_ID = $_GET['DEC_ID'];
$TYPE = $_GET['TYPE'];
$pos = $_GET['pos'];

$filter = "";
if($S_CARD != ""){
	$filter .= " and SP_IDCARD = '".ctext($S_CARD)."' ";
}
if($S_NAME != ""){
	$filter .= searchName("SP_FIRSTNAME_TH","SP_MIDNAME_TH","SP_LASTNAME_TH",ctext($S_NAME));
}
if($sta_public!=""){
    $filter .= "and SP_STATUS_PUBLIC = '".$sta_public."' ";   
}
if($pos!=""){
    $filter .= "and SPPOSTYPE_ID = '".$pos."' ";
}

$field="*";
$table="V_SP_LIST";
$pk_id="SP_ID";
$wh="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' {$not} {$filter}";
$orderby="order by SP_FIRSTNAME_TH, SP_MIDNAME_TH, SP_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
$nums=$db->db_num_rows($exc);
?>
<input type="hidden" id="YEAR_ID" name="YEAR_ID" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="DEF_ID" name="DEF_ID" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="DEC_ID" name="DEC_ID" value="<?php echo $DEC_ID;?>">
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['idcard'];?></div>
	<div class="col-xs-12 col-md-6">
		<input type="text" id="S_CARD" name="S_CARD" class="form-control" placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $S_CARD; ?>">
	</div>
	</div>
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $S_NAME; ?>"></div>
    <button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button>

</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center"><small>เลือก</small><br><?php if($TYPE=='dec'){?><input type="checkbox" id="allchk" name="allchk" value="1" onClick="allChk();"><?php }?></div></th> 
				<th width="20%"><div align="center"><small><?php echo $arr_txt['idcard'];?></small></div></th>
				<th width="45%"><div align="center"><small><?php echo $arr_txt['name'];?></small></div></th>
				
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					//func แสดงข้อมูลชื่อ
					$name=Showname($rec["PREFIX_ID"],$rec["SP_FIRSTNAME_TH"],$rec["SP_MIDNAME_TH"],$rec["SP_LASTNAME_TH"]);
					$patty_name=text($rec["PARTY_NAME_TH"]);

					//SP_IDCARD
					$SP_IDCARD=substr($rec['SP_IDCARD'],0,1)."-".substr($rec['SP_IDCARD'],1,4)."-".substr($rec['SP_IDCARD'],5,5)."-".substr($rec['SP_IDCARD'],10,2)."-".substr($rec['SP_IDCARD'],12,1);
                                        $POSTYPE = text($rec['SPPOSTYPE_NAME_TH']);
                                        $SPGROUP = text($rec['SPGROUP_NAME_TH']);
                                        $SPPOS = text($rec['SPPOS_NAME_TH']);
                                        ?>
			<tr>
				<td align="center">
					<?php if($TYPE=='dec'){?>
						<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $rec['SP_ID']?>">
					<?php } else {?>
						<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['SP_ID']?>');">
					<?php } ?>
					<input type="hidden" id="f1_<?php echo $rec['SP_ID'];?>" name="f1[<?php echo $rec['SP_ID'];?>]" value="<?php echo $SP_IDCARD; ?>">
					<input type="hidden" id="f2_<?php echo $rec['SP_ID'];?>" name="f2[<?php echo $rec['SP_ID'];?>]" value="<?php echo $rec["PREFIX_ID"]; ?>">
					<input type="hidden" id="f3_<?php echo $rec['SP_ID'];?>" name="f3[<?php echo $rec['SP_ID'];?>]" value="<?php echo text($rec["SP_FIRSTNAME_TH"]); ?>">
					<input type="hidden" id="f4_<?php echo $rec['SP_ID'];?>" name="f4[<?php echo $rec['SP_ID'];?>]" value="<?php echo text($rec["SP_MIDNAME_TH"]); ?>">
					<input type="hidden" id="f5_<?php echo $rec['SP_ID'];?>" name="f5[<?php echo $rec['SP_ID'];?>]" value="<?php echo text($rec["SP_LASTNAME_TH"]); ?>">
					<input type="hidden" id="f6_<?php echo $rec['SP_ID'];?>" name="f6[<?php echo $rec['SP_ID'];?>]" value="<?php echo text($rec["PARTY_ID"]); ?>">
                                        <input type="hidden" id="f_name_<?php echo $rec['SP_ID'];?>" name="f_name[<?php echo $rec['SP_ID'];?>]" value="<?php echo $name; ?>">
					<input type="hidden" id="f_type_<?php echo $rec['SP_ID'];?>" name="f_type[<?php echo $rec['SP_ID'];?>]" value="<?php echo $POSTYPE; ?>">
                                        <input type="hidden" id="f_group_<?php echo $rec['SP_ID'];?>" name="f_group[<?php echo $rec['SP_ID'];?>]" value="<?php echo $SPGROUP; ?>">
                                        <input type="hidden" id="f_pos_<?php echo $rec['SP_ID'];?>" name="f_pos[<?php echo $rec['SP_ID'];?>]" value="<?php echo $SPPOS; ?>">
                                        <input type="hidden" id="f_picture_<?php echo $rec['SP_ID'];?>" name="f_picture[<?php echo $rec['SP_ID'];?>]" value="<?php echo $rec["PIC_FILENAME"]; ?>">
				</td>
				<td align="center"><small><?php echo $rec["SP_IDCARD"]; ?></small></td>
				<td align="left"><small><?php echo $name; ?></small></td>
			
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