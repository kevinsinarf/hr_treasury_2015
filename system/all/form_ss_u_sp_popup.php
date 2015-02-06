<?php
$path = "../../";
include($path."include/config_header_top.php");
ini_set("max_execution_time" , 160);

$page = $_REQUEST['page'];
$ss_type = $_GET['ss_type'];
$TYPE = $_GET['TYPE'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
//$SS_IDCARD = trim($_GET['SS_IDCARD']);
//print_r($_REQUEST);

$filter = "";
if($S_CARD != ""){
	$filter .= " and SS_IDCARD LIKE '%".ctext($S_CARD)."%' ";
}
if($S_NAME != ""){
	$filter .= searchName(ctext($S_NAME),"a.SS_ID");
}
//เงื่อนในการแสดง
if($ss_type=='1'){//ss_profile only คนเท่านั้น
	$table_b="";
}else{//ss_sapa_position
	$table_b="join SS_SAPA_POSITION b on a.SS_ID=b.SS_ID and b.ACTIVE_STATUS='1' AND b.DELETE_FLAG='0'";
	if($ss_type=='2'){//ชุดปัจจุบัน
		$table_b.=" and b.SAPA_ID='".@key($arr_sapa)."' and b.SSP_STATUS_3='1'";
		$f_filter.= ",CONVERT(date ,b.SSP_PROMISE_DATE) as SSP_PROMISE_DATE";
	}elseif($ss_type=='3'){//ชุดอดีต
		$table_b.=" and b.SAPA_ID<'".@key($arr_sapa)."'";
	}elseif($ss_type=='4'){//ประธาน รองประธาน (ชุดปัจจุบัน) 
		$table_b.=" and b.SAPA_ID='".@key($arr_sapa)."' 
		join (select SS_ID from SS_POSITIONHIS where ACTIVE_STATUS='1' and DELETE_FLAG='0' and POS_ID in ('1','2') group by SS_ID) c on a.SS_ID=c.SS_ID  ";
	}elseif($ss_type=='5'){//คู่สมรส ชุดปัจจุบัน
		$table_b.=" and b.SAPA_ID='".@key($arr_sapa)."'
		join (select SS_ID from SS_MARRYHIS where ACTIVE_STATUS='1' and DELETE_FLAG='0' and MARRY_TYPE='1' and MARRY_STATUS='1' group by SS_ID) c on a.SS_ID=c.SS_ID  ";
	}elseif($ss_type=='6'){//คู่สมรส ประธาน รองประธาน (ชุดปัจจุบัน) 
		$table_b.=" and b.SAPA_ID='".@key($arr_sapa)."'
		join (select SS_ID from SS_POSITIONHIS where ACTIVE_STATUS='1' and DELETE_FLAG='0' and POS_ID in ('1','2') group by SS_ID) c on a.SS_ID=c.SS_ID  
		join (select SS_ID from SS_MARRYHIS where ACTIVE_STATUS='1' and DELETE_FLAG='0' and MARRY_TYPE='1' and MARRY_STATUS='1' group by SS_ID) d on a.SS_ID=d.SS_ID";
	}elseif($ss_type=='7'){//ตามสมัยสภา
		$table_b.=" and b.SAPA_ID='".$SAPA_ID."'";
	}
}

if($TYPE=='PL'){//การบันทึกข้อมูลสมาชิกสภาผู้แทนราษฎรแบบบัญชีรายชื่อ 
	$not="and a.SS_IDCARD not in (select PL_IDCARD from SS_PARTY_LIST where SAPA_ID='".$SAPA_ID."' and PL_IDCARD is not null AND  DELETE_FLAG='0' )";
}else if($TYPE=='SS'){//การกำหนดรายชื่อสมาชิกสภาผู้แทนราษฎรในแต่ละสมัยสภา 
	$not="and a.SS_IDCARD not in (select b.SS_IDCARD from SS_PROFILE b join SS_SAPA_POSITION c on b.SS_ID=c.SS_ID and c.ACTIVE_STATUS='1' and c.DELETE_FLAG='0' where b.SS_IDCARD is not null and c.SAPA_ID='".@key($arr_sapa)."' and b.ACTIVE_STATUS='1' and b.DELETE_FLAG='0')"; 
}else if($TYPE=='DEC_SS_OLD'){//อดีต ส.ส. เครื่องราชฯ 
	$not="and a.SS_ID not in (select c.SS_ID from SS_PROFILE b join DEC_SS c on a.SS_ID=c.SS_ID and c.YEAR_BDG='".$YEAR_ID."' and c.DEF_ID='".$DEF_ID."' and c.DEC_ID='".$DEC_ID."' and POS_ID IS NULL)"; 
}else if($TYPE=='DEC_SS_HEAD'){//ประธานสภาฯ รองประธานสภาฯ
    $not="and a.SS_ID not in (select c.SS_ID from SS_PROFILE b join DEC_SS c on a.SS_ID=c.SS_ID and c.YEAR_BDG='".$YEAR_ID."' and c.DEF_ID='".$DEF_ID."' and c.DEC_ID='".$DEC_ID."' and POS_ID IS NOT NULL)";
}else if($TYPE=='DEC_SS_MARRY'){//คู่สมรส
    $not="and a.SS_ID not in (select c.SS_ID from SS_PROFILE b join DEC_SS c on a.SS_ID=c.SS_ID and c.YEAR_BDG='".$YEAR_ID."' and c.DEF_ID='".$DEF_ID."' and c.DEC_ID='".$DEC_ID."' and c.POS_ID IS NULL and c.MAIRED_ID IS NOT NULL)";
}else if($TYPE=='DEC_SS_MARRY_HEAD'){//คู่สมรสประธานสภาฯ
    $not="and a.SS_ID not in (select c.SS_ID from SS_PROFILE b join DEC_SS c on a.SS_ID=c.SS_ID and c.YEAR_BDG='".$YEAR_ID."' and c.DEF_ID='".$DEF_ID."' and c.DEC_ID='".$DEC_ID."' and c.POS_ID IS NOT NULL and c.MAIRED_ID IS NOT NULL)";
}

$field="SELECT UN.SS_ID,UN.PREFIX_ID,UN.SS_FIRSTNAME_TH,UN.SS_MIDNAME_TH,UN.SS_LASTNAME_TH,TYPE {$f_filter}";
$table="(SELECT SS.PREFIX_ID,SS.SS_ID,SS.SS_FIRSTNAME_TH,SS.SS_MIDNAME_TH,SS.SS_LASTNAME_TH,'SS' as TYPE
FROM SS_PROFILE SS 
INNER JOIN SS_SAPA_POSITION SSP ON SS.SS_ID=SSP.SS_ID and SSP.ACTIVE_STATUS=1 and SSP.DELETE_FLAG=0
WHERE SS.ACTIVE_STATUS=1 and SS.DELETE_FLAG=0

UNION

SELECT PREFIX_ID,SP_ID,SP_FIRSTNAME_TH,SP_MIDNAME_TH,SP_LASTNAME_TH,'SP' as TYPE 
FROM SP_PROFILE 
WHERE SP_ID NOT IN (71) and ACTIVE_STATUS=1 and DELETE_FLAG=0) AS UN ";
$pk_id="SS_ID";
$wh="1=1 {$not} {$filter}";
$orderby="order by SS_FIRSTNAME_TH, (case when Rtrim(SS_MIDNAME_TH)!='' then SS_MIDNAME_TH else '' end), SS_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
//list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", "&S_CARD=".$S_CARD."&S_NAME=".$S_NAME."&ss_type=".$ss_type."&SAPA_ID=".$SAPA_ID."&chk_type=".$chk_type."&dec_page=".$dec_page,$s_file,$span,$TYPE);
$nums=$db->db_num_rows($exc);

//sapa
$sapa_number=$db->get_data_field("select SAPA_NUMBER from SS_SETUP_SAPA where SAPA_ID='".@key($arr_sapa)."'", "SAPA_NUMBER");
?>
<input type="hidden" id="ss_type" name="ss_type" value="<?php echo $ss_type;?>">
<!--เครื่องราช-->
<input type="hidden" id="YEAR_ID" name="YEAR_ID" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="DEF_ID" name="DEF_ID" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="DEC_ID" name="DEC_ID" value="<?php echo $DEC_ID;?>">
<input type="hidden" id="dec_page" name="dec_page" value="<?php echo $dec_page;?>">
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['idcard'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_CARD" name="S_CARD" class="form-control" placeholder="<?php echo $arr_txt['idcard'];?>" value="<?php echo $S_CARD; ?>"></div>
</div>
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="S_NAME" name="S_NAME" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $S_NAME; ?>"></div>
    <button type="button" class="btn btn-primary" onClick="searchpopup();">ค้นหา</button>
</div>
<div class="row">
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover table-condensed">
			<thead>
				<tr class="info">
					<th width="5%"><div align="center"><small>เลือก</small><br><?php if($chk_type=='checkbox'){?><input type="checkbox" id="allchk" name="allchk" value="1" onClick="allChk();"><?php }?></div></th> 
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
						$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
			?>
				<input type="hidden" id="f1_<?php echo $rec['SS_ID'];?>" name="f1[<?php echo $rec['SS_ID'];?>]" value="<?php echo get_idCard($rec['SS_IDCARD'],'-'); ?>">
				<input type="hidden" id="f2_<?php echo $rec['SS_ID'];?>" name="f2[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["PREFIX_ID"]; ?>">
				<input type="hidden" id="f3_<?php echo $rec['SS_ID'];?>" name="f3[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_FIRSTNAME_TH"]); ?>">
				<input type="hidden" id="f4_<?php echo $rec['SS_ID'];?>" name="f4[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_MIDNAME_TH"]); ?>">
				<input type="hidden" id="f5_<?php echo $rec['SS_ID'];?>" name="f5[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["SS_LASTNAME_TH"]); ?>">
				<input type="hidden" id="f6_<?php echo $rec['SS_ID'];?>" name="f6[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($rec["PARTY_ID"]); ?>">
				<input type="hidden" id="f_name_<?php echo $rec['SS_ID'];?>" name="f_name[<?php echo $rec['SS_ID'];?>]" value="<?php echo $name; ?>">
				<input type="hidden" id="f_sapa_<?php echo $rec['SS_ID'];?>" name="f_sapa[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($sapa_number); ?>">
				<input type="hidden" id="f_party_<?php echo $rec['SS_ID'];?>" name="f_party[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($arr_party[$rec["PARTY_ID"]]); ?>">
				<input type="hidden" id="f_type_<?php echo $rec['SS_ID'];?>" name="f_type[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($arr_type_ss[$rec['SS_TYPE_ID']]); ?>">
				<input type="hidden" id="f_all_<?php echo $rec['SS_ID'];?>" name="n_list[<?php echo $rec['SS_ID'];?>]" value="<?php echo get_sstype_all($rec['SS_TYPE_ID'], $rec['SSP_PARTY_LIST'], $rec['PROV_ID'], $rec['SSP_DISTRICT_ID']) ?>">
				<input type="hidden" id="f_ssp_<?php echo $rec['SS_ID'];?>" name="f_ssp[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["SSP_ID"]; ?>">
				<input type="hidden" id="f_ssp_number_<?php echo $rec['SS_ID'];?>" name="f_ssp_number[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["SSP_NUMBER"]; ?>">
				<input type="hidden" id="f_promise_<?php echo $rec['SS_ID'];?>" name="f_promise[<?php echo $rec['SS_ID'];?>]" value="<?php echo conv_date($rec["SSP_PROMISE_DATE"],'short'); ?>">
				<tr>    
					<td align="center">
						<?php if($chk_type=='checkbox'){?>
							<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $rec['SS_ID']?>">
						<?php } else {?> 
							<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $rec['SS_ID']?>');">
						<?php } ?>
					<td align="center"><small><?php echo get_idCard($rec["SS_IDCARD"]); ?></small></td>
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
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>
<script type="text/javascript">
	function searchpopup(){ //alert(); 
		var file="form_ss_popup.php";
		var url ='../../system/all/'+file;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {span:'show_display',s_file:file,page:'1',ss_type:'<?php echo $ss_type;?>',SAPA_ID:'<?php echo $SAPA_ID;?>',S_CARD:$('#S_CARD').val(),S_NAME:$('#S_NAME').val(), TYPE:'<?php echo $TYPE;?>', chk_type:'<?php echo $chk_type;?>', dec_page:'<?php echo $dec_page;?>'},
			async: false,
			success: function(data) {
				$("#show_display").html(data);
			} 
		});
	}
</script>