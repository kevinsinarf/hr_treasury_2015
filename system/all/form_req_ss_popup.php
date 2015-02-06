<?php
$path = "../../";
include($path."include/config_header_top.php");

//$_REQUEST
$page = $_REQUEST['page'];
$mode = $_GET['mode'];
$YEAR_ID = $_GET['YEAR_ID'];
$DEF_ID = $_GET['DEF_ID'];
$DEC_ID = $_GET['DEC_ID'];
$POLPOS_ID = $_GET['POLPOS_ID'];
$s_org_3 = $_GET['s_org_3'];
$s_org_4 = $_GET['s_org_4'];
$menu_sub_id = $_GET['menu_sub_id'];

$filter = "";
if($s_name != ""){
	$filter .= searchName(ctext($s_name), "a.SS_ID");
}
/*if($s_org_3 != ""){//สำนัก/กลุ่ม
	$filter .= " and a.ORG_ID_3 = '".ctext($s_org_3)."' ";
}
if($s_org_4 != 0){//กลุ่มงาน
	$filter .= " and a.ORG_ID_4 = '".ctext($s_org_4)."' ";
}*/
if($mode){//tab
	if($mode=='1' || $mode=='4'){
		$filter.=" AND a.SSP_ID in (select SSP_ID from SS_POLITICSHIS where DELETE_FLAG='0' and RESIGN_COM_DATE is null)";
	}elseif($mode=='2'){
		$filter.=" AND a.SSP_ID in (select SSP_ID from SS_COMMISSIONHIS where SSCOMP_ID='2' and DELETE_FLAG='0' and RESIGN_COM_DATE is null)";
	}elseif($mode=='3'){
		//$filter.=" AND a.SSP_ID in (select SSP_ID from SS_COMMISSIONHIS where SSCOMP_ID='2' and DELETE_FLAG='0' and RESIGN_COM_DATE is null)";
	}
}
if($con_type=='1'){//ปุ่มแรก chk ตามเงื่อนไข
	//echo "select * from DEC_COND where DECCON_TYPE='2' and BEG_DEC_ID='".$DEC_ID."' and DELETE_FLAG='0'";
	$cond_2=($mode=='1' || $mode=='4'?" and POLPOS_ID='".$POLPOS_ID."'":"");
	//echo "select * from DEC_COND where DECCON_TYPE='2' and DECCON_PERSON='".$mode."' and BEG_DEC_ID='".$DEC_ID."' ".$cond_2." and DELETE_FLAG='0'";
	$sql_cond=$db->query("select * from DEC_COND where DECCON_TYPE='2' and DECCON_PERSON='".$mode."' and BEG_DEC_ID='".$DEC_ID."' ".$cond_2." and DELETE_FLAG='0'");
	$num_cond=$db->db_num_rows($sql_cond);
	if($num_cond=='0'){
		if($DEF_ID!=''){
			$filter.=" and 1=2";
		}else{
		
		}
	}else{
		$rec_dec=$db->db_fetch_array($sql_cond);
		if($rec_dec['DECCON_DEC_ID']!=''){//เครื่องราชอิสริยาภรณ์ที่ถือครอง
			$filter.=" AND dec.DEC_ID='".$rec_dec['DECCON_DEC_ID']."'";
			if($rec_dec['DECCON_YEAR_DEC']!=''){//จำนวนปีที่ถือครองเครื่องราชอิสริยาภรณ์ปัจจุบัน
				$filter.=" AND dbo.ShowAge(dec.SDEH_RECEIVE_DATE)>='".$rec_dec['DECCON_YEAR_DEC']."'";
			}
		}
		if($rec_dec['POLPOS_ID']!=''){//จำนวนปีที่ถือครองเครื่องราชอิสริยาภรณ์ปัจจุบัน
			$filter.=" AND pol.POLPOS_ID='".$rec_dec['POLPOS_ID']."'";
		}
		//echo $filter;
	}
}

if($mode<='3'){//ไม่ใช่คู่สมรส
	$field="a.SS_ID, a.SSP_ID,a.SAPA_ID, a.SSP_NUMBER, b.PREFIX_ID, b.SS_FIRSTNAME_TH, b.SS_MIDNAME_TH, b.SS_LASTNAME_TH, b.SS_IDCARD, b.SS_BIRTH_DATE,a.SS_TYPE_ID,a.SSP_PARTY_LIST,a.PROV_ID,a.SSP_DISTRICT_ID,CONVERT(date,a.SSP_PROMISE_DATE) AS PROMISE_DATE,a.SSP_TERMINATE_DATE,a.SSP_MORE,a.SSP_POSITION,b.PARTY_ID, dec.SDEH_ID, dec.DEC_ID, dec.SDEH_RECEIVE_DATE";
	//, dec.DECHIS_ID, dec.DEC_ID, dec.GAZETTE_DATE
	$table_c="";
	$not=" and a.SSP_ID not in(select SSP_ID from DECORATION_SS where REQ_YEAR='".$YEAR_ID."' and REQ_DEC_ID='".$DEC_ID."' and DELETE_FLAG='0')";
	$orderby="order by b.SS_FIRSTNAME_TH, (case when Rtrim(b.SS_MIDNAME_TH)!='' then b.SS_MIDNAME_TH else '' end), b.SS_LASTNAME_TH asc";
}else{//คู่สมรส
	$field="a.SS_ID, a.SSP_ID,a.SAPA_ID, a.SSP_NUMBER,b.PREFIX_ID, b.SS_FIRSTNAME_TH, b.SS_MIDNAME_TH, b.SS_LASTNAME_TH,c.MARRY_PREFIX_ID, c.MARRY_FIRSTNAME_TH, c.MARRY_MIDNAME_TH, c.MARRY_LASTNAME_TH, b.SS_IDCARD, b.SS_BIRTH_DATE,a.SS_TYPE_ID,a.SSP_PARTY_LIST,a.PROV_ID,a.SSP_DISTRICT_ID,CONVERT(date,a.SSP_PROMISE_DATE) AS PROMISE_DATE,a.SSP_TERMINATE_DATE,a.SSP_MORE,a.SSP_POSITION,b.PARTY_ID, dec.SDEH_ID, dec.DEC_ID, dec.SDEH_RECEIVE_DATE";
	$table_c=" join SS_MARRYHIS c on a.SS_ID=c.SS_ID and c.MARRY_TYPE='1' and c.MARRY_STATUS='1' and c.ACTIVE_STATUS='1' and c.DELETE_FLAG='0'";
	$not=" and a.SS_ID not in(select SS_ID from DECORATION_SS where REQ_YEAR='".$YEAR_ID."' and DEF_ID='".$DEF_ID."' and DEC_ID='".$DEC_ID."' and DELETE_FLAG='0')";
	$orderby="order by b.SS_FIRSTNAME_TH, (case when Rtrim(b.SS_MIDNAME_TH)!='' then b.SS_MIDNAME_TH else '' end), b.SS_LASTNAME_TH asc";
}

//MAIN
$table="SS_SAPA_POSITION a  
join SS_PROFILE b on a.SS_ID=b.SS_ID ".$table_c."
LEFT JOIN SS_DECORATEHIS dec on a.SS_ID=dec.SS_ID and dec.DELETE_FLAG='0' and dec.SDEH_RECEIVE_DATE=(select max(SDEH_RECEIVE_DATE) from SS_DECORATEHIS dec2 where dec2.SS_ID=dec.SS_ID and dec2.ACTIVE_STATUS='1' and dec2.DELETE_FLAG='0')
LEFT JOIN SS_POLITICSHIS pol on a.SS_ID=pol.SS_ID and dec.DELETE_FLAG='0' and pol.ASSIGN_COM_SDATE=(select min(pol2.ASSIGN_COM_SDATE) from SS_POLITICSHIS pol2 where pol.SS_ID=pol2.SS_ID and dec.DELETE_FLAG='0') ";
$pk_id="a.SSP_ID";
$wh="1=1 AND a.SAPA_ID='".@key($arr_sapa)."' AND a.SSP_STATUS_3='1' AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' {$filter} {$not}";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", "&s_name=".$s_name."&s_org_3=".$s_org_3."&s_org_4=".$s_org_4."&ss_type=".$ss_type."&mode=".$mode."&chk_type=".$chk_type."&YEAR_ID=".$YEAR_ID."&DEF_ID=".$DEF_ID."&DEC_ID=".$DEC_ID."&menu_sub_id=".$menu_sub_id."&con_type=".$con_type,$s_file,$span,$TYPE);
$nums=$db->db_num_rows($exc);
?>
<input type="hidden" id="TYPE" name="TYPE" value="<?php echo $TYPE;?>">
<input type="hidden" id="mode" name="mode" value="<?php echo $mode;?>">
<input type="hidden" id="s_year" name="s_year" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="s_def" name="s_def" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="s_dec" name="s_dec" value="<?php echo $DEC_ID;?>">
<div class="row">
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">ปีที่ขอพระราชทาน :</div>
	<div class="col-xs-12 col-md-4"><?php echo $YEAR_ID;?></div>
        <?php if ($mode == 1 || $mode == 4) { ?>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap">ตำแหน่งทางการเมือง :</div>
        <div class="col-xs-12 col-md-4"><?php echo text($arr_type_pol[$POLPOS_ID]);?></div>
        <?php } ?>
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
	<div class="col-xs-12 col-md-1"><button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button></div>
</div><?php /*
<div class="row">
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">สำนัก/กลุ่ม :</div>
	<div class="col-xs-12 col-md-4"><?php echo GetHtmlSelect('s_org_3','s_org_3',$arr_org3,'ทั้งหมด',$s_org_3,'onchange="getParent(\'parent2\',\'s_org_4\',\'\',\'ORG_ID\',\'ORG_NAME_TH\',\'SETUP_ORG\',\'ORG_PARENT_ID=\'+$(this).val(),\'ORG_NAME_TH\',\'ทั้งหมด\',\'\')"','','1','');?></div>
	<div class="col-xs-12 col-md-2" style="white-space:nowrap">กลุ่มงาน :</div>
	<div class="col-xs-12 col-md-3"><span id='parent2'><?php echo GetHtmlSelect('s_org_4','s_org_4',$arr_org4,'ทั้งหมด',$s_org_4,'','','1','');?></span></div>
	<div class="col-xs-12 col-md-1"><button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button></div>
</div>*/?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="2%"><div align="center"><small>เลือก</small><br><?php if($TYPE=='dec'){?><input type="checkbox" id="allchk" name="allchk" value="1" onClick="allChk();"><?php }?></div></th> 
				<th width="20%"><div align="center"><small><?php echo $arr_txt['name']."<br>".$arr_txt['idcard'];?></small></div></th>
				<th width="15%" nowrap><div align="center"><small>สมาชิกภาพ</small></div></th>
				<th width="7%"><div align="center"><small><?php echo $arr_txt['party'];?></small></div></th>
				<th width="10%"><div align="center"><small>เครื่องราชอิสริยาภรณ์ชั้นตราปัจจุบัน<br>ปี พ.ศ. ที่ได้รับพระราชทาน)</small></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					//func แสดงข้อมูลชื่อ
					$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
		?>
			<tr>
				<td align="center">
					<?php if($TYPE=='dec'){?>
						<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $rec['SS_ID']?>">
					<?php } else {?>
						<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['SS_ID']?>');">
					<?php } ?>
					<input type="hidden" id="f1_<?php echo $rec['SS_ID'];?>" name="f1[<?php echo $rec['SS_ID'];?>]" value="<?php echo get_idCard($rec["SS_IDCARD"]); ?>">
					<input type="hidden" id="f2_<?php echo $rec['SS_ID'];?>" name="f2[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["PREFIX_ID"]; ?>">
					<input type="hidden" id="f3_<?php echo $rec['SS_ID'];?>" name="f3[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_FIRSTNAME_TH"]); ?>">
					<input type="hidden" id="f4_<?php echo $rec['SS_ID'];?>" name="f4[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_MIDNAME_TH"]); ?>">
					<input type="hidden" id="f5_<?php echo $rec['SS_ID'];?>" name="f5[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_LASTNAME_TH"]); ?>">
					<input type="hidden" id="f_name_<?php echo $rec['SS_ID'];?>" name="f_name[<?php echo $rec['SS_ID'];?>]" value="<?php echo $name; ?>">
					<input type="hidden" id="f_marry_<?php echo $i;?>" name="f_marry[<?php echo $i;?>]" value="<?php echo $rec['PMARRY_ID']; ?>">
					<input type="hidden" id="f_ssp_<?php echo $i;?>" name="f_ssp[<?php echo $i;?>]" value="<?php echo $rec['SSP_ID']; ?>">
					<input type="hidden" id="f_sapa_<?php echo $i;?>" name="f_sapa[<?php echo $i;?>]" value="<?php echo $rec['SAPA_ID']; ?>">
					<input type="hidden" id="f_prom_<?php echo $i;?>" name="f_prom[<?php echo $i;?>]" value="<?php echo $rec['PROMISE_DATE']; ?>">
					<input type="hidden" id="f_term_<?php echo $i;?>" name="f_term[<?php echo $i;?>]" value="<?php echo $rec['SSP_TERMINATE_DATE']; ?>">
				</td>
				<td align="left"><small><?php echo $name."<br>(".get_idCard($rec["SS_IDCARD"]).")";?></small></td>
				<td align="left">
					<small>
						-<strong><?php echo $arr_txt['ssp_no'];?></strong> : <?php echo text($rec['SSP_NUMBER']);?><br>
						-<strong><?php echo $arr_txt['ss_type_all'];?></strong> : <?php echo $rec['SS_TYPE_ID']!=''?get_sstype_all($rec['SS_TYPE_ID'], $rec['SSP_PARTY_LIST'], $rec['PROV_ID'], $rec['SSP_DISTRICT_ID']):'';?><br>
						-<strong>วันที่ปฏิญาณตน</strong> : <?php echo conv_date($rec['PROMISE_DATE'],'short');?><br>
						-<strong>วันที่พ้นจากตำแหน่ง</strong> : <?php echo conv_date($rec['SSP_TERMINATE_DATE'],'short');?><br>
						-<strong>เงินประจำตำแหน่ง</strong> : <?php echo $rec['SSP_POSITION']!=''?number_format($rec['SSP_POSITION'],2):''; ?><br>
						-<strong>เงินเพิ่ม</strong> : <?php echo $rec['SSP_MORE']!=''?number_format($rec['SSP_MORE'],2):''; ?><br>
					</small>
				</td>
				<td align="left"><small><?php echo text($arr_party[$rec['PARTY_ID']]);?></small></td>
				<td align="center"><small><?php echo ($rec['SDEH_ID'])?text($arr_dec_name[$rec['DEC_ID']])."<br>(".conv_date($rec['SDEH_RECEIVE_DATE'],'short').")":"-"; ?></small></td>
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
		var file="form_req_ss_popup.php";
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