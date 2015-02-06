<?php
$path = "../../";
include($path."include/config_header_top.php");

//$_REQUEST
$page = $_REQUEST['page'];
$mode = $_GET['mode'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
$menu_sub_id = $_GET['menu_sub_id'];

//print_r($_REQUEST);

$filter = "";
if($S_CARD != ""){
	$filter .= " and a.PER_IDCARD like '%".ctext($S_CARD)."%' ";
}
if($S_NAME != ""){
	$filter .= searchName("a.PER_FIRSTNAME_TH","a.PER_MIDNAME_TH","a.PER_LASTNAME_TH",ctext($S_NAME));
}
$field="a.LINE_ID,a.ORG_ID_4,a.PER_ID, a.PREFIX_ID, a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH, a.PER_IDCARD";
$table_b="";
$orderby="order by a.PER_FIRSTNAME_TH, (case when Rtrim(a.PER_MIDNAME_TH)!='' then a.PER_MIDNAME_TH else '' end), a.PER_LASTNAME_TH asc";


//MAIN
$table="PER_PROFILE a ".$table_b."";
$pk_id="a.PER_ID";
$wh="1=1 AND a.PER_STATUS='2' AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' {$not} {$filter}";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
$nums=$db->db_num_rows($exc);
?>
<input type="hidden" id="TYPE" name="TYPE" value="<?php echo $TYPE;?>">
<input type="hidden" id="YEAR_ID" name="YEAR_ID" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="DEF_ID" name="DEF_ID" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="DEC_ID" name="DEC_ID" value="<?php echo $DEC_ID;?>">
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['idcard'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_CARD" name="S_CARD" class="form-control" placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $S_CARD; ?>"></div>
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
				<th width="75%"><div align="center"><small><?php echo $arr_txt['name'];?></small></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					//func แสดงข้อมูลชื่อ
					$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);

					//PER_IDCARD
					$PER_IDCARD=substr($rec['PER_IDCARD'],0,1)."-".substr($rec['PER_IDCARD'],1,4)."-".substr($rec['PER_IDCARD'],5,5)."-".substr($rec['PER_IDCARD'],10,2)."-".substr($rec['PER_IDCARD'],12,1);
                                        $LINE = text($arr_setup_line[$rec['LINE_ID']]);
                                        $ORG = text($arr_setup_org[$rec['ORG_ID_4']]);
                                                
                                        
                                        ?>
			<tr>
				<td align="center">
					<?php if($TYPE=='dec'){?>
						<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $rec['PER_ID']?>">
					<?php } else {?>
						<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['PER_ID']?>');">
					<?php } ?>
					<input type="hidden" id="f1_<?php echo $rec['PER_ID'];?>" name="f1[<?php echo $rec['PER_ID'];?>]" value="<?php echo $PER_IDCARD; ?>">
					<input type="hidden" id="f2_<?php echo $rec['PER_ID'];?>" name="f2[<?php echo $rec['PER_ID'];?>]" value="<?php echo $rec["PREFIX_ID"]; ?>">
					<input type="hidden" id="f3_<?php echo $rec['PER_ID'];?>" name="f3[<?php echo $rec['PER_ID'];?>]" value="<?php echo text($rec["PER_FIRSTNAME_TH"]); ?>">
					<input type="hidden" id="f4_<?php echo $rec['PER_ID'];?>" name="f4[<?php echo $rec['PER_ID'];?>]" value="<?php echo text($rec["PER_MIDNAME_TH"]); ?>">
					<input type="hidden" id="f5_<?php echo $rec['PER_ID'];?>" name="f5[<?php echo $rec['PER_ID'];?>]" value="<?php echo text($rec["PER_LASTNAME_TH"]); ?>">
					<input type="hidden" id="f_name_<?php echo $rec['PER_ID'];?>" name="f_name[<?php echo $rec['PER_ID'];?>]" value="<?php echo $name; ?>">
					<input type="hidden" id="f_marry_<?php echo $rec['PER_ID'];?>" name="f_marry[<?php echo $rec['PER_ID'];?>]" value="<?php echo $rec['PMARRY_ID']; ?>">
                                        <input type="hidden" id="f_line_<?php echo $rec['PER_ID'];?>" name="f_line[<?php echo $rec['PER_ID'];?>]" value="<?php echo $LINE; ?>">
					<input type="hidden" id="f_org_<?php echo $rec['PER_ID'];?>" name="f_org[<?php echo $rec['PER_ID'];?>]" value="<?php echo $ORG; ?>">
				</td>
				<td align="center"><small><?php echo $rec["PER_IDCARD"];?></small></td>
				<td align="left"><small><?php echo $name; ?></small></td>
			</tr>
		<?php 
					$i++;
				}
			}else{
				echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
			}
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>