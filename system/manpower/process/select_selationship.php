<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$proc=$_POST['proc'];

switch($proc){
	case "country" : //ประเทศ
		$id=$_POST['z_id'];
		$name=$_POST['z_name'];
		$clase=$_POST['z_class'];
		$sql_scountry = "select COUNTRY_ID, COUNTRY_NAME_TH from SETUP_COUNTRY where ACTIVE_STATUS='1' and DELETE_FLAG='0' order by COUNTRY_NAME_TH asc";
		//echo getSelect($id,$name, $clase , 'COUNTRY_ID' , 'COUNTRY_NAME_TH' , $sql_scountry , $db ,'', '--เลือก ประเทศ-- ',null); 
		echo get_Select(
			$sql_scountry ,
			$db ,
			array(
				'id'=>$id,
				'name'=>$name,
				'class'=>$clase,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'COUNTRY_ID', 
				's_value'=>'COUNTRY_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'ประเทศ',
				's_style'=>""
			)
		);
	break;
	
	
	case "rampr" : //อำเภอ
		try{
			$v_ampr=$_POST['v_ampr'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$name_tamb=$_POST['name_tamb'];
			$val=$_POST['val'];
			
			$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$v_ampr."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_TH");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_ampr,'อำเภอ/เขต',$val,'onchange="getStamb(this.id,this.value,\''.$name_tamb.'\')"','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "rampr2" : //อำเภอ
		try{
			$v_ampr2=$_POST['v_ampr'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$name_tamb=$_POST['name_tamb'];
			$val=$_POST['val'];
			
			$arr_amprr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_EN", "SETUP_AMPR", "PROV_ID='".$v_ampr2."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "AMPR_NAME_EN");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_amprr,'อำเภอ/เขต',$val,'onchange="getStamb(this.id,this.value,\''.$name_tamb.'\')"','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	
	case "stamb" : //ตำบล
		try{
			$v_tamb=$_POST['v_tamb'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$v_tamb."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_tamb,'อำเภอ/เขต',$val,'','','1');
			
			
						
			//echo GetHtmlSelect($z_id,$z_name,$arr_tamb,'ตำบล/แขวง',$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "stamb2" : //ตำบล
		try{
			$v_tamb2=$_POST['v_tamb'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_EN", "SETUP_TAMB", "AMPR_ID='".$v_tamb2."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_EN");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_tamb,'ตำบล/แขวง',$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "edu_level" :  //ระดับการศึกษา 
		try{	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		$sql_level = "select EL_ID , EL_NAME_TH from SETUP_EDU_LEVEL  WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0'  ORDER BY EL_NAME_TH ASC";
		//echo getSelect($id,$name, $clase , 'EL_ID' , 'EL_NAME_TH' , $sql_level , $db ,'', '--เลือก-- ',null); 
		echo get_Select(
				$sql_level ,
				$db ,
				array(
					'id'=>$z_id,
					'name'=>$z_name,
					'class'=>$z_class,
					's_selected'=>'',
					's_defualt'=>'',
					's_key'=>'EL_ID', 
					's_value'=>'EL_NAME_TH',
					's_onchage'=>'',
					's_placeholder'=>'ระดับการศึกษา ',
					's_style'=>""
				)
			);
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edu_major" :   //สาขาวิชา 
		try{	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		$sql_major = "select EM_ID , EM_NAME_TH from SETUP_EDU_MAJOR  WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0' ORDER BY EM_NAME_TH ASC";
		echo get_Select(
				$sql_major ,
				$db ,
				array(
					'id'=>$z_id,
					'name'=>$z_name,
					'class'=>$z_class,
					's_selected'=>'',
					's_defualt'=>'',
					's_key'=>'EM_ID', 
					's_value'=>'EM_NAME_TH',
					's_onchage'=>'',
					's_placeholder'=>'สาขา ',
					's_style'=>""
				)
			);			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "edu_degree" : //วุฒิการศึกษา 
		try{	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		$sql_degree = "select ED_ID , ED_NAME_TH from SETUP_EDU_DEGREE  WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0'  ORDER BY ED_NAME_TH ASC";
		//echo getSelect($id,$name, $clase , 'ED_ID' , 'ED_NAME_TH' , $sql_degree , $db ,'', '--เลือก-- ',null);  
		echo get_Select(
				$sql_degree ,
				$db ,
				array(
					'id'=>$z_id,
					'name'=>$z_name,
					'class'=>$z_class,
					's_selected'=>'',
					's_defualt'=>'',
					's_key'=>'ED_ID', 
					's_value'=>'ED_NAME_TH',
					's_onchage'=>'',
					's_placeholder'=>'วุฒิการศึกษา ',
					's_style'=>""
				)
			);			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "education" : //สถานศึกษา    
		try{	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		$sql_education = "select INS_ID , INS_NAME_TH from  SETUP_EDU_INSTITUTE  WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0' ORDER BY INS_NAME_TH ASC";
		//echo getSelect($id,$name, $clase , 'INS_ID' , 'INS_NAME_TH' , $sql_education , $db ,'', '--เลือก-- ',null);  
		echo get_Select(
			$sql_education ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'INS_ID', 
				's_value'=>'INS_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'สถานศึกษา',
				's_style'=>""
			)
		);			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "decoration" :    //ประเภทเครื่องราชอิสริยาภรณ์ 
		try{
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		$numble=$_POST['numble'];
		$sql_decortion = "SELECT DEF_ID ,DEF_NAME_TH+' ('+DEF_NAME_SHORT+')' as DEF_NAME_TH FROM SETUP_DECORATION_FAMILY WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0' ORDER BY DEF_NAME_TH ASC";
		//echo getSelect($id,$name, $clase , 'DEF_ID' , 'DEF_NAME_TH' , $sql_decortion , $db ,'', '--เลือกประเภท-- ','decorationSteep(this.value,\''.$numble.'\')');  	
		echo get_Select(
			$sql_decortion ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'DEF_ID', 
				's_value'=>'DEF_NAME_TH',
				's_onchage'=>'decorationSteep(this.value,\''.$numble.'\')',
				's_placeholder'=>'ประเภท',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "level" :   //ชั้นเครื่องราชอิสริยาภรณ์ 
		try{	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		$DEF_ID=$_POST['DEF_ID'];
		$sql_level = "SELECT DEC_ID ,DEC_NAME_TH FROM SETUP_DECORATION WHERE DEC_TYPE='2' AND DELETE_FLAG='0'  AND DEF_ID ='".$DEF_ID."' ORDER BY DEC_NAME_TH ASC";
		//echo getSelect($id,$name, $clase , 'DEC_ID' , 'DEC_NAME_TH' , $sql_level , $db ,'', '--เลือกชั้น-- ',null);
		$array_level=GetSqlSelectArray("DEC_ID", "DEC_NAME_TH", "SETUP_DECORATION", "DEF_ID='".$DEF_ID."' and DEC_TYPE='2' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "DEC_NAME_TH");
		//echo GetHtmlSelect($z_id,$z_name,$array_level,'ชั้นเครื่องราชอิสริยาภรณ์','','','','1');
		echo get_Select(
			$sql_level ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'DEC_ID', 
				's_value'=>'DEC_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'ชั้นเครื่องราชอิสริยาภรณ์',
				's_style'=>""
			)
		);			
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "coins" :   //เหรียญเครื่องราช 
		try{	
		$id=$_POST['z_id'];
		$name=$_POST['z_name'];
		$clase=$_POST['z_class'];
		
		$sql_coins = "SELECT DEC_ID ,DEC_NAME_TH FROM SETUP_DECORATION WHERE DEC_TYPE='3' AND DELETE_FLAG='0' ORDER BY DEC_NAME_TH ASC";
		//echo getSelect($id,$name, $clase , 'DEC_ID' , 'DEC_NAME_TH' , $sql_coins , $db ,'', '--เลือกเหรียญ-- ',null);  	
		echo get_Select(
			$sql_coins ,
			$db ,
			array(
				'id'=>$id,
				'name'=>$name,
				'class'=>$clase,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'DEC_ID', 
				's_value'=>'DEC_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'--เลือกเหรียญ--',
				's_style'=>""
			)
		);
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "original" :    //สังกัด
		try{	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		
		$sql_original = "SELECT ORG_ID ,ORG_NAME_TH FROM SETUP_ORG WHERE OL_ID='2' AND DELETE_FLAG='0' ORDER BY ORG_NAME_TH ASC";	
		echo get_Select(
			$sql_original ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'เลือกต้นสังกัด',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	case "prefix" :    //คำนำหน้าชื่อ
		try{	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];
		
		$sql_prefix = "select PREFIX_ID,PREFIX_NAME_TH from SETUP_PREFIX where ACTIVE_STATUS='1' and DELETE_FLAG='0' order by PREFIX_NAME_TH asc";	
		echo get_Select(
			$sql_prefix ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'PREFIX_ID', 
				's_value'=>'PREFIX_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'คำนำหน้า',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "getOrg" :
		try{
			$org=$_POST['org'];	
			$parent_id=$_POST['parent_id'];	
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];	
			$onchange=$_POST['onchange'];
			$key_index=$_POST['key_index'];	
			$span_id=$_POST['span_id'];	
			if($org != 2){
				$Cond .= " AND a.ORG_PARENT_ID = '".$parent_id."' AND a.ORG_PARENT_ID IS NOT NULL ";
			}
			$org_name = array(
				'2' => "ระดับกรม",
				'3' => "ระดับกอง/สำนัก/กลุ่ม",
				'4' => "ระดับส่วน/กลุ่มงาน",
			);
			$arr_org=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ".$Cond, "ORG_NAME_TH");
			$arr_json["org"] = $org;
			$arr_json["key_index"] = $key_index;
			$arr_json["selectbox"] = GetHtmlSelect($z_id.$org.$key_index, $z_name.$org.$key_index, $arr_org,$org_name[$org], '' ,'onchange="changeORG(\''.($org+1).'\', this.value, \''.$z_id.'\', \''.$span_id.'\', \''.$onchange.'\', \''.$key_index.'\');"','','');
			echo json_encode($arr_json);
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "org_3" :    //org3
		try{
		$PARENT_ID=$_POST['PARENT_ID'];	
		$oncharng=$_POST['oncharng'];		
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		 $sql_org3 = "select a.ORG_ID,a.ORG_NAME_TH from SETUP_ORG as a
						where a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
						order by ORG_NAME_TH asc";	
		echo get_Select(
			$sql_org3 ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'getORG3(this.value,\''.$oncharng.'\')',
				's_placeholder'=>'ระดับกอง/สำนัก/กลุ่ม',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "org_4" :    //org4
		try{
		$PARENT_ID=$_POST['PARENT_ID'];			
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		$sql_org4 = "select a.ORG_ID,a.ORG_NAME_TH from SETUP_ORG as a
						where a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
						order by ORG_NAME_TH asc";	
		echo get_Select(
			$sql_org4 ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'ระดับส่วน/กลุ่มงาน',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "org_5" :    //org5
		try{
		$PARENT_ID=$_POST['PARENT_ID'];			
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		$sql_org4 = "select a.ORG_ID,a.ORG_NAME_TH from SETUP_ORG as a
						where a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID ='".$PARENT_ID."'
						order by ORG_NAME_TH asc";	
		echo get_Select(
			$sql_org5 ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'ORG_ID', 
				's_value'=>'ORG_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'ระดับฝ่าย',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "pos_type" :    //ระดับตำแหน่ง/กลุ่มงาน
		try{
			$POSTYPE_ID	=$_POST['POSTYPE_ID'];	
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$key_index=$_POST['key_index'];
			$mode	=$_POST['mode'];
			
			//ประเภทตำแหน่ง
			$arr=GetSqlSelectArray("TYPE_ID", "TYPE_NAME_TH", "SETUP_POS_TYPE", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID = '".$POSTYPE_ID."' ", "TYPE_SEQ");
			$json["key_index"] = $key_index;
			$json["selectbox"] = GetHtmlSelect($z_id.$key_index,$z_name.$key_index,$arr,'ประเภทตำแหน่ง','','onchange="getPosLevel(this.value,\''.$POSTYPE_ID.'\',\''.$key_index.'\');getPosLine(this.value,\''.$POSTYPE_ID.'\',\''.$key_index.'\');getPosManage(this.value,\''.$POSTYPE_ID.'\',\''.$key_index.'\');"','','1');
			if($mode == "json"){
				echo json_encode($json);	
			}else{
				echo $json["selectbox"];	
			}
		
		}catch(Exception $e){
			$text=$e->getMessage();
		}	
	break;//ประเภทตำแหน่ง 
	
	case "pos_level" :    //ระดับตำแหน่ง/กลุ่มงาน
		try{
			$PARENT_ID=$_POST['PARENT_ID'];	
			$POSTYPE_ID	=$_POST['POSTYPE_ID'];	
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];					
			$key_index=$_POST['key_index'];
			$mode	=$_POST['mode'];
			
			$arr=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", " TYPE_ID= '".$PARENT_ID."' AND ACTIVE_STATUS='1' and DELETE_FLAG='0' AND POSTYPE_ID= '".$POSTYPE_ID."' ", "LEVEL_NAME_TH");
			
			$json["key_index"] = $key_index;
			$json["selectbox"] = GetHtmlSelect($z_id.$key_index,$z_name.$key_index,$arr,'ระดับตำแหน่ง','','','','1');
			if($mode == "json"){
				echo json_encode($json);	
			}else{
				echo $json["selectbox"];	
			}
		}catch(Exception $e){
			$text=$e->getMessage();
		}	
	break;//ระดับตำแหน่ง/กลุ่มงาน 
	
	case "pos_line" : //ตำแหน่งในสายงาน
		try{
			$PARENT_ID=$_POST['PARENT_ID'];	
			$POSTYPE_ID	=$_POST['POSTYPE_ID'];	
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];	
			$key_index=$_POST['key_index'];
			$mode	=$_POST['mode'];
			
			$arr=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", " ACTIVE_STATUS = 1 AND TYPE_ID = '".$PARENT_ID."'  AND POSTYPE_ID= '".$POSTYPE_ID."' ", "LINE_NAME_TH");
			
			$json["key_index"] = $key_index;
			$json["selectbox"] = GetHtmlSelect($z_id.$key_index,$z_name.$key_index,$arr,'ตำแหน่งในสายงาน','','','','1');
			if($mode == "json"){
				echo json_encode($json);	
			}else{
				echo $json["selectbox"];	
			}
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;//ตำแหน่งในสายงาน
	
	case "pos_manage" : //ตำแหน่งในการบริหาร
		try{
			$PARENT_ID=$_POST['PARENT_ID'];	
			$POSTYPE_ID	=$_POST['POSTYPE_ID'];	
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];	
			$key_index=$_POST['key_index'];
			$mode	=$_POST['mode'];
			
			$arr=GetSqlSelectArray("MANAGE_ID", "MANAGE_NAME_TH", "SETUP_POS_MANAGE", " ACTIVE_STATUS = 1 AND (TYPE_ID = '".$PARENT_ID."' OR TYPE_ID IS NULL) AND POSTYPE_ID = '".$POSTYPE_ID."' ", "MANAGE_NAME_TH");

			$json["key_index"] = $key_index;
			$json["selectbox"] = GetHtmlSelect($z_id.$key_index,$z_name.$key_index,$arr,'ตำแหน่งในการบริหาร','','','','1');
			if($mode == "json"){
				echo json_encode($json);	
			}else{
				echo $json["selectbox"];	
			}
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;//ตำแหน่งในการบริหาร
	
	case "get_line" : {
		$PARENT_ID=$_POST['PARENT_ID'];	
		$POSTYPE_ID	=$_POST['POSTYPE_ID'];	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];	
		$key_index=$_POST['key_index'];
		
		$arr=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", " ACTIVE_STATUS = 1 AND TYPE_ID = '".$PARENT_ID."'  AND POSTYPE_ID= '".$POSTYPE_ID."' ", "LINE_NAME_TH");
		echo GetHtmlSelect($z_id.$key_index,$z_name.$key_index,$arr,'ตำแหน่งในสายงาน','','','','1');
		
	}
	break;
	
	case "get_manage" : {
		if($type_id < 4){
			$wh = " AND TYPE_ID IS NULL";
		}else{
			$wh = " AND TYPE_ID = ".$type_id;
		}
		$sql = "Select MANAGE_ID , MANAGE_NAME_TH From SETUP_POS_MANAGE WHERE ACTIVE_STATUS = 1 ".$wh." ORDER BY MANAGE_ID ";
		$query = $db->query($sql);
		echo '<option value="">เลือก</option>';
		while($rec = $db->db_fetch_array($query)){
			echo '<option value="'.text($rec['MANAGE_ID']).'">'.text($rec['MANAGE_NAME_TH']).'</option>';
		}
	}break;
	
	case "get_manage_json" : {
		$POSTYPE_ID	=$_POST['POSTYPE_ID'];	
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];	
		$sql = "Select MANAGE_ID , MANAGE_NAME_TH From SETUP_POS_MANAGE
		WHERE ACTIVE_STATUS = 1 AND TYPE_ID = '".$POSTYPE_ID."' 
		ORDER BY MANAGE_ID ";

		echo get_Select(
			$sql ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'MANAGE_ID', 
				's_value'=>'MANAGE_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>">".$POSTYPE_ID."<",
				's_style'=>""
			)
		);	
	}break;
	
	break;
		case "dec" :    //org3
		try{
		$DEF_ID=$_POST['DEF_ID'];		
		$z_id=$_POST['z_id'];
		$z_name=$_POST['z_name'];
		$z_class=$_POST['z_class'];					
		$sql_dec = "select DEC_ID, DEC_NAME_TH
		 FROM SETUP_DECORATION
		 WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' AND DEF_ID='".$DEF_ID."'";	
		echo get_Select(
			$sql_dec ,
			$db ,
			array(
				'id'=>$z_id,
				'name'=>$z_name,
				'class'=>$z_class,
				's_selected'=>'',
				's_defualt'=>'',
				's_key'=>'DEC_ID', 
				's_value'=>'DEC_NAME_TH',
				's_onchage'=>'',
				's_placeholder'=>'ชั้นเครื่องราชอิสริยาภรณ์',
				's_style'=>""
			)
		);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "get_multi" :
		try{
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];	
			$onchange=$_POST['onchange'];
			$key_index=$_POST['key_index'];
			$mode=$_POST['mode'];
			
			$arr_multi=GetSqlSelectArray("a.MULTIME_ID", "a.MULTIME_NAME_TH", "SETUP_MULTITIME as a ", " a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' ", "a.MULTIME_NAME_TH");
			
			$json["key_index"] = $key_index;
			$json["selectbox"] = GetHtmlSelect($z_id.$key_index, $z_name.$key_index, $arr_multi,'ช่วงเวลาทวีคูณ','','onchange="get_multi_data(this.value, \''.$key_index.'\')"','','1');
			if($mode == "json"){
				echo json_encode($json);	
			}else{
				echo $json["selectbox"];	
			}
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "get_multi_data" :
		try{
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$z_val=$_POST['z_val'];
			$onchange=$_POST['onchange'];
			$key_index=$_POST['key_index'];
			$mode=$_POST['mode'];
			
			$rec_multi = $db->get_data_rec("SELECT MULTIME_SDATE AS sdate, MULTIME_EDATE AS edate, MULTITIME_YEAR as 'year', MULTITIME_MONTH AS 'month', MULTITIME_DAY AS 'day' FROM SETUP_MULTITIME WHERE ACTIVE_STATUS = '1' AND DELETE_FLAG = '0' AND MULTIME_ID = '".$z_val."' ");
			
			$rec_multi['sdate_short'] = $rec_multi['sdate'] != ""?conv_date($rec_multi['sdate'], 'short'):"-";
			$rec_multi['edate_short'] = $rec_multi['sdate'] != ""?conv_date($rec_multi['edate'], 'short'):"-";
			
			echo json_encode($rec_multi);	
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}
