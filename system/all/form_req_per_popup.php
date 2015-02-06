<?php
$path = "../../";
include($path."include/config_header_top.php");

//$_REQUEST
$page = $_REQUEST['page'];
$mode = $_GET['mode'];
$YEAR_ID = $_GET['YEAR_ID'];
$DEF_ID = $_GET['DEF_ID'];
$DEC_ID = $_GET['DEC_ID'];
$s_org_3 = $_GET['s_org_3'];
$s_org_4 = $_GET['s_org_4'];
$menu_sub_id = $_GET['menu_sub_id'];


$filter = "";
if($s_name != ""){
	$filter .= searchName(ctext($s_name), "a.PER_ID");
}
if($s_org_3 != ""){//สำนัก/กลุ่ม
	$filter .= " and a.ORG_ID_3 = '".ctext($s_org_3)."' ";
}
if($s_org_4 != 0){//กลุ่มงาน
	$filter .= " and a.ORG_ID_4 = '".ctext($s_org_4)."' ";
}
if($mode){//tab
	$filter.=" AND a.PT_ID='".($mode<4?$mode:'1')."'";
}
if($con_type=='1'){//ปุ่มแรก chk ตามเงื่อนไข
	$sql_cond=$db->query("select * from DEC_COND where DC_TYPE='".$mode."' and DEC_ID='".$DEC_ID."' and DELETE_FLAG='0'");
	$num_cond=$db->db_num_rows($sql_cond);
	if($num_cond=='0'){
		if($DEF_ID!=''){
			$filter.=" and 1=2";
		}else{
		
		}
	}else{
		$rec_dec=$db->db_fetch_array($sql_cond);
		if($rec_dec['DEC_NOW_ID']!=''){//เครื่องราชอิสริยาภรณ์ที่ถือครอง
			$filter.=" AND dec.DEC_ID='".$rec_dec['DEC_NOW_ID']."'";
			if($rec_dec['DEC_NOW_YEAR']!=''){//จำนวนปีที่ถือครองเครื่องราชอิสริยาภรณ์ปัจจุบัน
				if($rec_dec['BEFORE_DAY']!=''){//จำนวนวันที่ครบกำหนดก่อนวันพระราชพิธีเฉลิมพระชนม์พรรษา
					$filter.=" AND dbo.ShowAge(DATEADD(day,-".$rec_dec['BEFORE_DAY'].",dec.DEH_RECEIVE_DATE))>='".$rec_dec['DEC_NOW_YEAR']."'";
				}else{
					$filter.=" AND dbo.ShowAge(dec.DEH_RECEIVE_DATE)>='".$rec_dec['DEC_NOW_YEAR']."'";
				}
			}
			
		}
		if($rec_dec['TYPE_ID']!=''){//ประเภทตำแหน่ง
			$filter.=" AND a.TYPE_ID='".$rec_dec['TYPE_ID']."'";
		}
		if($rec_dec['LEVEL_ID']!=''){//ระดับ
			$filter.=" AND a.LEVEL_ID='".$rec_dec['LEVEL_ID']."'";
			if($rec_dec['LEVEL_YEAR']!=''){//เงินประจำตำแหน่ง
				$filter.=" AND dbo.ShowAge(pos.COM_SDATE)>='".$rec_dec['LEVEL_YEAR']."'";
			}
		}
		if($rec_dec['SALARY']!=''){//เงินเดือน
			$filter.=" AND a.PER_SALARY>='".$rec_dec['SALARY']."'";
			if($rec_dec['SALARY_YEAR']!=''){//จำนวนปีที่ได้รับเงินเดือนตามเกณฑ์
				$filter.=" AND dbo.ShowAge(sal.COM_SDATE)>='".$rec_dec['SALARY_YEAR']."'";
			}
		}
		if($rec_dec['SALARY_POSITION']!=''){//เงินประจำตำแหน่ง
			$filter.=" AND a.PER_SALARY_POSITION>='".$rec_dec['SALARY_POSITION']."'";
		}
		if($rec_dec['SYN_TYPE']!=''){//สิทธิขอพระราชทาน ฯ ปีเกษียณ
			//$filter.=" AND a.PER_SALARY_POSITION>='".$rec_dec['SALARY_POSITION']."'";
		}
		//echo $filter;
	}
}

if($mode!='4'){//ข้าราชการ
	$field="a.PER_ID, a.POS_NO, a.PREFIX_ID, a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH, a.PER_IDCARD, a.PER_DATE_BIRTH, a.PER_DATE_ENTRANCE, a.PER_DATE_RETIRE, a.PER_DATE_LEVEL, a.TYPE_ID, a.LEVEL_ID, a.LINE_ID, a.MANAGE_ID, a.PER_SALARY, a.PER_SALARY_POSITION, a.ORG_ID_3, a.ORG_ID_4, dec.DEH_ID, dec.DEC_ID, dec.DEH_RECEIVE_DATE";
	$table_b="";
	$not=" and a.PER_ID not in(select PER_ID from DECORATION_PER where REQ_YEAR='".$YEAR_ID."' and DEF_ID='".$DEF_ID."' and DEC_ID='".$DEC_ID."' and DELETE_FLAG='0')";
	$orderby="order by a.PER_FIRSTNAME_TH, (case when Rtrim(a.PER_MIDNAME_TH)!='' then a.PER_MIDNAME_TH else '' end), a.PER_LASTNAME_TH asc";
	
}else{//คู่สมรสข้าราชการชั้นผู้ใหญ่
	$field="a.PER_ID, a.POS_NO, a.PREFIX_ID, a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH, a.PER_IDCARD, a.PER_DATE_BIRTH, a.PER_DATE_ENTRANCE, a.PER_DATE_RETIRE, a.PER_DATE_LEVEL, a.TYPE_ID, a.LEVEL_ID, a.LINE_ID, a.MANAGE_ID, a.PER_SALARY, a.PER_SALARY_POSITION, a.ORG_ID_3, a.ORG_ID_4, dec.DEH_ID, dec.DEC_ID, dec.DEH_RECEIVE_DATE";
	$table_b=" join PER_MARRYHIS b on a.PER_ID=b.PER_ID and b.PMARRY_TYPE='1' and b.PMARRY_STATUS='1' and b.ACTIVE_STATUS='1' and b.DELETE_FLAG='0'";
	$not=" and a.PER_ID not in(select PER_ID from DECORATION_PER where REQ_YEAR='".$YEAR_ID."' and DEF_ID='".$DEF_ID."' and DEC_ID='".$DEC_ID."' and DELETE_FLAG='0')";
	$orderby="order by a.PER_FIRSTNAME_TH, (case when Rtrim(a.PER_MIDNAME_TH)!='' then a.PER_MIDNAME_TH else '' end), a.PER_LASTNAME_TH asc";
	
	/*if($S_CARD != ""){
		$filter .= " and b.PMAARY_IDCARD like '%".ctext($S_CARD)."%' ";
	}
	if($S_NAME != ""){
		$filter .= searchName("b.PMARRY_FIRSTNAME_TH","b.PMARRY_MIDNAME_TH","b.PMARRY_LASTNAME_TH",ctext($S_NAME));
	}
	$field="a.PER_ID, a.POS_NO, b.PMARRY_PREFIX_ID as PREFIX_ID, b.PMARRY_FIRSTNAME_TH as PER_FIRSTNAME_TH, b.PMARRY_MIDNAME_TH as PER_MIDNAME_TH, b.PMARRY_LASTNAME_TH as PER_LASTNAME_TH, b.PMAARY_IDCARD as PER_IDCARD, b.PMARRY_ID, a.TYPE_ID, a.LEVEL_ID, a.LINE_ID, a.MANAGE_ID, a.PER_SALARY, a.PER_SALARY_POSITION";
	$table_b=" join PER_MARRYHIS b on a.PER_ID=b.PER_ID and b.PMARRY_TYPE='1' and b.PMARRY_STATUS='1' and b.ACTIVE_STATUS='1' and b.DELETE_FLAG='0' ";
	$orderby="order by b.PMARRY_FIRSTNAME_TH, (case when Rtrim(b.PMARRY_MIDNAME_TH)!='' then b.PMARRY_MIDNAME_TH else '' end), b.PMARRY_LASTNAME_TH asc";*/
}

//MAIN
$table="PER_PROFILE a  ".$table_b."
LEFT JOIN PER_POSITIONHIS pos on a.PER_ID=pos.PER_ID and a.LEVEL_ID=pos.LEVEL_ID and pos.ACTIVE_STATUS='1' and pos.DELETE_FLAG='0' and pos.COM_SDATE=(select min(COM_SDATE) from PER_POSITIONHIS pos2 where pos.PER_ID=pos2.PER_ID and pos2.ACTIVE_STATUS='1' and pos2.DELETE_FLAG='0')
LEFT JOIN PER_SALARYHIS sal on a.PER_ID=sal.PER_ID and a.PER_SALARY=sal.SALARY and sal.ACTIVE_STATUS='1' and sal.DELETE_FLAG='0' and sal.COM_SDATE=(select min(COM_SDATE) from PER_SALARYHIS sal2 where sal.PER_ID=sal2.PER_ID and sal2.ACTIVE_STATUS='1' and sal2.DELETE_FLAG='0')
LEFT JOIN PER_DECORATEHIS dec on a.PER_ID=dec.PER_ID and dec.ACTIVE_STATUS='1' and dec.DELETE_FLAG='0' and dec.DEH_RECEIVE_DATE=(select max(DEH_RECEIVE_DATE) from PER_DECORATEHIS dec2 where dec2.PER_ID=dec.PER_ID and dec2.ACTIVE_STATUS='1' and dec2.DELETE_FLAG='0')";
$pk_id="a.PER_ID";
$wh="1=1 AND a.PER_STATUS='2' AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' {$filter} {$not}";//AND a.PER_ID='4' 
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
//list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", "&s_name=".$s_name."&s_org_3=".$s_org_3."&s_org_4=".$s_org_4."&ss_type=".$ss_type."&mode=".$mode."&chk_type=".$chk_type."&YEAR_ID=".$YEAR_ID."&DEF_ID=".$DEF_ID."&DEC_ID=".$DEC_ID."&menu_sub_id=".$menu_sub_id."&con_type=".$con_type,$s_file,$span,$TYPE);
$nums=$db->db_num_rows($exc);

//org3
$arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='15' ", "ORG_NAME_TH");
//org4
$arr_org4=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$s_org_3."' ", "ORG_NAME_TH");
?>
<input type="hidden" id="TYPE" name="TYPE" value="<?php echo $TYPE;?>">
<input type="hidden" id="mode" name="mode" value="<?php echo $mode;?>">
<input type="hidden" id="s_year" name="s_year" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="s_def" name="s_def" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="s_dec" name="s_dec" value="<?php echo $DEC_ID;?>">
<div class="row">
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">ปีที่ขอพระราชทาน :</div>
	<div class="col-xs-12 col-md-10"><?php echo $YEAR_ID;?></div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">ตระกูลเครื่องราช ฯ :</div>
	<div class="col-xs-12 col-md-4"><?php echo ($DEF_ID)?text($arr_def[$DEF_ID]):"-";?></div>
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">ลำดับชั้นที่ขอ :</div>
	<div class="col-xs-12 col-md-4"><?php echo text($arr_dec_name[$DEC_ID]);?></div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-2" style="white-space:nowrap"><?php echo $arr_txt['name']?> :</div>
	<div class="col-xs-12 col-md-4"><input type="text" id="s_name" name="s_name" class="form-control" value="<?php echo ($s_name);?>" placeholder="<?php echo $arr_txt['name']?>"></div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">สำนัก/กลุ่ม :</div>
	<div class="col-xs-12 col-md-4"><?php echo GetHtmlSelect('s_org_3','s_org_3',$arr_org3,'ทั้งหมด',$s_org_3,'onchange="getParent(\'parent2\',\'s_org_4\',\'\',\'ORG_ID\',\'ORG_NAME_TH\',\'SETUP_ORG\',\'ORG_PARENT_ID=\'+$(this).val(),\'ORG_NAME_TH\',\'ทั้งหมด\',\'\')"','','1','');?></div>
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">กลุ่มงาน :</div>
	<div class="col-xs-12 col-md-3"><span id='parent2'><?php echo GetHtmlSelect('s_org_4','s_org_4',$arr_org4,'ทั้งหมด',$s_org_4,'','','1','');?></span></div>
	<div class="col-xs-12 col-md-1"><button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button></div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="2%"><div align="center"><small>เลือก</small><br><?php if($TYPE=='dec'){?><input type="checkbox" id="allchk" name="allchk" value="1" onClick="allChk();"><?php }?></div></th> 
				<th width="21%"><div align="center"><small><?php echo $arr_txt['name']."<br>".$arr_txt['idcard'];?></small></div></th>
				<th width="11%" nowrap><div align="center"><small>วันเดือนปีเกิด/<br>วันที่บรรจุ/<br>วันที่ครบเกษียญ</div></th>
				<th width="19%"><div align="center"><small>ตำแหน่ง</div></th>
				<th width="16%"><div align="center"><small>สังกัด</div></th>
				<th width="15%"><div align="center"><small>เงินเดือน/<br>เงินประจำตำแหน่ง</div></th>
				<th width="16%"><div align="center"><small>ลำดับชั้นเครื่องราชฯ<br>ที่ถือครอง</div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					//func แสดงข้อมูลชื่อ
					$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
		?>
			<tr>
				<td align="center">
					<?php if($TYPE=='dec'){?>
						<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $rec['PER_ID']?>">
					<?php } else {?>
						<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['PER_ID']?>');">
					<?php } ?>
					<input type="hidden" id="f1_<?php echo $rec['PER_ID'];?>" name="f1[<?php echo $rec['PER_ID'];?>]" value="<?php echo get_idCard($rec["PER_IDCARD"]); ?>">
					<input type="hidden" id="f2_<?php echo $rec['PER_ID'];?>" name="f2[<?php echo $rec['PER_ID'];?>]" value="<?php echo $rec["PREFIX_ID"]; ?>">
					<input type="hidden" id="f3_<?php echo $rec['PER_ID'];?>" name="f3[<?php echo $rec['PER_ID'];?>]" value="<?php echo text($rec["PER_FIRSTNAME_TH"]); ?>">
					<input type="hidden" id="f4_<?php echo $rec['PER_ID'];?>" name="f4[<?php echo $rec['PER_ID'];?>]" value="<?php echo text($rec["PER_MIDNAME_TH"]); ?>">
					<input type="hidden" id="f5_<?php echo $rec['PER_ID'];?>" name="f5[<?php echo $rec['PER_ID'];?>]" value="<?php echo text($rec["PER_LASTNAME_TH"]); ?>">
					<input type="hidden" id="f_name_<?php echo $rec['PER_ID'];?>" name="f_name[<?php echo $rec['PER_ID'];?>]" value="<?php echo $name; ?>">
					<input type="hidden" id="f_marry_<?php echo $i;?>" name="f_marry[<?php echo $i;?>]" value="<?php echo $rec['PMARRY_ID']; ?>">
				</td>
				<td align="left"><small><?php echo $name."<br>(".get_idCard($rec["PER_IDCARD"]).")";?></small></td>
				<td align="left">
					<small>
						-<strong>วันเดือนปีเกิด</strong> : <?php echo conv_date($rec['PER_DATE_BIRTH'],'short'); ?><br>
						-<strong>วันที่บรรจุ</strong> : <?php echo conv_date($rec['PER_DATE_ENTRANCE'],'short'); ?><br>
						-<strong>วันที่ครบเกษียญ</strong> : <?php echo conv_date($rec['PER_DATE_RETIRE'],'short'); ?><br>
					</small>
				</td>
				<td align="left">
					<small>
						-<strong>เลขที่ตำแหน่ง</strong> : <?php echo text($rec['POS_NO']);?><br>
						-<strong>ประเภทตำแหน่ง</strong> : <?php echo text($arr_pos_type[$rec['TYPE_ID']]);?><br>
						-<strong>ระดับ</strong> : <?php echo text($arr_pos_level[$rec['LEVEL_ID']]);?><br>
						-<strong>ตำแหน่งในสายงาน</strong> : <?php echo text($arr_pos_line[$rec['LINE_ID']]);?><br>
						-<strong>ตำแหน่งทางการบริหาร</strong> : <?php echo text($arr_type_manage[$rec['MANAGE_ID']]);?><br>
						-<strong>วันที่ดำรงระดับปัจจุบัน</strong> : <?php echo conv_date($rec['PER_DATE_LEVEL'],'short'); ?><br>
					</small>
				</td>
				<td align="left">
					<small>
						-<strong>สำนัก/กลุ่ม</strong> : <?php echo text($arr_setup_org[$rec['ORG_ID_3']]);?><br>
						-<strong>กลุ่มงาน</strong> : <?php echo text($arr_setup_org[$rec['ORG_ID_4']]);?><br>
					</small>
				</td>
				<td align="right"><small><?php echo number_format($rec['PER_SALARY'],2)."/".number_format($rec['PER_SALARY_POSITION'],2);?></small></td>
				<td align="center"><small><?php echo ($rec['DEH_ID'])?text($arr_dec_name[$rec['DEC_ID']])."<br>(".conv_date($rec['DEH_RECEIVE_DATE'],'short').")":"-"; ?></small></td>
			</tr>
		<?php 
					$i++;
				}
			}else{
				echo "<tr><td align=\"center\" colspan=\"7\">ไม่พบข้อมูล</td></tr>";
			}
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>
<script type="text/javascript">
	function searchpopup(){
		var file="form_req_per_popup.php";
		var url ='../../system/all/'+file;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {span:'show_display',s_file:file,page:'1',ss_type:'<?php echo $ss_type;?>',s_name:$('#s_name').val(),s_org_3:$('#s_org_3').val(),s_org_4:$('#s_org_4').val(), TYPE:'<?php echo $TYPE;?>', chk_type:'<?php echo $chk_type;?>', YEAR_ID:'<?php echo $YEAR_ID;?>', DEF_ID:'<?php echo $DEF_ID;?>', DEC_ID:'<?php echo $DEC_ID;?>', menu_sub_id:'<?php echo $menu_sub_id;?>', mode:'<?php echo $mode;?>', con_type:'<?php echo $con_type;?>'},
			async: false,
			success: function(data) {//alert(data);
				$("#show_display").html(data);
				load_format("selectbox");
			} 
		});
	}
</script>