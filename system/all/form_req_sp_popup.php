<?php
$path = "../../";
include($path."include/config_header_top.php");

//print_r($_GET); exit();

$page = $_REQUEST['page'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
$SP_IDCARD = trim($_GET['SP_IDCARD']);
$YEAR_ID = $_GET['YEAR_ID'];
$DEF_ID = $_GET['DEF_ID'];
$DEC_ID = $_GET['DEC_ID'];
$TYPE = $_GET['TYPE'];
$dec_page = $_GET['dec_page'];
$menu_sub_id = $_GET['menu_sub_id'];

#print_r($_GET);

$filter = "";
if($S_CARD != ""){
	$filter .= " and SP_IDCARD = '".ctext($S_CARD)."' ";
}
if($S_NAME != ""){
	$filter .= searchName("SP_FIRSTNAME_TH","SP_MIDNAME_TH","SP_LASTNAME_TH",ctext($S_NAME));
}
$pos=''; #ตำแหน่ง
if($menu_sub_id=='402'){#กรรมาธิการ
    $pos='13';
}if($menu_sub_id=='405'){#ข้าราชการฝ่ายการเมือง
    $pos='7';
}

$field="a.SP_ID,a.SP_IDCARD,a.PREFIX_ID,a.SP_FIRSTNAME_TH,a.SP_MIDNAME_TH,a.SP_LASTNAME_TH";
$table="SP_PROFILE a
join SP_MANPOWER c on a.SP_ID=c.SP_ID and c.DELETE_FLAG='0' and c.SPPOSTYPE_ID='".$pos."' and c.SPMAN_RESIGN_ID IS NULL";
$pk_id="a.SP_ID";
$wh="a.ACTIVE_STATUS='1' and a.DELETE_FLAG='0' {$filter}";
$orderby="order by a.SP_FIRSTNAME_TH, a.SP_MIDNAME_TH, a.SP_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin; 
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
$nums=$db->db_num_rows($exc);
?>
<input type="hidden" id="YEAR_ID" name="YEAR_ID" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="DEF_ID" name="DEF_ID" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="DEC_ID" name="DEC_ID" value="<?php echo $DEC_ID;?>">
<input type="hidden" id="dec_page" name="dec_page" value="<?php echo $dec_page;?>">
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