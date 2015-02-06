<?php
header ('Content-type: text/html; charset=utf-8');
$path = "../../../";
include($path."include/config_header_top.php");
//POST
$proc=$_POST['proc'];

switch($proc){
	case "min" : //ระดับต่ำ
		try{
			$v_min=$_POST['v_min'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$level_max=$_POST['level_max'];
			$val=$_POST['val'];
			
			$arr_lv_min=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID='".$v_min."' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_SEQ");

			echo GetHtmlSelect($z_id,$z_name,$arr_lv_min,$arr_txt['level_pos'].'ขั้นต่ำ',$val,'onchange="getLevel2(this,this.value,\'LEVEL_ID_MAX'.'\')"','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "max" : //ระดับสูง
		try{
			$v_max=$_POST['v_max'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$sql_level = "SELECT LEVEL_SEQ, TYPE_ID FROM SETUP_POS_LEVEL WHERE LEVEL_ID ='".$v_max."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'";
			$query = $db->query($sql_level);
			$rec = $db->db_fetch_array($query);
			
			$arr_lv_max=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID =".$rec['TYPE_ID']." and LEVEL_SEQ>=".$rec['LEVEL_SEQ']." and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_SEQ");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_lv_max,$arr_txt['level_pos'].'ขั้นสูง',$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "smin" : //ระดับต่ำ
		try{
			$v_min=$_POST['v_min'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$level_max=$_POST['level_max'];
			$val=$_POST['val'];
			
			$arr_lv_min=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID='".$v_min."' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_SEQ");

			echo GetHtmlSelect($z_id,$z_name,$arr_lv_min,"--ทั้งหมด--",$val,'onchange="getLevel4(this,this.value,\'sLEVEL_ID_MAX'.'\')"','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "smax" : //ระดับสูง
		try{
			$v_max=$_POST['v_max'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$sql_level = "SELECT LEVEL_SEQ, TYPE_ID FROM SETUP_POS_LEVEL WHERE LEVEL_ID ='".$v_max."' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'";
			$query = $db->query($sql_level);
			$num_level = $db->db_num_rows($query);
			$rec = $db->db_fetch_array($query);
			if($num_level > 0){
				$arr_lv_max=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID = '".$rec['TYPE_ID']."' and LEVEL_SEQ >= ".$rec['LEVEL_SEQ']." and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_SEQ");
			}
			echo GetHtmlSelect($z_id,$z_name,$arr_lv_max,"--ทั้งหมด--",$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "get_level" : 
		try{
			$v_level=$_POST['v_level'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$sql_level = "SELECT TYPE_ID FROM SETUP_POS_LEVEL WHERE TYPE_ID ='".$v_level."' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'";
			$query = $db->query($sql_level);
			$rec = $db->db_fetch_array($query);
			
			$arr_lv=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID = ' ".$rec['TYPE_ID']." ' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_SEQ");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_lv,"--ทั้งหมด--",$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;

	case "sget_level" : 
		try{
			$v_level=$_POST['v_level'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$sql_level = "SELECT TYPE_ID FROM SETUP_POS_LEVEL WHERE TYPE_ID ='".$v_level."' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'";
			$query = $db->query($sql_level);
			$rec = $db->db_fetch_array($query);
			
			$arr_lv=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID = ' ".$rec['TYPE_ID']." ' and ACTIVE_STATUS='1' and DELETE_FLAG='0' and POSTYPE_ID = '1'", "LEVEL_SEQ");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_lv,"--ทั้งหมด--",$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	//ทักษะจำเป็นในงานประจำปี
	case "level_pos" : //ระดับตำแหน่ง
		try{
			$v_level=$_POST['v_level'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$arr_lv=GetSqlSelectArray("LEVEL_ID", "LEVEL_NAME_TH", "SETUP_POS_LEVEL", "TYPE_ID='".$v_level."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "LEVEL_SEQ");

			echo GetHtmlSelect($z_id,$z_name,$arr_lv,$arr_txt['level_pos'],$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "line_pos" : //ตำแหน่งในสายงาน
		try{
			$v_line=$_POST['v_line'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$arr_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "LEVEL_ID =".$v_line." and ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LINE_NAME_TH");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_line,$arr_txt['pos_in'],$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
	
	case "get_line" : //ตำแหน่งในสายงาน
		try{
			$arr_line = GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "TYPE_ID =".$type_id." and ACTIVE_STATUS='1' and DELETE_FLAG='0' ", "LINE_NAME_TH");
			
			echo GetHtmlSelect("LINE_ID","LINE_ID",$arr_line, 'ตำแหน่งในสายงาน', $val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
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
	
	case "stamb" : //ตำบล
		try{
			$v_tamb=$_POST['v_tamb'];
			$z_id=$_POST['z_id'];
			$z_name=$_POST['z_name'];
			$z_class=$_POST['z_class'];
			$val=$_POST['val'];
			
			$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$v_tamb."' and ACTIVE_STATUS='1' and DELETE_FLAG='0'", "TAMB_NAME_TH");
			
			echo GetHtmlSelect($z_id,$z_name,$arr_tamb,'ตำบล/แขวง',$val,'','','1');
		}catch(Exception $e){
			$text=$e->getMessage();
		}
	break;
}