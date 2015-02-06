<?php
$path = "../../";
include($path."include/config_header_top.php");
ini_set("max_execution_time" , 160);

$page = $_REQUEST['page'];
$act = $_GET['act'];
$TYPE = $_GET['TYPE'];
$S_CARD = $_GET['S_CARD'];
$S_NAME = $_GET['S_NAME'];
$REQUEST_TYPE = $_GET['REQUEST_TYPE'];
$menu_sub_id = $_GET['menu_sub_id'];
//$SS_IDCARD = trim($_GET['SS_IDCARD']);
//print_r($_REQUEST);


$filter = "";
if($S_CARD != ""){
	if($act=='4' || $REQUEST_TYPE =='6'){
		 $filter .= " and SS_IDCARD LIKE '%".ctext($S_CARD)."%' ";
	}else if($act <='3' && $menu_sub_id != '565'){
		 $filter .= " and PER_IDCARD LIKE '%".ctext($S_CARD)."%' ";
	}else if($act <='5' && $menu_sub_id != '565'){
		$filter .= " and SP_IDCARD LIKE '%".ctext($S_CARD)."%' ";
	}else if($REQUEST_TYPE <='19' ){
		$filter .= " and SP_IDCARD LIKE '%".ctext($S_CARD)."%' ";
	}
}
if($S_NAME != ""){
	if($act=='4'){
		$filter .= searchName(ctext($S_NAME),"SS_ID");
	}else if($act <='3' && $menu_sub_id != '565'){
		$filter .= searchName(ctext($S_NAME),"PER_ID");
	}else if($act <='5' && $menu_sub_id != '565'){
		$filter .= searchName(ctext($S_NAME),"SP_ID");
	}else if($REQUEST_TYPE <='19' && $REQUEST_TYPE !='6'){
		$filter .= searchName(ctext($S_NAME),"SP_ID");
	}else if($REQUEST_TYPE =='6'){
		$filter .= searchName(ctext($S_NAME),"a.SS_ID");
	}
}
//เงื่อนในการแสดง
if($act <='3' && $menu_sub_id != '565'){ //ข้าราชการรัฐสภาสามัญ &&   พนักงานราชการ &&  ลูกจ้างประจำ
	$table_a=" PER_PROFILE ";
	$table_b="";
	$pk = "PER_ID";
	if($act =='1' && $menu_sub_id != '565'){
		$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' and PER_STATUS ='2' and POSTYPE_ID='1' ";
	}else if($act =='2'){
		$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' and PER_STATUS ='2' and POSTYPE_ID='3' ";
	}else if($act =='3'){
		$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' and PER_STATUS ='2' and POSTYPE_ID='5' ";
	}
}else if($act =='4' && $menu_sub_id != '565'){ //สมาชิกสภาผู้แทนราษฎร
	$table_a .= "  V_SAPA_LIST ";
	$table_b ="";
	$pk .= "SS_ID";
	$f_filter .= ",CONVERT(date ,SSP_PROMISE_DATE) as SSP_PROMISE_DATE";
	$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' ";
	
}else if($act =='5'){ // ข้าราชการรัฐสภาฝ่ายการเมือง
	$table_a=" V_SP_LIST  ";
	$table_b=" ";
	$pk .= "SP_ID";
	$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='7' ";
}else if($REQUEST_TYPE =='6'){ // อดีต
	$table_a=" SS_PROFILE a ";
	$table_b=" join SS_SAPA_POSITION b on a.SS_ID=b.SS_ID";
	$pk .= "a.SS_ID";
	$wh2="1=1 AND a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' and b.SAPA_ID<='".@key($arr_sapa)."' ";
	//$not="and a.SS_ID not in (select SS_ID from SS_SAPA_POSITION where SAPA_ID='".@key($arr_sapa)."' and SSP_STATUS_3='1' and ACTIVE_STATUS='1' and DELETE_FLAG='0')";
}else if($REQUEST_TYPE <='19' && $REQUEST_TYPE !='6'||($menu_sub_id==565)){ // ข้าราชการรัฐสภาฝ่ายการเมือง
	$table_a=" V_SP_LIST  ";
	$table_b=" ";
	$pk .= "SP_ID";
		if($REQUEST_TYPE =='7'){ //ข้าราชการฝ่ายการเมือง
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='7' ";
		}else if($REQUEST_TYPE =='8'){ //คณะทำงานทางการเมือง
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='11' ";
		}else if($REQUEST_TYPE =='9'){ //ผู้ปฏิบัติงานให้ ส.ส.
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='12' ";
		}else if($REQUEST_TYPE =='11'){ //ผที่ปรึกษากิตติมศักดิ์
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='28' ";
		}else if($REQUEST_TYPE =='12'){ // คณะทำงาน
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='30' ";
		}else if($REQUEST_TYPE =='15'){ //คณะกรรมการข้าราชการรัฐสภา
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='18' ";
		}else if($REQUEST_TYPE =='16'){ //คณะอนุกรรมการข้าราชการรัฐสภา
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='26' ";
		}else if($REQUEST_TYPE =='17'){ //คณะกรรมการมูลนิธิ ร. 7
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='22' ";
		}else if($REQUEST_TYPE =='14'){ // คณะรัฐมนตรีและผู้ติดตาม
			$wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND SPPOSTYPE_ID='21' ";
                }else if($menu_sub_id==565){
                        $wh2="1=1 AND ACTIVE_STATUS='1' AND DELETE_FLAG='0' and SP_STATUS_PUBLIC = 2 ";
                }
}

$field="* {$f_filter}";
$table= $table_a . $table_b;
$pk_id= "{$pk}";
$wh=" {$wh2} {$not} {$filter}";
if($act <='3' && $menu_sub_id != '565'){
	$orderby="order by PER_FIRSTNAME_TH, (case when Rtrim(PER_MIDNAME_TH)!='' then PER_MIDNAME_TH else '' end), PER_LASTNAME_TH asc";
}else if($act=='4' ){
	$orderby="order by SS_FIRSTNAME_TH, (case when Rtrim(SS_MIDNAME_TH)!='' then SS_MIDNAME_TH else '' end), SS_LASTNAME_TH asc";
}else if($act=='5'){
	$orderby="order by SP_FIRSTNAME_TH, (case when Rtrim(SP_MIDNAME_TH)!='' then SP_MIDNAME_TH else '' end), SP_LASTNAME_TH asc";
}else if($REQUEST_TYPE <='19' && $menu_sub_id != '565'){
	$orderby="order by SP_FIRSTNAME_TH, (case when Rtrim(SP_MIDNAME_TH)!='' then SP_MIDNAME_TH else '' end), a.SP_LASTNAME_TH asc";
}else if($REQUEST_TYPE =='6' ){
	$orderby="order by a.SS_FIRSTNAME_TH, (case when Rtrim(a.SS_MIDNAME_TH)!='' then a.SS_MIDNAME_TH else '' end), a.SS_LASTNAME_TH asc";
}
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;
$SQL = "select top 10 ".$field." from ".$table." where ".$notin; //exit();
$SQLALL = "select * from ".$table." where ".$wh;
//list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span,$filter);
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", "&S_CARD=".$S_CARD."&S_NAME=".$S_NAME."&REQUEST_TYPE=".$REQUEST_TYPE."&menu_sub_id=".$menu_sub_id."&chk_type=".$chk_type."&act=".$act,$s_file,$span,$TYPE);
$nums=$db->db_num_rows($exc);

//sapa
$arr_sapa_number=GetSqlSelectArray("SAPA_ID", "SAPA_NUMBER", "SS_SETUP_SAPA", "DELETE_FLAG='0'", "SAPA_NUMBER"); 
?>
<input type="hidden" id="REQUEST_TYPE" name="REQUEST_TYPE" value="<?php echo $REQUEST_TYPE;?>">
<!--เครื่องราช-->
<input type="hidden" id="YEAR_ID" name="YEAR_ID" value="<?php echo $YEAR_ID;?>">
<input type="hidden" id="DEF_ID" name="DEF_ID" value="<?php echo $DEF_ID;?>">
<input type="hidden" id="DEC_ID" name="DEC_ID" value="<?php echo $DEC_ID;?>">
<input type="hidden" id="dec_page" name="dec_page" value="<?php echo $dec_page;?>">
<input type="hidden" id="act" name="act" value="<?php echo $act;?>">
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
					<?php if($act=='4'){ ?>
					<th width="30%"><div align="center"><small><?php echo $arr_txt['party'];?></small></div></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
			<?php
				if($nums > 0){
					$i=1;
					while($rec = $db->db_fetch_array($exc)){
						//func แสดงข้อมูลชื่อ
						if($act=='4' || $REQUEST_TYPE =='6'){
							$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
							$a_ID = $rec['SS_ID'];
							$IDCARD = $rec['SS_IDCARD'] ;
							$FIRSTNAME_TH = $rec["SS_FIRSTNAME_TH"];
							$MIDNAME_TH = $rec["SS_MIDNAME_TH"];
							$LASTNAME_TH = $rec["SS_LASTNAME_TH"];
						}else if($act <='3' && $menu_sub_id != '565'){
							$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
							$a_ID = $rec['PER_ID'];
							$IDCARD = $rec['PER_IDCARD'] ;
							$FIRSTNAME_TH = $rec["PER_FIRSTNAME_TH"];
							$MIDNAME_TH = $rec["PER_MIDNAME_TH"];
							$LASTNAME_TH = $rec["PET_LASTNAME_TH"];
						}else if($act =='5'){
							$name=Showname($rec["PREFIX_ID"],$rec["SP_FIRSTNAME_TH"],$rec["SP_MIDNAME_TH"],$rec["SP_LASTNAME_TH"]);
							$a_ID = $rec['SP_ID'];
							$IDCARD = $rec['SP_IDCARD'] ;
							$FIRSTNAME_TH = $rec["SP_FIRSTNAME_TH"];
							$MIDNAME_TH = $rec["SP_MIDNAME_TH"];
							$LASTNAME_TH = $rec["SP_LASTNAME_TH"];
						}else if($REQUEST_TYPE <='19'){
							$name=Showname($rec["PREFIX_ID"],$rec["SP_FIRSTNAME_TH"],$rec["SP_MIDNAME_TH"],$rec["SP_LASTNAME_TH"]);
							$a_ID = $rec['SP_ID'];
							$IDCARD = $rec['SP_IDCARD'] ;
							$FIRSTNAME_TH = $rec["SP_FIRSTNAME_TH"];
							$MIDNAME_TH = $rec["SP_MIDNAME_TH"];
							$LASTNAME_TH = $rec["SP_LASTNAME_TH"];
						}
			?>
				<tr>    
					<td align="center">
						<input type="hidden" id="f1_<?php echo $a_ID;?>" name="f1[<?php echo $a_ID; ?>]" value="<?php echo get_idCard($IDCARD,'-'); ?>">
						<input type="hidden" id="f_name_<?php echo $a_ID;?>" name="f_name[<?php echo $a_ID;?>]" value="<?php echo $name; ?>">
						
						<!--<input type="hidden" id="f2_<?php echo $a_ID;?>" name="f2[<?php echo $a_ID;?>]" value="<?php echo $rec["PREFIX_ID"]; ?>">
						
						<input type="hidden" id="f3_<?php echo $a_ID;?>" name="f3[<?php echo $a_ID;?>]" value="<?php echo text($FIRSTNAME_TH); ?>">
						
						<input type="hidden" id="f4_<?php echo $a_ID;?>" name="f4[<?php echo $a_ID;?>]" value="<?php echo text($MIDNAME_TH); ?>">
						
						<input type="hidden" id="f5_<?php echo $a_ID;?>" name="f5[<?php echo $a_ID;?>]" value="<?php echo text($LASTNAME_TH); ?>">
						
						<input type="hidden" id="f6_<?php echo $a_ID?>" name="f6[<?php echo $a_ID;?>]" value="<?php echo text($rec["PARTY_ID"]); ?>">-->
						
						
						<?	/*
						<input type="hidden" id="f_sapa_<?php echo $rec['SS_ID'];?>" name="f_sapa[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($arr_sapa_number[$rec['SAPA_ID']]); ?>">
						
						<input type="hidden" id="f_party_<?php echo $rec['SS_ID'];?>" name="f_party[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($arr_party[$rec["PARTY_ID"]]); ?>">
						
						<input type="hidden" id="f_type_<?php echo $rec['SS_ID'];?>" name="f_type[<?php echo $rec['SS_ID'];?>]" value="<?php echo text($arr_type_ss[$rec['SS_TYPE_ID']]); ?>">
						
						<input type="hidden" id="f_list_<?php echo $rec['SS_ID'];?>" name="f_list[<?php echo $rec['SS_ID'];?>]" value="<?php echo ($rec['SS_TYPE_ID']=='1'?text($arr_prov[$rec['PROV_ID']])." เขต ".$rec['SSP_DISTRICT_ID']:$rec['SSP_PARTY_LIST']); ?>">
						
						<input type="hidden" id="n_list_<?php echo $rec['SS_ID'];?>" name="n_list[<?php echo $rec['SS_ID'];?>]" value="<?php echo ($rec['SS_TYPE_ID']=='1'?$arr_txt['borough']:$arr_txt['listroster']); ?>">
						
						<input type="hidden" id="f_all_<?php echo $rec['SS_ID'];?>" name="f_all[<?php echo $rec['SS_ID'];?>]" value="<?php echo get_sstype_all($rec['SS_TYPE_ID'], $rec['SSP_PARTY_LIST'], $rec['PROV_ID'], $rec['SSP_DISTRICT_ID']) ?>">
						
						<input type="hidden" id="f_ssp_<?php echo $rec['SS_ID'];?>" name="f_ssp[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["SSP_ID"]; ?>">
						
						<input type="hidden" id="f_ssp_number_<?php echo $rec['SS_ID'];?>" name="f_ssp_number[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["SSP_NUMBER"]; ?>">
						
						<input type="hidden" id="f_promise_<?php echo $rec['SS_ID'];?>" name="f_promise[<?php echo $rec['SS_ID'];?>]" value="<?php echo conv_date($rec["SSP_PROMISE_DATE"],'short'); ?>">
						
						<input type="hidden" id="f_picture_<?php echo $rec['SS_ID'];?>" name="f_picture[<?php echo $rec['SS_ID'];?>]" value="<?php echo $rec["SS_PICTURE"]; ?>">
						*/ ?>
						
						<?php if($chk_type=='checkbox'){?>
							<input type="checkbox" id="chk<?php echo $i;?>" name="chk[<?php echo $i;?>]" value="<?php echo $a_ID;?>">
						<?php } else {?> 
							<input type="radio" id="chk<?php echo $i;?>" name="chk" value="1" onclick="getChk('<?php echo $a_ID;?>');">
						<?php } ?>
					<td align="center"><small><?php echo get_idCard($IDCARD); ?></small></td>
					<td align="left"><small><?php echo $name; ?></small></td>
					<?php if($act=='4'){  ?>
					<td align="left"><small><?php echo text($arr_party[$rec["PARTY_ID"]]); ?></small></td>
					<?php } ?>
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
	function searchpopup(){ 
	//alert('gg'); 
		var file="person_card_popup.php";
		var url ='../../system/all/'+file;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'html',
			data: {span:'show_display',s_file:file,page:'1',REQUEST_TYPE:'<?php echo $REQUEST_TYPE;?>',S_CARD:$('#S_CARD').val(),S_NAME:$('#S_NAME').val(), TYPE:'<?php echo $TYPE;?>', chk_type:'<?php echo $chk_type;?>', act:'<?php echo $act;?>', menu_sub_id:'<?php echo $menu_sub_id;?>'},
			async: false,
			success: function(data) {
				$("#show_display").html(data);
			} 
		});
	}
</script>