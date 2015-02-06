<?php
//====================== Config ========================

//++++++++++++++++++ FUNCTION HTML +++++++++++++++++++++++++++++
/*function setTimeout($servPath,$time){// $time=set timeout period in seconds
	// check to see if $_SESSION['timeout'] is set
	if(isset($_SESSION['timeout'])) {
		// See if the number of seconds since the last
		// visit is larger than the timeout period.
		$duration = time() - (int)$_SESSION['timeout'];
		//echo $duration.">".$time;
		if($duration > $time) {
			//Destroy the session and restart it.
			session_destroy();
			//$servPath ="http://".$_SERVER['HTTP_HOST']."/";
			echo "<script>";
			echo "alert('คุณไม่ได้ใช้งานในระบบ มากว่า 30 นาที กรุณา เข้าสู่ระบบใหม่  (Please Login Before)');window.location='".$servPath."parliament_hr_new/index.php';";
			echo "</script>";
			//session_start();
		}
	}
	$_SESSION['timeout'] = time();
}*/
//Print Report

/*เก็บ LOG การใช้งานในแต่ละหน้า*/
$GLOBALS['path_is'] = $path;
 
 
  


function log_aut($proc, $sys_id, $menu_id, $USER_BY, $TIMESTAMP){
	global $db,$_SESSION;
	
	if($proc=='view'){
		$t_txt="ดูข้อมูล";
	}elseif($proc=='add'){
		$t_txt="เพิ่มข้อมูล";
	}elseif($proc=='edit'){
		$t_txt="แก้ไขข้อมูล";
	}elseif($proc=='del'){
		$t_txt="ลบข้อมูล";
	}

	//AUT_LOG_USER
	if($menu_id){
		$ss_log_id=$_SESSION['ss_log_id'];
		//echo $ss_log_id."=====>".$menu_id."=====>";
		if(($proc=='view' && $ss_log_id!=$menu_id) || ($proc!='view')){
			$db->query("insert into AUT_LOG_USER (AUT_USER_ID,MENU_ID,LOG_DESCRIPTION,CREATEBY,CREATE_TIMESTAMP,UPDATEBY,UPDATE_TIMESTAMP,DELETE_FLAG) 
			values ('".$sys_id."', '".$menu_id."', '".ctext($t_txt.Showmenu($menu_id))."', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0')");
		}
		$_SESSION['ss_log_id']=$menu_id;
	}else{
		unset($_SESSION['ss_log_id']);
	}
}
function datediff_cal($daysDiff){
		 $years = 0; $months = 0; $days = 0;
 		$years = (int)($daysDiff/365);
 		if(($daysDiff%365) != 0){
  			$months = (int)(($daysDiff-($years*365))/30);
 		}
 		$days = ($daysDiff - (($years*365) + ($months*30)));
 		$str_date = $years."-".$months."-".$days;
 		return $str_date;
}
function datediff_cal2($daysDiff){
			 $years = 0; $months = 0; $days = 0;
 			$years = (int)($daysDiff/365);
 			if(($daysDiff%365) != 0){
  			$months = (int)(($daysDiff-($years*365))/30);
			 }
 			$days = ($daysDiff - (($years*365) + ($months*30)));
 			$str_date = $years." ".$months." ".$days."";
		 	return $str_date;
}
function DateDiffPension($daysDiff){
		 $years = 0; $months = 0; $days = 0;
 		$years = (int)($daysDiff/360);
 		if(($daysDiff%360) != 0){
  			$months = (int)(($daysDiff-($years*360))/30);
 		}
 		$days = ($daysDiff - (($years*360) + ($months*30)));
 		$str_date = $years."-".$months."-".$days;
 		return $str_date;
}
function CalAgePension($SDATE, $EDATE){
	//2014-01-30 วันที่
	if(trim($SDATE) != '' and trim($EDATE) != '' ){
	  $ARR_SDATE = explode('-',$SDATE);
	  $ARR_EDATE = explode('-',$EDATE);
	  $T_M  = 0;
	  $T_Y = 0;
	  $A_D = 0;
	  $A_M = 0;
	  $A_Y = 0;
	  (int)$S_D = $ARR_SDATE[2];
	  (int)$S_M = $ARR_SDATE[1];
	  (int)$S_Y = $ARR_SDATE[0];
	  
	  (int)$E_D = $ARR_EDATE[2];
	  (int)$E_M = $ARR_EDATE[1];
	  (int)$E_Y = $ARR_EDATE[0];
	  
	  if($E_D < $S_D){
		  $E_D = $E_D+30;
		  $T_M = 1;
	  }
	  $A_D = ($E_D - $S_D);
	  $E_M = $E_M - $T_M; 
	  if($E_M < $S_M){
		  $E_M = $E_M + 12;
		  $T_Y = 1;
	  }
	  $A_M = $E_M - $S_M;
	  $E_Y = $E_Y - $T_Y;
	  $A_Y = $E_Y - $S_Y;
	  
	  $arr['YEAR'] = $A_Y;
	  $arr['MONTH'] = $A_M;
	  $arr['DAY'] = $A_D;
	   
	}
	return $arr;
}
function PlusAgePension($SDATE, $EDATE){
	//2014-01-30 วันที่
	if(trim($SDATE) != '' and trim($EDATE) != '' ){
	  $ARR_SDATE = explode('-',$SDATE);
	  $ARR_EDATE = explode('-',$EDATE);
	  $T_M  = 0;
	  $T_Y = 0;
	  $A_D = 0;
	  $A_M = 0;
	  $A_Y = 0;
	  $NOW_D = 0;
	  $NOW_M  = 0;
	  (int)$S_D = $ARR_SDATE[2];
	  (int)$S_M = $ARR_SDATE[1];
	  (int)$S_Y = $ARR_SDATE[0];
	  
	  (int)$E_D = $ARR_EDATE[2];
	  (int)$E_M = $ARR_EDATE[1];
	  (int)$E_Y = $ARR_EDATE[0];
	  
	  $A_D = $S_D+$E_D;
	  if($A_D < 30){
		  $NOW_D = $A_D;
	  }else{
		  $MOD_D = $A_D%30;
		  $DIVIDE_D = floor($A_D/30);
		  $NOW_D = $MOD_D;
		  if($DIVIDE_D > 0){
			  $T_M = $DIVIDE_D;
		  }
	  }
	  $A_M = (($S_M+$E_M)+$T_M);
	  if($A_M < 12){
		  $NOW_M = $A_M;
	  }else{
		  $MOD_M = $A_M%12;
		  $NOW_M = $MOD_M;
		  $DIVIDE_M = floor($A_M/12);
		  if($DIVIDE_M > 0){
			  $T_Y = $DIVIDE_M; 
		  }
	}
	$A_Y = ($S_Y+$E_Y)+$T_Y;
	$arr['YEAR'] = $A_Y;
	$arr['MONTH'] = $NOW_M;
	$arr['DAY'] = $NOW_D;
	}
	return $arr;

}
function PrintAll($PageRep){
$print = "<div class=\"btn-group\">
<button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\">
พิมพ์  <span class=\"caret\"></span>
</button>
<ul class=\"dropdown-menu\" role=\"menu\">
<li><a href=\"#\" onClick=\"print_report('pdf','$PageRep');\" >พิมพ์แบบ PDF</a></li>
<li><a href=\"#\" onClick=\"print_report('excel','$PageRep');\" >พิมพ์แบบ EXCEL</a></li>
<li><a href=\"#\" onClick=\"print_report('word','$PageRep');\" >พิมพ์แบบ WORD</a></li>
</ul>
</div>";
return $print;
}
function setTimeout($servPath,$time){// $time=set timeout period in seconds
	// check to see if $_SESSION['timeout'] is set
	if(isset($_SESSION['timeout'])) {
		// See if the number of seconds since the last
		// visit is larger than the timeout period.
		$duration = time() - (int)$_SESSION['timeout'];
		//echo $duration.">".$time;
		if($duration > $time) {
			//Destroy the session and restart it.
			session_destroy();
			//$servPath ="http://".$_SERVER['HTTP_HOST']."/";
			echo "<script>";
			echo "alert('คุณไม่ได้ใช้งานในระบบ มากว่า 30 นาที กรุณา เข้าสู่ระบบใหม่  (Please Login Before)');window.location='".$servPath."parliament_hr_new/index.php';";
			echo "</script>";
			//session_start();
		}
	}
	$_SESSION['timeout'] = time();
}

function form_model($id_model,$title,$id_display='show_display',$w='760',$h='',$s_save='0',$buttom_name='บันทึก'){
	$result="<div id=\"".$id_model."\" class=\"modal fade\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" data-width=\"".$w."\" >
		<div class=\"modal-dialog\" style=\"width:".$w."px\">
			<div class=\"modal-content\">
				<form id=\"frm1\" method=\"post\" action=\"#\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" id=\"proc1\" name=\"proc\" value=\"\">
					<input type=\"hidden\" id=\"menu_id1\" name=\"menu_id\" value=\"\">
					<input type=\"hidden\" id=\"menu_sub_id1\" name=\"menu_sub_id\" value=\"\">
                    <input type=\"hidden\" id=\"SAPA_ID1\" name=\"SAPA_ID\" value=\"\">
					<input type=\"hidden\" id=\"page\" name=\"page\" value=\"1\">
					<div class=\"modal-header\">
						<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
						<h4 class=\"modal-title\" id=\"myModalLabel\">".$title."</h4>
					</div>
					<div id=\"".$id_display."\" class=\"modal-body\" style=\"min-height:220px;overflow-y: auto;\" ></div>
					<div class=\"modal-footer\">
						".($s_save=='1'?"<button type=\"button\" class=\"btn btn-primary\" onclick=\"getSave();\">".$buttom_name."</button>":"")."
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">ปิด</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->";
	return $result;
}
// form_model2 ห้ามลบเด็ดขาดนะ ฟังก์ชันนี้ใช้ในงานวินัย  จริงๆ
function form_model2($id_model,$title,$id_display='show_display2',$w='760',$h='',$s_save='0'){
	$result="<div id=\"".$id_model."\" class=\"modal fade\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" data-width=\"".$w."\">
		<div class=\"modal-dialog\" style=\"width:".$w."px\">
			<div class=\"modal-content\">
				<form id=\"frm1\" method=\"post\" action=\"#\" enctype=\"multipart/form-data\">
					<input type=\"hidden\" id=\"proc1\" name=\"proc\" value=\"\">
					<input type=\"hidden\" id=\"menu_id1\" name=\"menu_id\" value=\"\">
					<input type=\"hidden\" id=\"menu_sub_id1\" name=\"menu_sub_id\" value=\"\">
					<input type=\"hidden\" id=\"page\" name=\"page\" value=\"1\">
					<div class=\"modal-header\">
						<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
						<h4 class=\"modal-title\" id=\"myModalLabel\">".$title."</h4>
					</div>
					<div id=\"".$id_display."\" class=\"modal-body\" style=\"min-height:220px;overflow-y: auto; \"></div>
					<div class=\"modal-footer\">
						".($s_save=='1'?"<button type=\"button\" class=\"btn btn-primary\" onclick=\"getSave();\">บันทึก</button>":"")."
						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">ปิด</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->";
	return $result;
}
//เหมือน form_model ทุกอย่างแต่ไม่มี form
function popup_model($id_model,$title,$id_display='show_display',$w='600',$h=''){
	$result="<div id=\"".$id_model."\" class=\"modal fade\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\" data-width=\"".$w."\" >
		<div class=\"modal-dialog\" style=\"width:".$w."px\">
			<div class=\"modal-content\">
				<div class=\"modal-header\">
					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">&times;</button>
					<h4 class=\"modal-title\" id=\"myModalLabel\">".$title."</h4>
				</div>
				<div id=\"".$id_display."\" class=\"modal-body\" style=\"min-height:220px;overflow-y: auto;\" ></div>
				<div class=\"modal-footer\">
					<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">ปิด</button>
				</div> 
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->";
	return $result;
}

//ข้อความแจ้งเตือน
function list_data($label, $menu, $menu_sub, $sql, $link, $level="", $cond="", $c_self=""){
	global $db, $menu_id;
	
	$r_loop0=loopMenu($menu);
	$lvl0=$r_loop0['MENU_ID'];//level0
		$path_system=explode("/",$r_loop0['MENU_URL']);
	
	$lvl1=$menu;//level1
	
	$r_loop2=loopMenu($menu_sub);
	$lvl2=$r_loop2['MENU_ID'];//level2
	
	if($lvl1==$lvl2){
		$lvl2=$menu_sub;//level2
		$c_menu=@count($_SESSION['sys_group_menu'][$lvl0][$lvl1][$lvl2]);
	}else{
		if($level==4){//กรณี level 4
			$lvl3=$lvl2;
			
			$r_loop22=loopMenu($lvl3);
			$lvl2=$r_loop22['MENU_ID'];//level2
			
			$lvl4=$menu_sub;//level4
			$c_menu=@count($_SESSION['sys_group_menu'][$lvl0][$lvl1][$lvl2][$lvl3][$lvl4]);
		}else{
			$lvl3=$menu_sub;//level3
			$c_menu=@count($_SESSION['sys_group_menu'][$lvl0][$lvl1][$lvl2][$lvl3]);
		}
	}
	//echo "<br>0=>".$lvl0."<br>1=>".$lvl1."<br>2=>".$lvl2."<br>3=>".$lvl3."<br>4=>".$lvl4;
	//echo $c_menu."==".$c_self;
	if($c_menu>0 || $c_self=='1'){
		$main['label']=$label;
		if($c_self=='1'){
			$main['link']=$link;
		}else{
			$main['link']=($menu_id==0?$path_system[0]."/".$path_system[1]:"../".$path_system[1])."/".$link;
		}
		$main['menu_id']=$menu;
		$main['menu_sub_id']=$menu_sub;
		$main['cond']=$cond;
		$main['count']=$db->db_num_rows($db->query($sql));
		$main['date']="11 เม.ย. 2557";
	}
	return $main;
}

//selectbox
function GetHtmlSelect($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	if($type == '0'){
		$result = text($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj;
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"selectbox form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".($encode=='2'?$val:text($val))."</option>";
				}
			} else {
				$selectlist.="<option value = \"\" $selected> -- $data -- </option>";
			}
			$selectlist.= "</select>";
			$result = $selectlist;
	}
	return $result;
}#end function


//selectbox
function GetHtmlSelect_v($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	if($type == '0'){
		$result = text($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj;
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"selectbox form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".($encode=='2'?$val:text($val))."</option>";
					if($key==trim($selectobj)){
					   $sdata  = text($val);
					}
				}
			} else {
				$selectlist.="<option value = \"0\" $selected> -- $data -- </option>";
				$sdata = "";
			}
			$selectlist.= "</select>";
			$result = $selectlist;
			$result = $sdata;
	}
	return $result;
}#end function


function GetHtmlSelect_v2($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	if($type == '0'){
		$result = text($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj;
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"selectbox form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".($encode=='2'?$val:text($val))."</option>";
					if($key==trim($selectobj)){
					   $sdata  = $val;
					}
				}
			} else {
				$selectlist.="<option value = \"0\" $selected> -- $data -- </option>";
				$sdata = "";
			}
			$selectlist.= "</select>";
			$result = $selectlist;
			$result = $sdata;
	}
	return $result;
}#end function



//no selectbox
function GetHtmlSelect2($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	if($type == '0'){
		$result = text($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj;
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".($encode=='2'?$val:text($val))."</option>";
				}
			} else {
				$selectlist.="<option value = \"0\" $selected> -- $data -- </option>";
			}
			$selectlist.= "</select>";
			$result = $selectlist;
	}
	return $result;
}#end function


function GetHtmlSelect3($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	//echo $type; exit();
	if($type == '0'){
		$result = text($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj; 
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";   
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"selectbox form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			 
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".($encode=='2'?$val:text($val))."</option>";
				}
			} else {
				$selectlist.="<option value = \"0\" $selected> -- $data -- </option>";
			}
			$selectlist.= "</select>";
			$result = $selectlist;
	}
	return $result;
}#end function

function GetHtmlSelect4($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	//echo $type; exit();
	if($type == '0'){
		$result = text($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj; 
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";   
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"selectbox form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			 
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".$val."</option>";
				}
			} else {
				$selectlist.="<option value = \"0\" $selected> -- $data -- </option>";
			}
			$selectlist.= "</select>";
			$result = $selectlist;
	}
	return $result;
}#end function



//selectbox no convert
function GetHtmlSelectNoConv($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	if($type == '0'){
		$result = ($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj;
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"selectbox form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".($encode=='2'?$val:($val))."</option>";
				}
			} else {
				$selectlist.="<option value = '' $selected> -- $data -- </option>";
			}
			$selectlist.= "</select>";
			$result = $selectlist;
	}
	return $result;
}#end function

//selectbox no convert
function GetHtmlSelectNoConv_v($idobj, $nameobj, $valobj, $title="", $selectobj="", $event="",$class="", $type="", $w="300", $encode="1"){
	// 0 = View, 1 = Manage
	if($type == '0'){
		$result = ($valobj[$selectobj]);
	}else{
			$data = 'ไม่พบข้อมูล';
			$selectobj = (string)$selectobj;
			$idobj = (!$idobj) ? "$nameobj" : "$idobj";
			$selectlist = "<select name = \"$nameobj\" id = \"$idobj\" placeholder=\"{$title}\" class = \"selectbox form-control {$class}\" {$event} style=\"width:{$w}px;\"> ";
			if(sizeof($valobj)>0) {
				$selectlist.= ($title) ? "<option value = \"\"></option>" : "";
				while(list($key, $val) = each($valobj)){
					$key = (string)$key;
					$selected = ($key==trim($selectobj)) ? "selected" : ""; 
					$selectlist.= "<option value = \"".$key."\" {$selected}>".($encode=='2'?$val:($val))."</option>";
					if($key==trim($selectobj)){
					   $sdata  = $val;
					}
				}
			} else {
				$selectlist.="<option value = '' $selected> -- $data -- </option>";
				 $sdata = '';
			}
			$selectlist.= "</select>";
			$result = $selectlist;
			$result = $sdata;
	}
	return $result;
}#end function




function GetSqlSelectArray($fieldvalue, $fieldlabel, $tablename, $whereobj, $fieldOrder='',$is_DISTINCT='' ){
	global $db;

	$checkfieldval = explode(".", $fieldvalue);
	$indexfieldval = (count($checkfieldval) > 1)?$checkfieldval[1]:$fieldvalue;
	
	$fieldname=explode(" as ", $fieldlabel);
	if(count($fieldname)>1){
		$indexfieldlabel = $fieldname[1];
	}else{
		$checkfieldlabel = explode(".", $fieldlabel);
		$indexfieldlabel = (count($checkfieldlabel) > 1)?$checkfieldlabel[1]:$fieldlabel;
	}
	
	if($fieldOrder!='') {
		$s_query="SELECT ".$is_DISTINCT." $fieldvalue,$fieldlabel FROM $tablename WHERE $whereobj ORDER BY $fieldOrder ";
	}else{
		$s_query="SELECT  ".$is_DISTINCT."  $fieldvalue,$fieldlabel FROM $tablename WHERE $whereobj ORDER BY $fieldlabel ";
	}
	//echo $s_query."<BR><BR>";
	//exit ;
	$query_arr = $db->query($s_query);
	$arr = array();
	while($rec = $db->db_fetch_array($query_arr)){
		//$rec = @array_change_key_case($rec, CASE_LOWER);
		//$arr[trim($rec[$indexfieldval])] =ctext($rec[$indexfieldlabel]);
		$arr[trim($rec[$indexfieldval])] =$rec[$indexfieldlabel];
	}
	return $arr;
}#end function


function GetSqlSelectArray4($fieldvalue, $fieldlabel, $tablename, $whereobj, $fieldOrder='',$is_DISTINCT='' ){
	global $db;

	$checkfieldval = explode(".", $fieldvalue);
	$indexfieldval = (count($checkfieldval) > 1)?$checkfieldval[1]:$fieldvalue;
	
	$fieldname=explode(" as ", $fieldlabel);
	if(count($fieldname)>1){
		$indexfieldlabel = $fieldname[1];
	}else{
		$checkfieldlabel = explode(".", $fieldlabel);
		$indexfieldlabel = (count($checkfieldlabel) > 1)?$checkfieldlabel[1]:$fieldlabel;
	}
	
	if($fieldOrder!='') {
		$s_query="SELECT ".$is_DISTINCT." $fieldvalue,$fieldlabel FROM $tablename WHERE $whereobj ORDER BY $fieldOrder ";
	}else{
		$s_query="SELECT  ".$is_DISTINCT."  $fieldvalue,$fieldlabel FROM $tablename WHERE $whereobj ORDER BY $fieldlabel ";
	}
	 echo $s_query."<BR><BR>";
	 exit ;
	$query_arr = $db->query($s_query);
	$arr = array();
	while($rec = $db->db_fetch_array($query_arr)){
		//$rec = @array_change_key_case($rec, CASE_LOWER);
		//$arr[trim($rec[$indexfieldval])] =ctext($rec[$indexfieldlabel]);
		$arr[trim($rec[$indexfieldval])] =$rec[$indexfieldlabel];
	}
	return $arr;
}#end function



function GetSqlSelectArray2($fieldvalue, $fieldlabel, $tablename, $whereobj, $fieldOrder=''){
	global $db;

	$checkfieldval = explode(".", $fieldvalue);
	$indexfieldval = (count($checkfieldval) > 1)?$checkfieldval[1]:$fieldvalue;
	
	$fieldname=explode(" as ", $fieldlabel);
	if(count($fieldname)>1){
		$indexfieldlabel = $fieldname[1];
	}else{
		$checkfieldlabel = explode(".", $fieldlabel);
		$indexfieldlabel = (count($checkfieldlabel) > 1)?$checkfieldlabel[1]:$fieldlabel;
	}
	
	if($fieldOrder!='') {
		$s_query="SELECT $fieldvalue,$fieldlabel FROM $tablename WHERE $whereobj ORDER BY $fieldOrder ";
	}else{
		$s_query="SELECT $fieldvalue,$fieldlabel FROM $tablename WHERE $whereobj ORDER BY $fieldlabel ";
	}
	//echo $s_query."<BR><BR>";
	//exit ;
	$query_arr = $db->query($s_query);
	$arr = array();
	while($rec = $db->db_fetch_array($query_arr)){
		//$rec = @array_change_key_case($rec, CASE_LOWER);
		//$arr[trim($rec[$indexfieldval])] =ctext($rec[$indexfieldlabel]);
		$arr[trim($rec[$indexfieldval])] =$rec[$indexfieldlabel];
	}
	return $arr;
}#end function




//====================== Config ========================
function sqlpaging($field,$table,$where,$notInto,$groupby,$orderby,$page_size,$page){
	global $startPage, $endPage, $page;
	$sql = 'select   '.$field.'  from '.$table.'  '.$where.'  '. $groupby.' '. $orderby	;
	if($page=='' || $page =='0'){
		$page=1;
	}
	$start_row = ($page-1)*$page_size;
	$end_row = $start_row+$page_size;
	$sqltable = $sql . " LIMIT $start_row , $page_size";
	//$sqltable ="SELECT b.* from ( select ROWNUM mynum, a.* from ( ".$sql .") a  where ROWNUM <".($end_row+1)."  ) b  where mynum >=  ".($start_row+1)." ";
	return $sqltable;
}

function gettag_style(){
	echo "class = 'Record_tag' onMouseOver='this.className=\"Record_tag_Hover\"' onMouseOut='this.className=\"Record_tag\"'";
}
function getrow_style($var, $hover=""){
	if($hover){
		if($var%2=='0'){
			$style = "class = 'Record_Even' onMouseOver='this.className=\"Record_Hover\"' onMouseOut='this.className=\"Record_Even\"'";
		}else{
			$style = "class = 'Record_Odd' onMouseOver='this.className=\"Record_Hover\"' onMouseOut='this.className=\"Record_Odd\"'";
		}
	}else{
		if($var%2=='0'){
			$style = "class = 'Record_Even'";
		}else{
			$style = "class = 'Record_Odd'";
		}
	}
	return $style;
}
function getrow_stylela($var, $hover=""){
	if($hover){
		if($var%2=='0'){
			$style = "class = 'Recordpc_Even' onMouseOver='this.className=\"Recordpc_Hover\"' conMouseOut='this.className=\"Recordpc_Even\"'";
		}else{
			$style = "class = 'Recordpc_Odd' onMouseOver='this.className=\"Recordpc_Hover\"' onMouseOut='this.className=\"Recordpc_Odd\"'";
		}
	}else{
		if($var%2=='0'){
			$style = "class = 'Recordpc_Even'";
		}else{
			$style = "class = 'Recordpc_Odd'";
		}
	}
	return $style;
}

//func ค้นหาจากชื่อปัจุบัน + ชื่อเดิม
function searchName($name,$stype){
	//explode กรณีระบุ table
	$arrtype=@explode(".",$stype);
	if(@count($arrtype)>1){
		$type=$arrtype['1'];
	}else{
		$type=$stype;
	}

	if($type=='PER_ID'){
		//now
		$fname="PER_FIRSTNAME_TH";
		$mname="PER_MIDNAME_TH";
		$lname="PER_LASTNAME_TH";
		//old
		$fname2="NAMEHIS_LAST_FIRSTNAME_TH";
		$mname2="NAMEHIS_LAST_MIDNAME_TH";
		$lname2="NAMEHIS_LAST_LASTNAME_TH";
		//table
		$table="PER_PROFILE";
		$table2="PER_NAMEHIS";
	}elseif($type=='SS_ID'){//default
		//now
		$fname="SS_FIRSTNAME_TH";
		$mname="SS_MIDNAME_TH";
		$lname="SS_LASTNAME_TH";
		//old
		$fname2="CHANGE_LAST_FIRSTNAME_TH";
		$mname2="CHANGE_LAST_MIDNAME_TH";
		$lname2="CHANGE_LAST_LASTNAME_TH";
		//table
		$table="SS_PROFILE";
		$table2="SS_NAMEHIS";
	}elseif($type=='SP_ID'){
		//now
		$fname="SP_FIRSTNAME_TH";
		$mname="SP_MIDNAME_TH";
		$lname="SP_LASTNAME_TH";
		//old
		$fname2="CHANGE_LAST_FIRSTNAME_TH";
		$mname2="CHANGE_LAST_MIDNAME_TH";
		$lname2="CHANGE_LAST_LASTNAME_TH";
		//table
		$table="SP_PROFILE";
		$table2="SP_NAMEHIS";
	}
	//now
	$text=" and (
		({$fname} like '%{$name}%')
		OR
		({$mname} like '%{$name}%')
		OR
		({$lname} like '%{$name}%')
		OR
		({$fname}+' '+{$mname}+'  '+{$lname} like '%{$name}%')
		OR
		({$fname}+'  '+{$lname} like '%{$name}%')
	)";
	//old
	$text2=" and (
		({$fname2} like '%{$name}%')
		OR
		({$mname2} like '%{$name}%')
		OR
		({$lname2} like '%{$name}%')
		OR
		({$fname2}+' '+{$mname2}+'  '+{$lname2} like '%{$name}%')
		OR
		({$fname2}+'  '+{$lname2} like '%{$name}%')
	)";
	
	if($type=='PER_ID' || $type=='SS_ID' || $type=='SP_ID'){
		$result=" and (
			{$stype} in (select {$type} from {$table} where 1=1 ".$text." group by {$type})
			OR
			{$stype} in (select {$type} from {$table2} where 1=1 ".$text2." group by {$type})
		)";
	}else{
		$result="";
	}
	
	return $result;
}

//ประเภท ส.ส. (ลำดับที่ในบัญชีชื่อ - สกุล) / จังหวัด (เขตการเลือกตั้ง)
/*function get_sstype_all($SS_TYPE_ID,$SSP_PARTY_LIST,$PROV_ID,$SSP_DISTRICT_ID){
	global $arr_type_ss, $arr_prov;
	
	if($SS_TYPE_ID=='1'){
		$result=($PROV_ID=='1'?"":"").text($arr_prov[$PROV_ID])." (".$SSP_DISTRICT_ID.")";
                
	}elseif($SS_TYPE_ID=='7'){
		$result=text($arr_type_ss[$SS_TYPE_ID])." (".$SSP_PARTY_LIST.")";
	}else{
		$result="<center>-</center>";
	}
	return $result;
}*/

function tranfer_ss_form($table, $SS_ID, $SAPA_ID){
	global $db;
	
	if($table=='SS_FORM_PROFILE'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_PROFILE where SS_ID='".$SS_ID."' and SAPA_ID='".$SAPA_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_PROFILE where SS_ID='".$SS_ID."' and SAPA_ID='".$SAPA_ID."'");
		}
		$sql_profile=$db->query("INSERT into SS_FORM_PROFILE 
		(SS_ID, SAPA_ID, SS_IDCARD, SS_CODE, SS_PICTURE, SS_FILE, SS_SIGN_FILE, PT_ID, PREFIX_ID, SS_FIRSTNAME_TH, SS_MIDNAME_TH, SS_LASTNAME_TH, SS_FIRSTNAME_SPELL, SS_MIDNAME_SPELL, SS_LASTNAME_SPELL, SS_FIRSTNAME_EN, SS_MIDNAME_EN, SS_LASTNAME_EN, SS_GENDER, SS_BIRTH_DATE, NATION_ID, RACE_NATION_ID, RELIGION_ID, SS_BLOOD_ID, SS_COLOR_SKIN_TH, SS_COLOR_SKIN_EN, SS_COLOR_EYE_TH, SS_COLOR_EYE_EN, SS_COLOR_HAIR_TH, SS_COLOR_HAIR_EN, SS_MARKUP_SKIN, SS_HEIGHT, SS_WEIGHT, SS_LAST_JOB_ID, SS_LAST_JOB_NAME, SS_LAST_POSITION_ID, SS_LAST_POSITION_NAME, SS_LAST_WORKPLACE, SS_MOBILE, SS_EMAIL, SS_MARRY_STATUS, SS_STATUS, DOC_RECEIVE_ID, DOC_RECEIVE_NO, DOC_RECEIVE_DATE, SS_EXP_POLITICS, SS_LAST_TEL_1, SS_LAST_TEL_2, SS_LAST_FAX_1, SS_LAST_FAX_2, SS_LAST_TEL_1_EXT, SS_LAST_TEL_2_EXT, SS_TYPE_ID, PARTY_ID, SS_ELECTION_DATE, SS_PARTY_LIST, SS_DISTRICT_PROV_ID, SS_DISTRICT_NO, ACTIVE_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
		(select SS_ID, SAPA_ID, SS_IDCARD, SS_CODE, SS_PICTURE, SS_FILE, SS_SIGN_FILE, PT_ID, PREFIX_ID, SS_FIRSTNAME_TH, SS_MIDNAME_TH, SS_LASTNAME_TH, SS_FIRSTNAME_SPELL, SS_MIDNAME_SPELL, SS_LASTNAME_SPELL, SS_FIRSTNAME_EN, SS_MIDNAME_EN, SS_LASTNAME_EN, SS_GENDER, SS_BIRTH_DATE, NATION_ID, RACE_NATION_ID, RELIGION_ID, SS_BLOOD_ID, SS_COLOR_SKIN_TH, SS_COLOR_SKIN_EN, SS_COLOR_EYE_TH, SS_COLOR_EYE_EN, SS_COLOR_HAIR_TH, SS_COLOR_HAIR_EN, SS_MARKUP_SKIN, SS_HEIGHT, SS_WEIGHT, SS_LAST_JOB_ID, SS_LAST_JOB_NAME, SS_LAST_POSITION_ID, SS_LAST_POSITION_NAME, SS_LAST_WORKPLACE, SS_MOBILE, SS_EMAIL, SS_MARRY_STATUS, '1', DOC_RECEIVE_ID, DOC_RECEIVE_NO, DOC_RECEIVE_DATE, SS_EXP_POLITICS, SS_LAST_TEL_1, SS_LAST_TEL_2, SS_LAST_FAX_1, SS_LAST_FAX_2, SS_LAST_TEL_1_EXT, SS_LAST_TEL_2_EXT, SS_TYPE_ID, PARTY_ID, SSP_ELECTION_DATE, SSP_PARTY_LIST, PROV_ID, SSP_DISTRICT_ID, '1', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
		from V_SAPA_LIST where SS_ID='".$SS_ID."' and ACTIVE_STATUS='1')");
	}
	if($table=='SS_FORM_ADDRESS'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_ADDRESS where SS_ID='".$SS_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_ADDRESS where SS_ID='".$SS_ID."'");
		} // if
		
		$sql_addr=$db->query("select * from SS_ADDRESS where SS_ID='".$SS_ID."' and ACTIVE_STATUS='1'");
		$num_addr=$db->db_num_rows($sql_addr);
		if($num_addr>0){
			while($data_addr=$db->db_fetch_array($sql_addr)){
				$sql_addr2=$db->query("INSERT into SS_FORM_ADDRESS 
				(SS_ID, SSA_ROOM_NO, SSA_BUILDING, SSA_HOMENO, SSA_MOO, SSA_SOI, SSA_VILLAGE, SSA_ROAD, SSA_TAMB_ID, SSA_AMPR_ID, SSA_PROV_ID, SSA_ZIPCODE, COUNTRY_ID, SSA_OTHER_COUNTRY, SSA_TYPE, REQUEST_ID, REQUEST_RESULT, REQUEST_STATUS, SSA_EMAIL, SSA_PUBLIC, SSA_TEL_1, SSA_TEL_2, SSA_TEL_3, SSA_TEL_4, SSA_FAX_1, SSA_FAX_2, SSA_MOBILE_1, SSA_MOBILE_2, SSA_TEL_1_EXT, SSA_TEL_2_EXT, SSA_TEL_3_EXT, SSA_TEL_4_EXT, ACTIVE_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, SSA_ROOM_NO, SSA_BUILDING, SSA_HOMENO, SSA_MOO, SSA_SOI, SSA_VILLAGE, SSA_ROAD, SSA_TAMB_ID, SSA_AMPR_ID, SSA_PROV_ID, SSA_ZIPCODE, COUNTRY_ID, SSA_OTHER_COUNTRY, SSA_TYPE, REQUEST_ID, REQUEST_RESULT, REQUEST_STATUS, SSA_EMAIL, SSA_PUBLIC, SSA_TEL_1, SSA_TEL_2, SSA_TEL_3, SSA_TEL_4, SSA_FAX_1, SSA_FAX_2, SSA_MOBILE_1, SSA_MOBILE_2, SSA_TEL_1_EXT, SSA_TEL_2_EXT, SSA_TEL_3_EXT, SSA_TEL_4_EXT, '1', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_ADDRESS where SSA_ID='".$data_addr['SSA_ID']."')");
			} // while
		} //if 
	}//if 
	
	if($table=='SS_FORM_CONTACT'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_CONTACT where SS_ID='".$SS_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_CONTACT where SS_ID='".$SS_ID."'");
		}
		
		$sql_contact=$db->query("select * from SS_CONTACT where SS_ID='".$SS_ID."' and ACTIVE_STATUS='1'");
		$num_contact=$db->db_num_rows($sql_contact);
		if($num_contact>0){
			while($data_contact=$db->db_fetch_array($sql_contact)){
				$sql_contact2=$db->query("INSERT into SS_FORM_CONTACT 
				(SS_ID, SSC_IDCARD, SSC_PREFIX_ID, SSC_FIRSTNAME_TH, SSC_MIDNAME_TH, SSC_LASTNAME_TH, SSC_FIRSTNAME_EN, SSC_MIDNAME_EN, SSC_LASTNAME_EN, RELIGION_ID, NATION_ID, RACE_NATION_ID, SSC_HOMENO, SSC_MOO, SSC_SOI, SSC_ROAD, SSC_TAMB_ID, SSC_AMPR_ID, SSC_PROV_ID, SSC_ZIPCODE, SSC_TEL, SSC_FAX, SSC_MOBILE, JOB_ID, JOBPOS_ID, COUNTRY_ID, SSC_OTHER_COUNTRY, SSC_TYPE, SSC_STATUS, REQUEST_ID, REQUEST_STATUS, REQUEST_RESULT,  JOB_NAME, JOBPOS_NAME, ACTIVE_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, SSC_IDCARD, SSC_PREFIX_ID, SSC_FIRSTNAME_TH, SSC_MIDNAME_TH, SSC_LASTNAME_TH, SSC_FIRSTNAME_EN, SSC_MIDNAME_EN, SSC_LASTNAME_EN, RELIGION_ID, NATION_ID, RACE_NATION_ID, SSC_HOMENO, SSC_MOO, SSC_SOI, SSC_ROAD, SSC_TAMB_ID, SSC_AMPR_ID, SSC_PROV_ID, SSC_ZIPCODE, SSC_TEL, SSC_FAX, SSC_MOBILE, JOB_ID, JOBPOS_ID, COUNTRY_ID, SSC_OTHER_COUNTRY, SSC_TYPE, SSC_STATUS, REQUEST_ID, REQUEST_STATUS, REQUEST_RESULT,  JOB_NAME, JOBPOS_NAME, '1', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_CONTACT where SSC_ID='".$data_contact['SSC_ID']."')");
			}
		}
	}
	if($table=='SS_FORM_MARRYHIS'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_MARRYHIS where SS_ID='".$SS_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_MARRYHIS where SS_ID='".$SS_ID."'");
		}
		
		$sql_marry=$db->query("select * from SS_MARRYHIS where SS_ID='".$SS_ID."'");
		$num_marry=$db->db_num_rows($sql_marry);
		if($num_marry>0){
			while($data_marry=$db->db_fetch_array($sql_marry)){
				$sql_marry2=$db->query("INSERT into SS_FORM_MARRYHIS 
				(SS_ID, PT_ID, MARRY_SEQ, MARRY_IDCARD, MARRY_PREFIX_ID, MARRY_FIRSTNAME_TH, MARRY_MIDNAME_TH, MARRY_LASTNAME_TH, MARRY_FIRSTNAME_EN,MARRY_MIDNAME_EN, MARRY_LASTNAME_EN, MARRY_O_LASTNAME_TH, MARRY_O_LASTNAME_EN, RELIGION_ID, NATION_ID, RACE_NATION_ID, MARRY_JOB_ID, MARRY_JOB_POS_ID, MARRY_JOB_PLACE, MARRY_JOB_TEL_1, MARRY_JOB_FAX_1, MARRY_TYPE ,MARRY_STATUS, REQUEST_ID, REQUEST_RESULT, REQUEST_STATUS, MARRY_JOB_TEL_2, MARRY_JOB_FAX_2, MARRY_JOB_NAME, MARRY_JOB_POS_NAME, MARRY_MOBILE, MARRY_JOB_TEL_1_EXT, MARRY_JOB_TEL_2_EXT, ACTIVE_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, PT_ID, MARRY_SEQ, MARRY_IDCARD, MARRY_PREFIX_ID, MARRY_FIRSTNAME_TH, MARRY_MIDNAME_TH, MARRY_LASTNAME_TH, MARRY_FIRSTNAME_EN,MARRY_MIDNAME_EN, MARRY_LASTNAME_EN, MARRY_O_LASTNAME_TH, MARRY_O_LASTNAME_EN, RELIGION_ID, NATION_ID, RACE_NATION_ID, MARRY_JOB_ID, MARRY_JOB_POS_ID, MARRY_JOB_PLACE, MARRY_JOB_TEL_1, MARRY_JOB_FAX_1, MARRY_TYPE ,MARRY_STATUS, REQUEST_ID, REQUEST_RESULT, REQUEST_STATUS, MARRY_JOB_TEL_2, MARRY_JOB_FAX_2, MARRY_JOB_NAME, MARRY_JOB_POS_NAME, MARRY_MOBILE, MARRY_JOB_TEL_1_EXT, MARRY_JOB_TEL_2_EXT, '1', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_MARRYHIS where SS_ID='".$SS_ID."' and MARRY_ID='".$data_marry['MARRY_ID']."')");
			}
		}
	}
	if($table=='SS_FORM_CHILD'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_CHILD where SS_ID='".$SS_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_CHILD where SS_ID='".$SS_ID."'");
		}
		
		$sql_child=$db->query("select * from SS_CHILD where SS_ID='".$SS_ID."'");
		$num_child=$db->db_num_rows($sql_child);
		if($num_child>0){
			while($data_child=$db->db_fetch_array($sql_child)){
				$sql_child2=$db->query("INSERT into SS_FORM_CHILD 
				(SS_ID, CHILD_SEQ, CHILD_IDCARD, CHILD_PREFIX_ID, CHILD_FIRSTNAME_TH, CHILD_MIDNAME_TH, CHILD_LASTNAME_TH, CHILD_FIRSTNAME_EN, CHILD_MIDNAME_EN, CHILD_LASTNAME_EN, CHILD_BIRTHDATE, CHILD_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, CHILD_SEQ, CHILD_IDCARD, CHILD_PREFIX_ID, CHILD_FIRSTNAME_TH, CHILD_MIDNAME_TH, CHILD_LASTNAME_TH, CHILD_FIRSTNAME_EN, CHILD_MIDNAME_EN, CHILD_LASTNAME_EN, CHILD_BIRTHDATE, CHILD_STATUS, '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_CHILD where SS_ID='".$SS_ID."' and CHILD_ID='".$data_child['CHILD_ID']."' )");
			}
		}
	}
	if($table=='SS_FORM_EDUCATEHIS'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_EDUCATEHIS where SS_ID='".$SS_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_EDUCATEHIS where SS_ID='".$SS_ID."'");
		}
		
		$sql_edu=$db->query("select * from SS_EDUCATEHIS where SS_ID='".$SS_ID."' and ACTIVE_STATUS='1'");
		$num_edu=$db->db_num_rows($sql_edu);
		if($num_edu>0){
			while($data_edu=$db->db_fetch_array($sql_edu)){
				$sql_edu2=$db->query("INSERT into SS_FORM_EDUCATEHIS 
				(SS_ID, EDU_SEQ, EDU_SDATE, EDU_EDATE, EL_ID, ED_ID, ED_NAME, EM_ID, EM_NAME, INS_ID, INS_NAME, COUNTRY_ID, EDU_GPA, EDU_HONOR, ACTIVE_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, EDU_SEQ, EDU_SDATE, EDU_EDATE, EL_ID, ED_ID, ED_NAME, EM_ID, EM_NAME, INS_ID, INS_NAME, COUNTRY_ID, EDU_GPA, EDU_HONOR, '1', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_EDUCATEHIS where EDU_ID='".$data_edu['EDU_ID']."')");
			}
		}
	}
	if($table=='SS_FORM_DECORATEHIS'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_DECORATEHIS where SS_ID='".$SS_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_DECORATEHIS where SS_ID='".$SS_ID."'");
		}
		
		//$sql_dec=$db->query("select * from SS_DECORATEHIS where SS_ID='".$SS_ID."' and ACTIVE_STATUS='1'");
		$sql_dec=$db->query("select * from SS_DECORATEHIS where SS_ID='".$SS_ID."' ");
		$num_dec=$db->db_num_rows($sql_dec);
		if($num_dec>0){
			while($data_dec=$db->db_fetch_array($sql_dec)){
				/*$sql_dec2=$db->query("INSERT into SS_FORM_DECORATEHIS 
				(SS_ID, DEF_ID, DEC_ID, SDEH_GAZZETTE_DATE, ORG_ID, ORG_NAME, DEC_LEVEL, ACTIVE_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, DEF_ID, DEC_ID, SDEH_GAZZETTE_DATE, ORG_ID, ORG_NAME, DEC_LEVEL, '1', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_DECORATEHIS where SDEH_ID='".$data_dec['SDEH_ID']."')");*/
				$sql_dec2=$db->query("INSERT into SS_FORM_DECORATEHIS 
				(SS_ID, DEF_ID, DEC_ID, SDEH_GAZZETTE_DATE, ORG_ID, ORG_NAME, DEC_LEVEL, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, DEF_ID, DEC_ID, SDEH_GAZZETTE_DATE, ORG_ID, ORG_NAME, DEC_LEVEL, '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_DECORATEHIS where SDEH_ID='".$data_dec['SDEH_ID']."')");
			}
		}
	}
	if($table=='SS_FORM_TRAINHIS'){
		$num_a=$db->db_num_rows($db->query("select * from SS_FORM_TRAINHIS where SS_ID='".$SS_ID."'"));
		if($num_a>0){
			$db->query("delete SS_FORM_TRAINHIS where SS_ID='".$SS_ID."'");
		}
		
		$sql_train=$db->query("select * from SS_TRAINHIS where SS_ID='".$SS_ID."' and ACTIVE_STATUS='1'");
		$num_train=$db->db_num_rows($sql_train);
		if($num_train>0){
			while($data_train=$db->db_fetch_array($sql_train)){
				$sql_train2=$db->query("INSERT into SS_FORM_TRAINHIS 
				(SS_ID, TRAHIS_TYPE, TRAHIS_NAME, TRAHIS_GEN_ID, COUNTRY_ID, TRAHIS_FORM, ACTIVE_STATUS, CREATE_BY, CREATE_DATE, UPDATE_BY, UPDATE_DATE, DELETE_FLAG) 
				(select SS_ID, TRAHIS_TYPE, TRAHIS_NAME, TRAHIS_GEN_ID, COUNTRY_ID, TRAHIS_FORM, '1', '".$USER_BY."', '".$TIMESTAMP."', '".$USER_BY."', '".$TIMESTAMP."', '0'
				from SS_TRAINHIS where TRAHIS_ID='".$data_train['TRAHIS_ID']."')");
			}
		}
	}
}

function orderbycolumn($formname, $index, $column){
	global $columnname, $ascdesc, $path;
	if($index==$columnname && $ascdesc=='asc'){
		$ascdesclist = "desc";
		$iconlist = "<img src=\"$path../icons/arrow_up.gif\" border=\"0\">";
	}elseif($index==$columnname && $ascdesc=='desc'){
		$ascdesclist = "asc";
		$iconlist = "<img src=\"$path../icons/arrow_down.gif\" border=\"0\">";
	}else{
		$ascdesclist = "asc";
	}
	$columnlist = "<span onclick=\"document.getElementById('columnname').value=$index;document.getElementById('ascdesc').value='$ascdesclist';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#0033FF'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">$column$iconlist</span>";
	return $columnlist;
}

function pagingzone($num,$formname,$allrows,$page_show,$page_size,$char_sub, $type=''){
	global $startPage, $endPage, $page;
	$totalpage = calculate_page($allrows, $page_size);
	$startPages = findrange_page($page_show, $totalpage, $page, $startPage, $endPage, "min");
	$endPages = findrange_page($page_show, $totalpage, $page, $startPage, $endPage, "max");
	$paginglist.= "<span class=\"headpager\">หน้า</span>&nbsp;:&nbsp;".paging($formname, $allrows, $page_show, $page_size, $char_sub, $startPages, $endPages, $page);//????????? page
	//$paginglist.= "&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"headpager\">Go&nbsp;to&nbsp;:</span>&nbsp;<input name=\"page$num\" type=\"text\" size=\"2\"  class=\"textbox\" value=\"$page\" style=\"text-align:center\" id=\"page$num\">&nbsp;<span class=\"headpager\">/";
	//$paginglist.= $totalpage;
	//$paginglist.= "&nbsp;Pages</span>&nbsp;<input id=\"go$num\" name=\"go$num\" type=\"button\" class=\"Submit\" value=\" Go \" onclick=\"document.getElementById('page').value=document.getElementById('page$num').value;document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\">";
	if(!$type){
		$paginglist.= "&nbsp;&nbsp;<span class=\"headpager\">แสดง&nbsp;:</span>&nbsp;<input name=\"page_size$num\" type=\"text\" size=\"2\"  class=\"textbox\" value=\"$page_size\" style=\"text-align:center\" id=\"page_size$num\" onKeyUp=\"chkFormatNam(this.value,this.name);\">&nbsp;<span class=\"headpager\">/&nbsp;หน้า</span>";
		$paginglist.= "&nbsp;<input id=\"set_size$num\" name=\"set_size$num\" type=\"button\" class=\"normal\" value=\" ตั้งค่า \" onclick=\"document.getElementById('page_size').value=document.getElementById('page_size$num').value;document.getElementById('page').value='1';document.getElementById('startPage').value='';document.getElementById('endPage').value='';document.$formname.submit();\">";
		$paginglist.= "&nbsp;&nbsp;&nbsp;&nbsp;<span class=\"headpager\" id=\"text_record\">จำนวนข้อมูล&nbsp;$allrows&nbsp;รายการ</span>";
	}
	return $paginglist;
}
function paging($formname,$allrows,$page_show,$page_size,$char_sub, $startPage, $endPage, $page){	
	$totalpage = calculate_page($allrows, $page_size);
	$startPages = findrange_page($page_show, $totalpage, $page, $startPage, $endPage, "min");
	$endPages = findrange_page($page_show, $totalpage, $page, $startPage, $endPage, "max");
	if ($page != 1){ // Prvious
		$prev_page = $page-1;
		//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=1$link_value'>|&lt;</a>&nbsp;";
		$ctrlPage.= "<span onclick=\"document.getElementById('page').value=1;document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\"this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">|&lt;</span>$char_sub";
		//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$prev_page$link_value'>&lt;&lt;</a>&nbsp;";
		$ctrlPage.= "<span onclick=\"document.getElementById('page').value='$prev_page';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">&lt;&lt;</span>$char_sub";
	}else{
		$ctrlPage.="<font color=\"#CCCCCC\">|&lt;&nbsp;</font>";
		$ctrlPage.= "<font color=\"#CCCCCC\">&lt;&lt;&nbsp;</font>";
	}
	if ($totalpage > 1) {
		for($i=$startPages ; $i<$page ; $i++) 
		{
			//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$i$link_value'>$i</a>$char_sub";
			$ctrlPage.= "<span class=\"pageNormal\" onclick=\"document.getElementById('page').value='$i';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">$i</span>$char_sub";
		}

		$ctrlPage.= "<b>".$page."</b>$char_sub";
		for($i=$page+1 ; $i<=$endPages ; $i++) 
		{
			//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$i$link_value'>$i</a>$char_sub";
			$ctrlPage.= "<span class=\"pageNormal\" onclick=\"document.getElementById('page').value='$i';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">$i</span>$char_sub";
		} 
		if (($page != $totalpage) && ($totalpage !=0)){
			$next_page = $page+1;
			//$ctrlPage.= "<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$next_page$link_value'>&gt;&gt;</a>";
			$ctrlPage.= "<span onclick=\"document.getElementById('page').value='$next_page';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">&gt;&gt;</span>$char_sub";
			//$ctrlPage.= "&nbsp;<a href='$_SERVER[PHP_SELF]?page_size=$page_size&page=$totalpage$link_value'>&gt;|</a>";
			$ctrlPage.= "<span onclick=\"document.getElementById('page').value='$totalpage';document.getElementById('page_size').value='$page_size';document.getElementById('startPage').value='$startPages';document.getElementById('endPage').value='$endPages';document.$formname.submit();\" onmouseover=\" this.style.cursor='pointer';this.style.color='#FF0000'\" onmouseout=\" this.style.cursor='pointer';this.style.color='#000000'\">&gt;|</span>";
		}else{
			$ctrlPage.= "<font color=\"#CCCCCC\">&gt;&gt;</font>";
			$ctrlPage.= "<font color=\"#CCCCCC\">&nbsp;&gt;|</font>";
		}
	}else{
		$ctrlPage =1;
	}
	return $ctrlPage;
}
function calculate_page($allrows, $page_size){
	$rt = $allrows%$page_size;

	if($rt!=0) 
	{ 
		$totalpage = floor($allrows/$page_size)+1; 
	}
	else 
	{
		$totalpage = floor($allrows/$page_size); 
	}
	return $totalpage;
}
function findrange_page($page_show, $totalpage, $page, $startPage, $endPage, $min_max){
	$range=0;
	if ($page_show >= $totalpage)
	$page_show=$totalpage;
	if ($page==1){
		$startPage = 1;
		$endPage = $page_show;
	}else if ($page == $endPage && $page != $totalpage)  {
		$startPage = $page;
		$endPage  +=($page_show-1); 
		if ($endPage > $totalpage)
			$endPage = $totalpage;
	}else if ($page < $startPage) {
		$endPage = $startPage;
		$startPage = ($endPage-$page_show)+1;
	}else if($page == $totalpage){
		$endPage = $totalpage;
		$startPage=$totalpage-$page_show+1;
		if($startPage< '0' ){
			$endPage ="" ;
			$startPage="";
		}
	}
	if($min_max=='min'){
		$range = $startPage;
	}elseif($min_max=='max'){
		$range = $endPage;
	}
	return $range;
}

function getFilenameUplaod($a_uploadfile,$path_savefile,$old_file = ''){
	$return_filename = '';
	if (trim($old_file) != '') {
		//@unlink($path_savefile.$old_file);
		$return_filename = copyobject($a_uploadfile['size'], $a_uploadfile['name'], $a_uploadfile['tmp_name'], '', $path_savefile, $old_file, '');
	}else{
		$return_filename = copyobject($a_uploadfile['size'], $a_uploadfile['name'], $a_uploadfile['tmp_name'], '', $path_savefile, '', '');
	}
	return $return_filename;
}
 
function smart_resize_image($file,$width= 0, $height= 0, $proportional= false, $output= 'file', $delete_original= true, $use_linux_commands = false ) {
    if ( $height <= 0 && $width <= 0 ) 
		return false;

    # Setting defaults and meta
    $info                         = getimagesize($file);
    $image                        = '';
    $final_width                  = 0;
    $final_height                 = 0;
    list($width_old, $height_old) = $info;

    # Calculating proportionality
    if ($proportional) {
		if      ($width  == 0)  $factor = $height/$height_old;
		elseif  ($height == 0)  $factor = $width/$width_old;
		else                    $factor = min( $width / $width_old, $height / $height_old );

		$final_width  = round( $width_old * $factor );
		$final_height = round( $height_old * $factor );
    }else {
		$final_width = ( $width <= 0 ) ? $width_old : $width;
		$final_height = ( $height <= 0 ) ? $height_old : $height;
    }

    # Loading image to memory according to type
    switch ( $info[2] ) {
		case IMAGETYPE_GIF:   $image = imagecreatefromgif($file);   break;
		case IMAGETYPE_JPEG:  $image = imagecreatefromjpeg($file);  break;
		case IMAGETYPE_PNG:   $image = imagecreatefrompng($file);   break;
		default: return false;
    }
    
    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
		$transparency = imagecolortransparent($image);

		if ($transparency >= 0) {
			$transparent_color  = imagecolorsforindex($image, $trnprt_indx);
			$transparency       = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
			imagefill($image_resized, 0, 0, $transparency);
			imagecolortransparent($image_resized, $transparency);
		}elseif ($info[2] == IMAGETYPE_PNG) {
			imagealphablending($image_resized, false);
			$color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
			imagefill($image_resized, 0, 0, $color);
			imagesavealpha($image_resized, true);
		}
    }
    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
    
    # Taking care of original, if needed
    if ( $delete_original ) {
		if ( $use_linux_commands ) exec('rm '.$file);
		else @unlink($file);
    }

    # Preparing a method of providing result
    switch ( strtolower($output) ) {
		case 'browser':
			$mime = image_type_to_mime_type($info[2]);
			header("Content-type: $mime");
			$output = NULL;
			break;
		case 'file':
			$output = $file;
		break;
		case 'return':
			return $image_resized;
		break;
		default:
		break;
    }
    
    # Writing image according to type to the output destination
    switch ( $info[2] ) {
		case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
		case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output);   break;
		case IMAGETYPE_PNG:   imagepng($image_resized, $output);    break;
		default: return false;
    }
    return true;
}

function getFilenameUplaodMulti($a_uploadfile,$index,$path_savefile,$old_file = ''){
	$return_filename = '';
	if (trim($old_file) != '') {
			@unlink($path_savefile.$old_file);
			$return_filename = copyobject($a_uploadfile['size'][$index], $a_uploadfile['name'][$index], $a_uploadfile['tmp_name'][$index], '', $path_savefile, '', '');
	}else{
		$return_filename = copyobject($a_uploadfile['size'][$index], $a_uploadfile['name'][$index], $a_uploadfile['tmp_name'][$index], '', $path_savefile, '', '');
	}
	return $return_filename;
}

function getFilenameUplaodMultis($a_uploadfile,$index,$index2,$path_savefile,$old_file = ''){
	$return_filename = '';
	if (trim($old_file) != '') {
			@unlink($path_savefile.$old_file);
			$return_filename = copyobject($a_uploadfile['size'][$index][$index2], $a_uploadfile['name'][$index][$index2], $a_uploadfile['tmp_name'][$index][$index2], '', $path_savefile, '', '');
	}else{
		$return_filename = copyobject($a_uploadfile['size'][$index][$index2], $a_uploadfile['name'][$index][$index2], $a_uploadfile['tmp_name'][$index][$index2], '', $path_savefile, '', '');
	}
	return $return_filename;
}

function displayDownloadFileAttach($pathfile, $file, $title_icon = "ดาวน์โหลด") {
	global $path;
	
	$pic=explode("/",$pathfile);
	for($i=0; $i<=count($pic)-2; $i++){
		if((count($pic)=='5' && $i!='0') || (count($pic)=='4')){
			$img.=$pic[$i]."/";
		}
	}
	
	if (!file_exists($pathfile.$file) && trim($file)!='') {
		$download = "<span class=\"input-group-addon\" onclick = \"document.location.href='".$path."include/getFileDownload.php?path=".$img.$file."'\"  title=\"".$title_icon."\"><span class=\"glyphicon glyphicon-download-alt\"></span></span>";
	}
	return $download;
}

function copyobject($size, $name, $temp, $prefix='', $url, $oldimage='', $specialfiletype=''){
	if($size>0){
		$arr = explode(".",$name);
		$number = count($arr);
		if($specialfiletype){
			$upper = strtoupper($specialfiletype);
			$lower = strtolower($specialfiletype);
			if($arr[$number-1]==$upper || $arr[$number-1]==$lower){
				$destination = $prefix.rand(10,99).date('Ymdhis').".".$arr[$number-1];
				copy($temp, $url.$destination);
				@unlink($url.$oldimage);
			}else{
				$destination = $oldimage;
			}
		}else{
			$destination = $prefix.rand(10,99).date('Ymdhis').".".$arr[$number-1];
			copy($temp, $url.$destination);
			@unlink($url.$oldimage);
		}
	}else{
		$destination = $oldimage;
	}
	return $destination;
}

//Function resize images
function resize($pathfile,$targetFile,$oldfile='',$newWidth='300') {
	if($targetFile){
		$info = getimagesize($targetFile);
		switch ($info['mime']) {
			case 'image/jpeg':
				$image_create_func = 'imagecreatefromjpeg';
				$image_save_func = 'imagejpeg';
				$new_image_ext = 'jpg';
			break;
			case 'image/png':
				$image_create_func = 'imagecreatefrompng';
				$image_save_func = 'imagepng';
				$new_image_ext = 'png';
			break;
			case 'image/gif':
				$image_create_func = 'imagecreatefromgif';
				$image_save_func = 'imagegif';
				$new_image_ext = 'gif';
			break;
			//default: throw Exception('Unknown image type.');
		}
		//ชื่อรูป
		$images_name = rand(10,99).date('YmdHis').".".$new_image_ext;
		//$images_name = $images_name.".".$new_image_ext;								
									
		$img = $image_create_func($targetFile);
		$newHeight = ($info[1] / $info[0]) * $newWidth;
		$tmp = imagecreatetruecolor($newWidth, $newHeight);

		imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $info[0], $info[1]);

		//ลบไฟล์เก่า
		if(trim($oldfile)!=''){
			if (file_exists($pathfile.$oldfile)) {
				@unlink($pathfile.$oldfile);
			}
		}

		$image_save_func($tmp, $pathfile.$images_name);
		//destroy image resources
		imagedestroy($tmp);
		imagedestroy($img);
	}else{
		$images_name=$oldfile;
	}
	
	return $images_name;
}

//หาจำนวนวันจาก เดือนปี
function search_date($month,$year){
	$info = cal_days_in_month( CAL_GREGORIAN , $month , $year ) ;
	return $info ;
}

//แปลงค่าวันที่
function convert_int_date($int){
 $date = substr($int,6,2)."/".substr($int,4,2)."/".substr($int,0,4);
 return $date;
}

//แปลงค่าวันที่
function conv_date($input, $format_month='', $type=''){
	global $mont_en, $mont_en_short, $mont_th, $mont_th_short;
	/*
		$input='2013-11-14 10:43:04' || '2013-11-14', 
		$type='' ไม่แสดงเวลา
		$type='1' แสดงเวลา
	*/
	if(trim($input)){
		if($format_month=='long'){
			$date=(int)substr($input,8,2)." ".$mont_th[substr($input,5,2)]." ".(substr($input,0,4)+543);
		}elseif($format_month=='short'){
			$date=(int)substr($input,8,2)." ".$mont_th_short[substr($input,5,2)]." ".(substr($input,0,4)+543);
		}elseif($format_month=='year'){
			$date=(int)(substr($input,0,4)+543);
		}elseif($format_month=='full'){
			$date=(int)substr($input,8,2)." เดือน ".$mont_th[substr($input,5,2)]." พ.ศ. ".(substr($input,0,4)+543);
		}elseif($format_month=='short2'){
			$date=(int)substr($input,8,2)." ".$mont_th[substr($input,5,2)]."  ".(substr($input,0,4)+543);
		}elseif($format_month=='holiday'){
			$date=(int)substr($input,8,2)." ".$mont_th[substr($input,5,2)];
		}elseif($format_month=='pdf'){
			$date=toThaiNumber((int)substr($input,8,2)." ".$mont_th_short[substr($input,5,2)]." ".(substr($input,0,4)+543));
		}elseif($format_month=='time'){
			$date=substr($input,10,6);
		}else{
			$date=substr($input,8,2)."/".substr($input,5,2)."/".(substr($input,0,4)+543);
		}
		
		if($type=='1'){
			if($format_month!='pdf'){
				$date.="<br>".substr($input,10,9);
			}else{
				$date.=toThaiNumber(substr($input,10,9));
			}
		}
	}else{
		$date=($format_month=='')?"":"-";
	}
	return $date;
}

//แปลงค่าวันที่ ลง DB
function conv_date_db($input){
	$date=trim($input)?(substr($input,6,4)-543)."-".substr($input,3,2)."-".substr($input,0,2):'NULL';
	return $date;
}

function convert_date_int($date){
	$arr = explode("/",$date);
	$date = $arr[2].$arr[1].$arr[0];
	return $date;
}
function convert_month($month,$language){
	if($language=='longthai'){
		if($month=='01' || $month=='1'){
		$month = "มกราคม";
		}elseif($month=='02' || $month=='2'){
		$month = "กุมภาพันธ์";
		}elseif($month=='03' || $month=='3'){
		$month = "มีนาคม";
		}elseif($month=='04' || $month=='4'){
		$month = "เมษายน";
		}elseif($month=='05' || $month=='5'){
		$month = "พฤษภาคม";
		}elseif($month=='06' || $month=='6'){
		$month = "มิถุนายน";
		}elseif($month=='07' || $month=='7'){
		$month = "กรกฎาคม";
		}elseif($month=='08' || $month=='8'){
		$month = "สิงหาคม";
		}elseif($month=='09' || $month=='9'){
		$month = "กันยายน";
		}elseif($month=='10'){
		$month = "ตุลาคม";
		}elseif($month=='11'){
		$month = "พฤศจิกายน";
		}elseif($month=='12'){
		$month = "ธันวาคม";
		}
		return $month;
	}elseif($language=='shortthai'){
		if($month=='01' || $month=='1'){
		$month = "ม.ค.";
		}elseif($month=='02' || $month=='2'){
		$month = "ก.พ.";
		}elseif($month=='03' || $month=='3'){
		$month = "มี.ค.";
		}elseif($month=='04' || $month=='4'){
		$month = "เม.ย.";
		}elseif($month=='05' || $month=='5'){
		$month = "พ.ค.";
		}elseif($month=='06' || $month=='6'){
		$month = "มิ.ย.";
		}elseif($month=='07' || $month=='7'){
		$month = "ก.ค.";
		}elseif($month=='08' || $month=='8'){
		$month = "ส.ค.";
		}elseif($month=='09' || $month=='9'){
		$month = "ก.ย.";
		}elseif($month=='10'){
		$month = "ต.ค.";
		}elseif($month=='11'){
		$month = "พ.ย.";
		}elseif($month=='12'){
		$month = "ธ.ค.";
		}
		return $month;
	}elseif($language=='shorteng'){
		if($month=='01' || $month=='1'){
		$month = "Jan";
		}elseif($month=='02' || $month=='2'){
		$month = "Feb";
		}elseif($month=='03' || $month=='3'){
		$month = "Mar";
		}elseif($month=='04' || $month=='4'){
		$month = "Apr";
		}elseif($month=='05' || $month=='5'){
		$month = "May";
		}elseif($data[1]=='06' || $month=='6'){
		$month = "Jun";
		}elseif($month=='07' || $month=='7'){
		$month = "Jul";
		}elseif($month=='08' || $month=='8'){
		$month = "Aug";
		}elseif($month=='09' || $month=='9'){
		$month = "Sep";
		}elseif($month=='10'){
		$month = "Oct";
		}elseif($month=='11'){
		$month = "Nov";
		}elseif($month=='12'){
		$month = "Dec";
		}
		return $month;
	}elseif($language=='longeng'){
		if($month=='01'  || $month=='1'){
		$month = "January";
		}elseif($month=='02' || $month=='2'){
		$month = "February";
		}elseif($month=='03' || $month=='3'){
		$month = "March";
		}elseif($month=='04' || $month=='4'){
		$month = "April";
		}elseif($month=='05' || $month=='5'){
		$month = "May";
		}elseif($month=='06' || $month=='6'){
		$month = "June";
		}elseif($month=='07' || $month=='7'){
		$month = "July";
		}elseif($month=='08' || $month=='8'){
		$month = "August";
		}elseif($month=='09' || $month=='9'){
		$month = "September";
		}elseif($month=='10'){
		$month = "October";
		}elseif($month=='11'){
		$month = "November";
		}elseif($month=='12'){
		$month = "December";
		}
		return $month;
		}
}
function displaydate($x){
	if($x){
	$thai_m=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	$date_array=explode("-",$x);
	$y=$date_array[0];
	$m=$date_array[1]-1;
	$d=$date_array[2];
	$m=$thai_m[$m];
	//$y=$y+543;
	$displaydate="$d $m $y";
	return $displaydate;
	}else{
	$displaydate="-";
	return $displaydate;
	}
}
function show_date_int($date){
	if($date){
		$set_date = substr($date,6,2)."/".substr($date,4,2)."/".substr($date,0,4);
		return $set_date;
	}
}

function is_already_login ( )
{
    $login = false;
    if (!isset($_SESSION["sess_status"]))
        $_SESSION["sess_status"] = 0;
    if ($_SESSION["sess_status"] == 1)
        $login = true;
    return $login;
}

function show_fulldate_th($date){
	$set_date = substr($date,6,2)." ".convert_month(substr($date,4,2),"longthai")." พ.ศ. ".substr($date,0,4);
	return $set_date;
}

function get_idCard($idcard, $txt=' '){
	if($idcard != '' && strlen($idcard) == 13){
		$idcard_1 = substr($idcard,0,1);
		$idcard_2 = substr($idcard,1,4);
		$idcard_3 = substr($idcard,5,5);
		$idcard_4 = substr($idcard,10,2);
		$idcard_5 = substr($idcard,12,1);
		$idcard = $idcard_1.$txt.$idcard_2.$txt.$idcard_3.$txt.$idcard_4.$txt.$idcard_5;
	}
	
	return $idcard;
}
function getDateTime($input){
	if($input){
		$date = substr($input,0,8);
		$date = show_date_int($date);
		$time1 = substr($input, 8,2);
		$time2 = substr($input, 10,2);
		$datetime = $date."&nbsp;&nbsp;".$time1.":".$time2." น.";
		return $datetime;
	}
}

function getDateTimeNoTime($input){// input 2556-12-20 20:18 Output 20/12/2556
	if($input){
		$exinput = explode(" ",$input);
		$exdate = explode("-",$exinput[0]);
		$date = $exdate[2]."/".$exdate[1]."/".$exdate[0];
		return $date;//."&nbsp;".$exinput[1];
	}
}

function GetDateTimeDB($input){
	if($input){
		$exinput = explode(" ",$input);
		$exdate = explode("-",$exinput[0]);
		$date = $exdate[2]."/".$exdate[1]."/".$exdate[0];
		return $date."&nbsp;".$exinput[1];
	}
}

function GetDateImport($date){//input 12.12.55
	if($date){
		$date_ex = explode(".",$date);
		$year = 2500+$date_ex[2];
		$year = ($year-543);
		$date = $year."-".$date_ex[0]."-".$date_ex[1];
		return $date;
	}
}

function getArrID($arr){
	if(count($arr) > 0){
		for($i=0; $i<count($arr); $i++){
			$ObjID .= $arr[$i].", ";
		}
		$ObjID = substr($ObjID,0,-2);
	}else{
		$ObjID = 0;	
	}
	return $ObjID;
}
function find_search($searchtext,$txt){
	$arr_w = array($searchtext);
	$txt = str_replace($arr_w,"<span class=\"alertred\">".$searchtext."</span>",$txt);	
	return $txt;
}
function sendEmail($sendto,$from,$subject,$detail){
	if(count($sendto) > 0){
		foreach($sendto as $key => $to){
			@mail($to,$subject,$detail,$from);
		}
	}
}
function getLinkFile($file_status,$file_name, $topic_name){
	global $path;
	$PIC_download = "<img src=\"".$path."icons/download.gif\" alt=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_pdf = "<img src=\"".$path."icons/pdf_cus.gif\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_doc = "<img src=\"".$path."icons/word.jpg\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_xls = "<img src=\"".$path."icons/excel.jpg\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_ppt = "<img src=\"".$path."icons/icon-ppt.gif\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_txt = "<img src=\"".$path."icons/icon_txt.jpg\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_gif = "<img src=\"".$path."icons/icon_gif.jpg\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_jpg = "<img src=\"".$path."icons/icon_jpg.gif\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_zip = "<img src=\"".$path."icons/icon_zip.jpg\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$PIC_rar = "<img src=\"".$path."icons/icon_rar.jpg\" title=\"ดาวน์โหลด\" align=\"absmiddle\" style=\"cursor:pointer\" border=\"0\">";
	$Arrname = explode(".", $file_name);
	$ArrStatus = array("1"=>"topic_download", "2"=>"news", "3"=>"media", "4"=>"km", "5"=>"request", "6"=>"request_department", "7"=>"request_report");

	if($Arrname[1] == 'pdf'){
		$img = $PIC_pdf;
	}else if($Arrname[1] == 'doc' || $Arrname[1] == 'docx'){
		$img = $PIC_doc;
	}else if($Arrname[1] == 'xls' || $Arrname[1] == 'xlsx'){
		$img = $PIC_xls;
	}else if($Arrname[1] == 'ppt' || $Arrname[1] == 'pptx'){
		$img = $PIC_ppt;
	}else if($Arrname[1] == 'txt'){
		$img = $PIC_txt;
	}else if($Arrname[1] == 'gif'){
		$img = $PIC_gif;
	}else if($Arrname[1] == 'jpg' || $Arrname[1] == 'jpeg'){
		$img = $PIC_jpg;
	}else if($Arrname[1] == 'zip'){
		$img = $PIC_zip;
	}else if($Arrname[1] == 'rar'){
		$img = $PIC_rar;
	}else{
		$img = $PIC_download;
	}
	
	$pic_download = "<a href=\"".$path."file_download/$ArrStatus[$file_status]/$file_name\" target=\"_blank\">".$topic_name.'&nbsp;'.$img."</a>"; 
	return $pic_download;
}

function CHK_BEFORE($per_id){
	if(trim($per_id) == ''){
		echo "<script>";	
		echo "alert('กรุณากลับไปกรอกส่วนที่ 1 ก่อนครับ');window.location='input_service01.php'";	
		echo "</script>";	
	}	
}
function calage($pbday){
	$today = date("d/m/Y");
	list($bady , $bmonth , $byear) = explode("/" , $pbday);
	list($tday , $tmonth , $tyear) = explode("/" , $today);
	// 1970
	if($byear < 1970){
		$yearad = 1970 - $byear;
		$byear = 1970;
	}else{
		$yearad = 0;
	}
	$mbirth = mktime(0,0,0,$bmonth,$bday,($byear-543));
	$mnow = mktime(0,0,0,$tmonth,$tday,$tyear);
	$mage = $mnow - $mbirth;
	$rY = (date("Y",$mage)-1970 + $yearad);
	$rY1 = str_replace('-','',$rY);
	$age = $rY1." ปี ".(date("m", $mage)-1)." เดือน ".(date("d", $mage)-1)." วัน "; 
	
	return($age);
}

function age($birthday,$typeshow,$time){
	if(strlen($birthday)>=8){
		 $y_c= substr($time,0,4);
		 $y_=$y_c-543;
		 $m_= substr($time,4,2);
		 $d_= substr($time,6,2);
		 list($day,$month,$year) = explode("/", $birthday); 
		 $year =$year-543; 
		 $datedeb=mktime(0,0,0,$month,$day,$year); 
		 $datefin=strtotime($y_.$m_.$d_);//เวลาตั้ง
		 //$datefin=time(); 
		 $aad=date("Y",$datedeb); 
		 $mmd=date("m",$datedeb); 
		 $jjd=date("d",$datedeb); 
		 
		 $aaf=date("Y",$datefin); 
		 $mmf=date("m",$datefin); 
		 $jjf=date("d",$datefin); 
		 
		 $nbj=array(0,31,28,31,30,31,30,31,31,30,31,30,31); 
		 if(($aaf % 4)==0){$nbj[2]=29;} 
		 if((($aaf % 100)==0)&(($aaf % 400)!=0)){$nbj[2]=28;} 
		 if($jjf<$jjd){$jjf=$jjf+$nbj[(int)$mmf];$mmf=$mmf-1;} 
		 if($mmf<$mmd){$mmf=$mmf+12;$aaf=$aaf-1;} 
		 if($typeshow=="d"){
		  return ($jjf-$jjd); 
		 }elseif($typeshow=="m"){
		  return ($mmf-$mmd); 
		 }elseif($typeshow=="y"){
		  //return $year;
		  return ($aaf-$aad); 
		 }
	}else{
		return "";
	}
}

function diff_date($start,$typeshow,$stop){ 
	$y_c= substr($stop,0,4);
	$y_=$y_c-543;
	$m_= substr($stop,4,2);
	$d_= substr($stop,6,2);
	list($day,$month,$year) = explode("/", $start); 
	$year =$year-543; 
	$datedeb=mktime(0,0,0,$month,$day,$year); 
	$datefin=strtotime($y_.$m_.$d_);//เวลาตั้ง
	//$datefin=time(); 
	$aad=date("Y",$datedeb); 
	$mmd=date("m",$datedeb); 
	$jjd=date("d",$datedeb); 
	
	$aaf=date("Y",$datefin); 
	$mmf=date("m",$datefin); 
	$jjf=date("d",$datefin); 
	
	$nbj=array(0,31,28,31,30,31,30,31,31,30,31,30,31); 
	if(($aaf % 4)==0){$nbj[2]=29;} 
	if((($aaf % 100)==0)&(($aaf % 400)!=0)){$nbj[2]=28;} 
	if($jjf<$jjd){$jjf=$jjf+$nbj[(int)$mmf];$mmf=$mmf-1;} 
	if($mmf<$mmd){$mmf=$mmf+12;$aaf=$aaf-1;} 
	if($typeshow=="m"){
		if((($mmf-$mmd)+1) == 12){ $mm = 0; }else{  $mm =  ($mmf-$mmd)+1; }
		return $mm; 
	}elseif($typeshow=="y"){
		if((($mmf-$mmd)+1) == 12){ $yy = ($aaf-$aad)+1; }else{  $yy =  $aaf-$aad; }
		return $yy; 
	}
} 

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];//.$_SERVER["REQUEST_URI"];
 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"];//.$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

$bahttext_reading = array(
 1 => array('','เอ็ด','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า'),
 2 => array('','สิบ','ยี่สิบ','สามสิบ','สี่สิบ','ห้าสิบ','หกสิบ','เจ็ดสิบ','แปดสิบ','เก้าสิบ'),
 3 => array('','หนึ่งร้อย','สองร้อย','สามร้อย','สี่ร้อย','ห้าร้อย','หกร้อย','เจ็ดร้อย','แปดร้อย','เก้าร้อย'),
 4 => array('','หนึ่งพัน','สองพัน','สามพัน','สี่พัน','ห้าพัน','หกพัน','เจ็ดพัน','แปดพัน','เก้าพัน'),
 5 => array('','หนึ่งหมื่น','สองหมื่น','สามหมื่น','สี่หมื่น','ห้าหมื่น','หกหมื่น','เจ็ดหมื่น','แปดหมื่น','เก้าหมื่น'),
 6 => array('','หนึ่งแสน','สองแสน','สามแสน','สี่แสน','ห้าแสน','หกแสน','เจ็ดแสน','แปดแสน','เก้าแสน')
);

function integerToThai($number){
 //trail off all the zero at the beginning
 $number=ltrim($number,' 0');
 if($number==''){
  return 'ศูนย์';
 }
 if($number=='1'){
  return 'หนึ่ง';
 }
 //it is easier to work in an inverted one
 $number=strrev($number);
 return millionToThaiHelper($number,'',true);
}

//a helper function that takes care of > million number
function millionToThaiHelper($rnumber,$sofar,$first){
 if(strcmp($rnumber,'1')==0){
  if($first){return 'หนึ่ง'.$sofar;}else{return 'หนึ่งล้าน'.$sofar;}
 }else{
  if(strlen($rnumber)>6){
   if($first){
    return millionToThaiHelper(substr($rnumber,6),integerToThaiHelper($rnumber,1,'').$sofar,false);
   }else{
    return millionToThaiHelper(substr($rnumber,6),integerToThaiHelper($rnumber,1,'').'ล้าน'.$sofar,false);
   }
  }else{
   if($first){
    return integerToThaiHelper($rnumber,1,'').$sofar;
   }else{
    return integerToThaiHelper($rnumber,1,'').'ล้าน'.$sofar;
   } 
  }
 }
}

// the same as integer to Thai but this guy can do only up to 10^6-1
// this function takes in an reversed number that is
// one hundred is represented by 001
// digit represents current working digit.
// tail recursion implementation
// if the number is more than million it will return แค่หลักแสน
function integerToThaiHelper($rnumber,$digit,$sofar){
 if($digit>6){
  return $sofar;
 }
 if($rnumber==''){
  return '';
 }else{
  global $bahttext_reading;
  //echo $rnumber.' '.$sofar.' '.substr($rnumber,0,1).' '.$reading[$digit][$rnumber[0]].'<br>';
  if(strlen($rnumber)==1){
   return $bahttext_reading[$digit][$rnumber].$sofar;
  }else{
   return integerToThaiHelper(substr($rnumber,1),($digit+1),$bahttext_reading[$digit][substr($rnumber,0,1)].$sofar);
  }
 }
}

//convert numeric string to thai reading in baht
//warning bahtText('2345678234234273784723894.234324342') (with quotes)
//is not the same as bahtText(2345678234234273784723894.234324342) because
//php round the number.
//If you wish to use this function with a large number call it with quotes
function thAlpCurrency($number){
 //echo $number;
 /*if(!is_numeric($number) || $number < 0){
 die('bahtText error: the argument is not a valid positive number');
 }*/
 if(is_float($number)){//for weird formats such as 2E5
  //echo 'float';
  $whole = floor($number);
  $decimal = round(($number-$whole)*100);
 }else{
  $temp = explode('.',$number);
  if(count($temp)==1){
   $whole=$temp[0];
   $decimal=0;
  }else{
   $whole=$temp[0];
   $length=strlen($temp[1]);
   if($length>2){
    $decimal.='0';
    $decimal=substr($temp[1],0,3);
    $decimal=round($decimal/(10.0));
   }else if($length==2){
    $decimal=$temp[1]; //0.5 ==> ห้าสิบสตางค์
   }else{
    $decimal=$temp[1].'0';
   }
  }
 }
 if($decimal==0){
  return integerToThai($whole).'บาทถ้วน';
 }else{
  if($whole!=0){
   return integerToThai($whole).'บาท'.integerToThai($decimal).'สตางค์';}
  else{
   return integerToThai($decimal).'สตางค์';
  }
 }
}

function GenCondDept($tbl){
	return "AND ".$tbl.".dept_id IN (1,2,3,4,5,6,7,8,9,10,11)";
}

function url2code($paramLink){
	return base64_encode(urlencode($paramLink));
}
function url2param($paramLink){
	return urldecode(base64_decode($paramLink));
}

function text($txt){
	return iconv("tis-620","utf-8",trim($txt));
}
function convert_text($txt){
	$arr_text = array();
	if(count($txt)>0){
		foreach($txt as $key=>$val){
			$arr_text[$key] = iconv("tis-620","utf-8",trim($val));
			}
		}
	return $arr_text;
}

function ctext($txt){
	$strOut=strip_tags($txt); 
	$strOut=htmlspecialchars($strOut, ENT_QUOTES);
	$strOut=stripslashes($strOut);
	$strOut=str_replace("'"," ",$strOut);
	$strOut=trim($strOut);

	return iconv("utf-8","tis-620",$strOut);
}

//แสดงชื่อเมนู
function showMenu($id, $type='id'){
	global $db;
	
	if($type=='id'){
		$query=$db->query("select MENU_DESC from AUT_MENU_SETTING where MENU_ID='".$id."'");
	}else{
		$query=$db->query("select b.MENU_DESC as MENU_DESC from AUT_MENU_SETTING a join AUT_MENU_SETTING b on a.MENU_PARENT_ID=b.MENU_ID where a.MENU_ID='".$id."'");
	}
	$data_menu=$db->db_fetch_array($query);

	return iconv("tis-620","utf-8",trim($data_menu['MENU_DESC']));
}
//แสดงชื่อเมนู Self
function showMenuSelf($id, $type='id'){
	global $db;
	
	if($type=='id'){
		$query=$db->query("select MENU_DESC from AUT_MENU_SETTING_SELF where MENU_ID='".$id."'");
	}else{
		$query=$db->query("select b.MENU_DESC as MENU_DESC from AUT_MENU_SETTING_SELF a join AUT_MENU_SETTING_SELF b on a.MENU_PARENT_ID=b.MENU_ID where a.MENU_ID='".$id."'");
	}
	$data_menu=$db->db_fetch_array($query);

	return iconv("tis-620","utf-8",trim($data_menu['MENU_DESC']));
}
//แสดงลงชื่อ
function ShowTitlePdf($PREFIX_MILITARY, $PREFIX_NAME){
	$txt="(ลงชื่อ)";
	if($PREFIX_MILITARY=='1'){
		$txt.=" ".text($PREFIX_NAME);
	}elseif($PREFIX_MILITARY=='2'){
		$prefix=@explode(" ",$PREFIX_NAME);
		$txt.=" ".text($prefix[0]);
	}
	return $txt;
}

//แสดงข้อมูลชื่อ 
function Showname($prefix_id, $fname, $mname, $lname, $lang='th'){
	global $db;
	
	$field=($lang=='th'?"PREFIX_NAME_TH":"PREFIX_SHORTNAME_EN");
	
	if($lang=='pdf'){
		$data_fix=$db->db_fetch_array($db->query("select (case PREFIX_MILITARY when '1' then '' when '2' then SUBSTRING(PREFIX_NAME_TH,(CHARINDEX(' ',PREFIX_NAME_TH)+1),LEN(PREFIX_NAME_TH)) else PREFIX_NAME_TH end)+(case SPACE_STATUS when '1' then '&nbsp;' else '' end) as PREFIX_NAME from SETUP_PREFIX where PREFIX_ID='".$prefix_id."'"));
	}elseif($lang=='text'){
		$data_fix['PREFIX_NAME']=$prefix_id;
	}else{
		$data_fix=$db->db_fetch_array($db->query("select ".$field."+(case SPACE_STATUS when '1' then '&nbsp;' else '' end) as PREFIX_NAME from SETUP_PREFIX where PREFIX_ID='".$prefix_id."'")); 
	}
	return text(trim($data_fix['PREFIX_NAME']).($lang=='en'?" ":"").trim($fname).(trim($mname)!='' && trim($mname)!='-'?"&nbsp;".$mname:"").(trim($lname)?"&nbsp;&nbsp;".$lname:""));	
}

//แปลงตัวเลขเป็นเลขไทย
function toThaiNumber($number=''){
	$numthai = array("๑","๒","๓","๔","๕","๖","๗","๘","๙","๐");
	$numarabic = array("1","2","3","4","5","6","7","8","9","0");
	$str = str_replace($numarabic, $numthai, $number);
	return $str;
}

function number_format_thai($num_data='',$num=0){
    $html = toThaiNumber(number_format($num_data,$num));
	return $html;

}

//random password
function randomPassword($length='10'){
	//$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$str = '';
	$max = strlen($chars) - 1;

	for ($i=0; $i < $length; $i++){
		$str .= $chars[mt_rand(0, $max)];
	}
	return $str;
}

//แสดงรูป all
function showPic_all($path,$pic,$type=''){	
	if(trim($pic)!=''){
		$img=$path.$pic;
		
		if(file_exists($img)){
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"".$img."\" class=\"img-responsive\" ></a>";
		}else{
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
		}
	}else{
		$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
	}

	return $result;
}

//แสดงรูป สส
function showPic_ss($pic,$type=''){
	global $path;
	
	if(trim($pic)!=''){
		$img=$path."fileupload/pic_ss/".$pic.".jpg";
		
		if(file_exists($img)){
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"".$img."\" class=\"img-responsive\" ></a>";
		}else{
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
		}
	}else{
		$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
	}

	return $result;
}

function showPic_ss2($pic,$type=''){
	global $path;
	
	if(trim($pic)!=''){
		$img=$path."fileupload/pic_ss/".$pic;
		
		if(file_exists($img)){
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"".$img."\" class=\"img-responsive\" ></a>";
		}else{
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
		}
	}else{
		$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
	}

	return $result;
}

function showPic_Pdf($pic=''){
	global $path;
	
	if(trim($pic)!=''){
		//$img_ss=toThaiNumber(substr($pic,0,1)." ".substr($pic,1,4)." ".substr($pic,5,5)." ".substr($pic,10,2)." ".substr($pic,12,1)).".jpg";
		$img_ss=$pic.".jpg";
		$img=$path."fileupload/pic_ss/".$img_ss;
		if(file_exists($img)){
			$result="<img src=\"".$img."\" width=\"2.5cm\" height=\"3.25cm\" >";
                        
		}else{
			$result="<img src=\"".$path."fileupload/pic_ss/no-pic.jpg\" width=\"2.5cm\" height=\"3.25cm\">";   
		}
	}
	return $result;
}
//แสดงรูปพรรค
function showPic_Party($pic,$type=''){
	global $path;
	
	if(trim($pic)!=''){
		$img=$path."fileupload/party/".$pic;

		if(file_exists($img)){
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"".$img."\" class=\"img-responsive\"></a>";
		}else{
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
		}
	}else{
		$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
	}
	return $result;
}

function IsNullOrEmptyString($question){ //Better way to check variable for null or empty string
    return (!empty($question) || trim($question)==='');
}

function img_thumbnail_show($img_thumb){
    return "<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"".$img_thumb."\" class=\"img-responsive\"></a>";
}

//แสดงรูป บุคลากร
function showPic_per($pic,$type=''){
	global $path;
	$img_thumb = $path.PROPFILE_THUM;
	$thumb_img = img_thumbnail_show($img_thumb); 
	
	if($pic === NULL) {  
			$result=$thumb_img;
		    return $result;
	exit();} 
	if(IsNullOrEmptyString($pic)!=''){
		$img=$path."fileupload/profile_his/".$pic;

		
		if(file_exists($img)){
			$result= img_thumbnail_show($img);
		}else{
			//$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
			$result=$thumb_img;
		}
	}else{
			$result=$thumb_img;
	}
	
	return $result;
}
function showPic_applicant($pic,$type=''){
	global $path;
	
	if(trim($pic)!=''){
		$img=$path."fileupload/file_applicant/".$pic;
		
		if(file_exists($img)){
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"".$img."\" class=\"img-responsive\" ></a>";
		}else{
			$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
		}
	}else{
		$result="<a href=\"javascript:void(0);\" class=\"thumbnail\"><img src=\"holder.js/100x100\" class=\"img-responsive\"></a>";
	}
	
	return $result;
}

function switchPic($path,$class,$mode=0){
	$dis1=($mode==0?"":"style=\"display:none;\"");
	$dis2=($mode==0?"style=\"display:none;\"":"");

	return "<img class=\"".$class."\" src=\"".$path."images/clse.gif\" ".$dis1."><img class=\"".$class."\" src=\"".$path."images/exp.gif\" ".$dis2.">";
}

// func query การค้นหาหน้ารายงาน
function search_report($S_SAPA_ID, $S_TYPE_ID, $S_PROV, $S_ZONE, $S_PARTY, $S_STATUS, $REPORT_SDATE, $REPORT_STIME_H, $REPORT_STIME_M, $REPORT_EDATE, $REPORT_ETIME_H, $REPORT_ETIME_M, $S_SORT, $S_BY, $type=''){

	$timeS_h =$REPORT_STIME_H==''?'00':$REPORT_STIME_H;
	$timeS_m =$REPORT_STIME_M==''?'00':$REPORT_STIME_M;
	$timeE_h =$REPORT_ETIME_H==''?'00':$REPORT_ETIME_H;
	$timeE_m =$REPORT_ETIME_M==''?'00':$REPORT_ETIME_M;

	$timeS = $timeS_h.':'.$timeS_m;
	$timeE = $timeE_h.':'.$timeE_m;
	
	$filter="";
	if($S_SAPA_ID != ""){
		$filter .= " AND s.SAPA_ID ='".ctext($S_SAPA_ID)."'";
	}
	if($S_TYPE_ID != ""){
		$filter .= " AND s.SS_TYPE_ID ='".ctext($S_TYPE_ID)."'";
	}
	if($S_PROV != ""){
		$filter .= " and s.PROV_ID = '".ctext($S_PROV)."'";
	}
	if($S_ZONE != "" && $S_ZONE != '0' ){
		$filter .= " and s.SSP_DISTRICT_ID = '".ctext($S_ZONE)."'";
	}
	if($S_PARTY != ""){
		$filter .= " and s.PARTY_ID = '".ctext($S_PARTY)."'";
	}
	if($S_STATUS != ""){
		$filter .= " and s.SSP_STATUS_3 = '".ctext($S_STATUS)."' ";
	}
	if ($REPORT_SDATE != "") {
		$filter .= " AND CONVERT(date, s.SSP_PRESENT_DATE ) >= '".conv_date_db($REPORT_SDATE)."'";
	}
	if ($REPORT_EDATE != "") {
		$filter .= " AND CONVERT(date,s.SSP_PRESENT_DATE) <= '".conv_date_db($REPORT_EDATE)."'";
	}
	if ($REPORT_STIME_H != "" || $REPORT_STIME_M != "") {
		$filter .= " AND CONVERT(time ,s.SSP_PRESENT_DATE) >= '".$timeS."'";
	}
	if ($REPORT_ETIME_H != "" || $REPORT_ETIME_M != "") {
		$filter .= " AND CONVERT(time ,s.SSP_PRESENT_DATE) <=  '".$timeE."'";
	}
	
	//เรียงตาม
	$by="";
	if($S_SORT=='1'){
		$by .= " p.SS_FIRSTNAME_TH ".$S_BY.",(case when Rtrim(SS_MIDNAME_TH)!='' then p.SS_MIDNAME_TH else '' end) ".$S_BY.", p.SS_LASTNAME_TH ".$S_BY;
	}elseif($S_SORT == '2'){
		$by .= " dbo.ShowAge(p.SS_BIRTH_DATE) ".$S_BY;
	}else if($S_SORT == 3){
		$by .= " CONVERT(INT,s.SSP_NUMBER) ".$S_BY;
	}else if($S_SORT == 4){
		$by .= " sp.PARTY_NAME_TH ".$S_BY;
	}else if($S_SORT == 5){
		$by .= " p.SS_IDCARD ".$S_BY;
	}else{
		$by .= " s.SSP_PRESENT_DATE ".$S_BY;
	}
	
	$arrResult=array();
	$arrResult['filter']=$filter;
	$arrResult['by']=$by;
	
	return $arrResult;
}

//func loop menu
function loopMenu($menu_sub_id){
	global $db;
	
	$sqlmenu="select * from AUT_MENU_SETTING where menu_id='".$menu_sub_id."'";
	$q_menu=$db->query($sqlmenu);
	$rec_menu=$db->db_fetch_array($q_menu);
		$arrResult['MENU_ID']=$rec_menu['MENU_PARENT_ID'];
		$arrResult['MENU_LEVEL']=$rec_menu['MENU_LEVEL'];
		$arrResult['MENU_URL']=$rec_menu['MENU_URL'];
	
	return $arrResult;
		
	//echo $rec_menu['MENU_ID']."==>".$rec_menu['MENU_LEVEL'];
}


//ตรวจสอบ สิทธิในการใช้งาน add, edit, del
function chkPermission($menu_sub_id, $type, $level='3'){
	$arr_miss[1]=$menu_sub_id;
	for($i=2; $i<=4; $i++){
		$r_loop=loopMenu($arr_miss[$i-1]);
		$arr_miss[$i]=$r_loop['MENU_ID'];
		if($r_loop['MENU_LEVEL']==1){break;}
	} 
	
	if($level=='3'){
		return $_SESSION['sys_group_menu'][$arr_miss[4]][$arr_miss[3]][$arr_miss[2]][$arr_miss[1]][$type];
	}elseif($level=='2'){
		return $_SESSION['sys_group_menu'][$arr_miss[3]][$arr_miss[2]][$arr_miss[1]][$type];
	}
}

//หา late ภาษี
function getLateTax($tax, $reduce, $month){
	$late=150000;
	$arr_tex1=array(0=>'0',1=>'5',2=>'10');
	
	$x=0;
	for($z=0; $z<(int)($tax/$late); $z++){
		$x=($z==0?$tax-$late:$x-$late);
		$res+=($late*$arr_tex1[$z])/100;
		//echo "=".$x."=".$arr_tex1[$z]."=".$res."<br>";
		//echo $res=($x*$z);
	}
	$res=($res-$reduce)/(13-$month);
	
	return $res;
}

//หาจากจำนวนวัน
function get_length_date($diff, $round='0', $day2="15"){
	//round=0 ไม่ปัด, 1 ปัด
	
	//$diff = round(abs($edate->format('U') - $sdate->format('U')) / (60*60*24));  
	$year = floor($diff/365);
	$days_month = $diff%365;
	$month = floor($days_month/30);
	$day = $days_month%30;
	if($round>0){
		if($day>$day2){//ปัดเศษจาก จำนวนวันที่กำหนด
			$month++;
			$day=0;
		}
	}
	
	$arrResult=array();
	$arrResult['y']=$year;
	$arrResult['m']=$month;
	$arrResult['d']=$day;
	
	return $arrResult;
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
	/*$id = ชื่อ id 
	* name ของ select
	* $class = ชื่อ class ของ selec
	* $value = ค่าของ table ที่ต้องการให้แสดง
	* $text = ค่าของ  table ที่ต้องการให้แสดง
	* $sql = 
	* $db = database
	* $selected =ส่งค่ามาเพื่อจะเรียกมัย
	* $defualt =กำหนดชื่อตัวแรกของ  select
	* $onchange = ใช้ js
	*/
function getSelect($id ,$name, $class , $value , $text , $sql , $db ,$selected, $defualt = null,$onchange=null){
$sonchange='';
$sclass='';
$html='';
if($onchange!=null){
	$sonchange ='onchange="'.$onchange.';"';
}
if($class!=null ||$class!=''){
	$sclass ='class="'.$class.'"';
}
$html .= '<select  id="'.$id.'" name="'.$name.'" '.$sclass.' '.$sonchange.' placeholder="11" >';
 
 
 //if($defualt != null){
  $html .= '<option value="" >'.$defualt.'</option>';
// }
 if($sql!='' ||$sql!=null){
	$query = $db->query($sql);
	 while($data = $db->db_fetch_array($query)){
	  $html .= '<option value="'.$data[$value].'" '.($selected==$data[$value] && $selected!=''?"selected":"").' >'.text($data[$text]).'</option>';
	 }
 }
 $html .= '</select>';
 return $html;
}

function get_Select($sql , $db ,$opstion=array()){
/*$opstion=array(
			'id'=>'',*
			'name'=>'',*
			'class'=>'',*
			's_selected'=>'',*
			's_defualt'=>'',
			's_key'=>'', *
			's_value'=>'',
			's_onchage'=>null,
			's_placeholder'=>''
				);
				*/
$data = 'ไม่พบข้อมูล';
$s_onchage='';
$s_placeholder='';
$s_style='';
if(!Empty($opstion['s_onchage'])){
	$s_onchage ='onchange="'.$opstion['s_onchage'].';"';
}
if(!Empty($opstion['s_placeholder'])){
	$s_placeholder ='placeholder="'.$opstion['s_placeholder'].'"';
}
if(!Empty($opstion['s_style'])){
	$s_style ='style="'.$opstion['s_style'].'"';
}
 $html .= '<select  id="'.$opstion['id'].'" name="'.$opstion['name'].'" class="'.$opstion['class'].'" '.$s_onchage.' '.$s_placeholder.' '.$s_style.' >';
 $html .= '<option value="" >'.$opstion['s_defualt'].'</option>';
 if($sql!='' ||$sql!=null){
	$query = $db->query($sql);
	$nums = $db->db_num_rows($query);
	if($nums>0){
	 while($data = $db->db_fetch_array($query)){
	  $html .= '<option value="'.$data[$opstion['s_key']].'" '.( $opstion['s_selected']==$data[$opstion['s_key']] && $opstion['s_selected']!=''?"selected":"").' >'.text($data[$opstion['s_value']]).'</option>';
	 }
	}else{
		$html.="<option value = \"0\" $selected> -- $data -- </option>";
	}
 }
 $html .= '</select>';
 return $html;
				

}






function get_Select_v($sql , $db ,$opstion=array()){
/*$opstion=array(
			'id'=>'',*
			'name'=>'',*
			'class'=>'',*
			's_selected'=>'',*
			's_defualt'=>'',
			's_key'=>'', *
			's_value'=>'',
			's_onchage'=>null,
			's_placeholder'=>''
				);
				*/
$data = 'ไม่พบข้อมูล';
$s_onchage='';
$s_placeholder='';
$s_style='';
if(!Empty($opstion['s_onchage'])){
	$s_onchage ='onchange="'.$opstion['s_onchage'].';"';
}
if(!Empty($opstion['s_placeholder'])){
	$s_placeholder ='placeholder="'.$opstion['s_placeholder'].'"';
}
if(!Empty($opstion['s_style'])){
	$s_style ='style="'.$opstion['s_style'].'"';
}
 $html .= '<select  id="'.$opstion['id'].'" name="'.$opstion['name'].'" class="'.$opstion['class'].'" '.$s_onchage.' '.$s_placeholder.' '.$s_style.' >';
 $html .= '<option value="" >'.$opstion['s_defualt'].'</option>';
 if($sql!='' ||$sql!=null){
	$query = $db->query($sql);
	$nums = $db->db_num_rows($query);
	if($nums>0){
	 while($data = $db->db_fetch_array($query)){
	  $html .= '<option value="'.$data[$opstion['s_key']].'" '.( $opstion['s_selected']==$data[$opstion['s_key']] && $opstion['s_selected']!=''?"selected":"").' >'.text($data[$opstion['s_value']]).'</option>';
	  if($opstion['s_selected']==$data[$opstion['s_key']]){
	      $sdata = text($data[$opstion['s_value']]);
	  }
	 }
	}else{
		$html.="<option value = \"0\" $selected> -- $data -- </option>";
		$sdata = '';
	}
 }
 $html .= '</select>';
 $html = $sdata;
 return $html;
				

}




function get_org_name($org_id){
	global $db;
	$sql = "SELECT * from SETUP_ORG a
WHERE 1=1 AND a.ORG_ID = '".$org_id."'";
	$query =$db->query($sql);
	$rec = $db->db_fetch_array($query);
	return text($rec['ORG_NAME_TH']);
	}

	//โทรศัพท์
	function format_phone($phone,$phone_type='mobile',$type_bk='',$ext=''){//tel  mobile  fax Bangkok up-country
		$phones = '';
		$phones = preg_replace("/[^0-9]/", "", $phone);
		if(strlen($phones) == 7){
			//$phones = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phones);
		}elseif(strlen($phones) == 9){
		
			if($phone_type=='tel'){
				if($type_bk=='bk'){
					$phones = preg_replace("/([0-9]{1})([0-9]{4})([0-9]{4})/", $ext==''?"$1 $2 $3":"$1 $2 $3"." ต่อ ".$ext, $phones);
				}else{
					$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})/", $ext==''?"$1 $2 $3":"$1 $2 $3"." ต่อ ".$ext, $phones);
				}
			}else if($phone_type=='mobile'){
				if($type_bk=='bk'){
					$phones = preg_replace("/([0-9]{1})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
				}else{
					$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})/", "$1 $2 $3", $phones);
				}
			}else if($phone_type=='fax'){
				if($type_bk=='bk'){
					$phones = preg_replace("/([0-9]{1})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
				}else{
					$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3})/", "$1 $2 $3", $phones);
				}
			}
				
		}elseif(strlen($phones) == 10){
			
			if($phone_type=='tel'){
				$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 $2 $3", $phones);
			}else if($phone_type=='mobile'){
					$phones = preg_replace("/([0-9]{2})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
			}else if($phone_type=='mobile2'){
					$phones = preg_replace("/([0-9]{2})([0-9]{4})([0-9]{4})/", "$1 $2 $3", $phones);
			}else if($phone_type=='fax'){
				$phones = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 $2 $3", $phones);
			}
		}
		return $phones;
	}
	
	function phone_sum($arr=array(),$type_phone,$ext=array()){
		if(count($arr)!=0){
                        
			$v_tel=array();
			if(trim($arr[1])!=''){
				array_push($v_tel,format_phone(trim($arr[1]),$type_phone,'bk',trim($ext[1])));
			}
			if(isset($arr[2])){
				if(trim($arr[2])!=''){
				$bk='bk';
					if($type_phone=='fax'){
						$bk='';
					}
					array_push($v_tel,format_phone(trim($arr[2]),$type_phone,$bk,trim($ext[2])));
				}
			}
			if(isset($arr[3])){
				if(trim($arr[3])!=''){
					array_push($v_tel,format_phone(trim($arr[3]),$type_phone,'',trim($ext[3])));
				}
			}
			
			if(isset($arr[4])){
				if(trim($arr[4])!=''){
					array_push($v_tel,format_phone(trim($arr[4]),$type_phone,'',trim($ext[4])));
				}
			}
			if(count($v_tel)!=0){
			return implode(", ",$v_tel);
			}
		}
	return '';
}
/* แทรก tableของหน้า Report */
function subtable_column ($option,$type='head'){
	global $pdf,$w0;

	if($type=='head'){
		//width="'.$option['width'].'%"
        if($option['page']=='dox'){
            return '<th style="background-color: #CCCCCC"><div align="center"><strong>'.$option['name'].'</strong></div></th>';
        }else if($option['page']=='pdf'){
            return   $pdf->Cell($w0, 23, $option['name'], 1, false, 'C', true, '', 0, false, 'T', 'M');
        }else{
            return '<th><div align="center"><strong>'.$option['name'].'</strong></div></th>';    
        }
	}else{
		if($option['id']=='6'){
			$f_value='';
			if(trim($option['value'])!=''){
				$date = new DateTime($option['value']);
				$date->format('Y-m-d H:i:s');
				$f_value=conv_date($date->format('Y-m-d H:i:s'),'short','1');
			}
		}else{
			$f_value=$option['value'];
		}
		
		$f_align='center';
                $p_align='C';
		if($option['id']=='4'||$option['id']=='1'){
			$f_align='left';
			$p_align='L';
		}
                
		if($option['page']=='dox'){
			return '<td align="'.$f_align.'">'.' '.toThaiNumber($f_value).'</td>';
		}else if($option['page']=='pdf'){
			return $pdf->Cell($w0, 9, str_replace('<br>',' -',toThaiNumber($f_value)), 0, false, $p_align, 0, '', 0, false, 'T', 'M');
		}else{
			return '<td align="'.$f_align.'">'.$f_value.'</td>';   
		}
	}
}

//เงื่อนไข เครื่องราชในแต่ละหน้า
function funcDecCond($menu_id, $mode){
	$cond1=array();
	if($menu_id=='399'){//คู่สมรส PER
		$cond1['field']="b.DEC_PER_ID,a.PER_ID, marry.PMAARY_IDCARD as PER_IDCARD, marry.PMARRY_PREFIX_ID as PREFIX_ID, marry.PMARRY_FIRSTNAME_TH as PER_FIRSTNAME_TH, marry.PMARRY_MIDNAME_TH as PER_MIDNAME_TH, marry.PMARRY_LASTNAME_TH as PER_LASTNAME_TH,c.LINE_NAME_TH, d.ORG_NAME_TH,b.DEC_APV_STATUS,b.MEET_STATUS, a.PREFIX_ID as PREFIX_ID2, a.PER_FIRSTNAME_TH as PER_FIRSTNAME_TH2, a.PER_MIDNAME_TH as PER_MIDNAME_TH2, a.PER_LASTNAME_TH as PER_LASTNAME_TH2";
		$cond1['table']=" join PER_MARRYHIS marry on b.MAIRED_ID=marry.PMARRY_ID ";
		$cond1['orderby']=" order by a.PER_FIRSTNAME_TH, (case when Rtrim(a.PER_MIDNAME_TH)!='' then a.PER_MIDNAME_TH else '' end), a.PER_LASTNAME_TH asc ";
	}else{//ปกติ
		$cond1['field']="b.DEC_PER_ID,a.PER_ID, a.PER_IDCARD, a.PREFIX_ID, a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH,c.LINE_NAME_TH, d.ORG_NAME_TH,b.DEC_APV_STATUS,b.MEET_STATUS";
		$cond1['table']="";
		$cond1['orderby']=" order by a.PER_FIRSTNAME_TH, (case when Rtrim(a.PER_MIDNAME_TH)!='' then a.PER_MIDNAME_TH else '' end), a.PER_LASTNAME_TH asc ";
	}
	return $cond1[$mode];
}
function convert_input($str) {		
	$str=strip_tags($str);	
	$str=htmlspecialchars($str, ENT_QUOTES);
	$str=stripslashes($str);
	$str=trim($str);
	return	$str;
}
function getRunCNumber($c_group, $c_type, $num_pad, $run_type, $doc_type){//เลขรัน(ประเภท.., ประเภท.., หลักเลข, ประเภท, ประเภทภาษา)##PG(09/07/57)##
    global $db, $YEAR_PRESENT, $NUM_TH, $NUM_EN, $REQUEST_LANGUAGE_REQ, $SSP_NUMBER, $SSP_ELECTION_DATE;
        if($run_type=='accept'){//เลขที่ลงรับกลุ่มงานทะเบียน
            if ($c_type!=''){//CARD
                $tb="CARD";
                $wh="CARD_GROUP = '" . $c_group . "' AND REQUEST_TYPE = '" . $c_type . "' ";
            } else {//DOC
                $tb="CERTIFICATE";
                $wh="CERT_GROUP = '" . $c_group . "' ";
            }
                $GET_AC_NO = $db->get_data_field("SELECT MAX(CONVERT(int,SUBSTRING(ACCEPT_NO, 0, CHARINDEX('/',ACCEPT_NO,0)))) AS AC_NO FROM $tb WHERE $wh AND SUBSTRING(ACCEPT_NO, CHARINDEX('/',ACCEPT_NO,0)+1, len(ACCEPT_NO)) = '".$YEAR_PRESENT."' ","AC_NO");
                $AC_EX = explode("/",$GET_AC_NO);
                $RUN_CNUM = str_pad((!empty($AC_EX[0])?$AC_EX[0]:0) + 1, $num_pad, "0", str_pad_left)."/".$YEAR_PRESENT;
                
        }else if($run_type=='card'){//เลขรัน จัดทำบัตร
                //$wh_year = $c_group=='5'?substr($SSP_ELECTION_DATE + 543, 0, 4):$YEAR_PRESENT;
                $rec_num = $db->get_data_field("SELECT MAX(CONVERT(int,SUBSTRING(CARDD_NO, 0, CHARINDEX('/',CARDD_NO,0)))) AS CD_NO FROM CARD a INNER JOIN CARD_DESC b ON a.CARD_ID=b.CARD_ID WHERE CARD_GROUP = '" . $c_group . "' AND CARDTYPE_ID = '" . $c_type . "' AND SUBSTRING(CARDD_NO, CHARINDEX('/',CARDD_NO,0)+1, len(CARDD_NO)) = '".$YEAR_PRESENT."' ", "CD_NO");
                if ($c_group == 5||$c_group == 6) {
                $ex_num = explode('/', $rec_num);
                
                if($c_type==2){//บัตรประจำตัว
                    $RUN_CNUM = ($ex_num[0] + 1)."/".$YEAR_PRESENT;#substr($SSP_ELECTION_DATE + 543, 0, 4)    
                }else{
                    $RUN_CNUM = $SSP_NUMBER . "/" . substr($SSP_ELECTION_DATE + 543, 0, 4) . "/" . str_pad(($ex_num[2] + 1), $num_pad, "0", str_pad_left); #เลขที่ ส.ส./ปีที่เลือกตั้ง 4 หลัก/เลขรัน    
                }
            } else {
                $ex_num = explode('/', $rec_num);
                $RUN_CNUM = str_pad($ex_num[0] + 1, $num_pad, "0", str_pad_left) . "/" . $YEAR_PRESENT; 
            }
            
        }else if($run_type=='doc'){//DOC
            $rec_max = $db->get_data_field("SELECT MAX(CONVERT(int,SUBSTRING(MAKE_NO_MAX, 0, CHARINDEX('/',MAKE_NO_MAX,0)))) AS NO_MAX FROM CERTIFICATE WHERE CERT_GROUP = '". $c_group ."' AND SUBSTRING(MAKE_NO_MAX, CHARINDEX('/',MAKE_NO_MAX,0)+1, len(MAKE_NO_MAX)) = '".$YEAR_PRESENT."'","NO_MAX");
            $MAX_EX = explode("/",$rec_max);
            $MAX_NO = str_pad($MAX_EX[0]+$NUM_TH+$NUM_EN,3,"0",str_pad_left)."/".$YEAR_PRESENT;

            if($REQUEST_LANGUAGE_REQ!='3'){

                $TH_NO = str_pad($MAX_EX[0]+1, 3, "0", str_pad_left)."/".$YEAR_PRESENT;   
                $EN_NO = str_pad($MAX_EX[0]+1, 3, "0", str_pad_left)."/".$YEAR_PRESENT;

            }if($REQUEST_LANGUAGE_REQ=='3'){

                $TH_NO = str_pad($MAX_EX[0]+1, 3, "0", str_pad_left)."/".$YEAR_PRESENT;   
                $EN_NO = str_pad($MAX_EX[0]+$NUM_TH+1, 3, "0", str_pad_left)."/".$YEAR_PRESENT;

            }
                if($doc_type=='th'){
                    $RUN_CNUM=$REQUEST_LANGUAGE_REQ!='2'?$TH_NO:'NULL';   
                }if($doc_type=='en'){
                    $RUN_CNUM=$REQUEST_LANGUAGE_REQ!='1'?$EN_NO:'NULL';    
                }if($doc_type=='max'){
                    $RUN_CNUM=$MAX_NO;    
                }
        }    
    return $RUN_CNUM;   
}

// report

function report_breadcrumb($paramlink='',$showMenu='',$headline_title='',$html_report_page ='profile_his_report_disp.php'){
	    $html = '<div class="col-xs-12 col-md-12">';
		$html .= '<ol class="breadcrumb">';
		$html .= '<li><a href="index.php?'.$paramlink.'">หน้าแรก</a></li>';
		$html .= '<li class="active"><a href="'.$html_report_page.'?'.$paramlink.'">'.$showMenu.'</a></li>';
		$html .= '<li class="active">'.$headline_title.'</li>';
		$html .= '</ol>';
		$html .= '</div>';
		return $html; 
	}

 

function print_btn($menu_name=0,$html='',$SEARCH_TYPE=0){
      $attached_report = array(203, 204, 205, 206, 207, 208, 301, 302);
	 
      $print_btn_html = '<div class="row"> 
       <div class="col-xs-12 col-md-3">
          <div class="btn-group">';
      $print_btn_html .= '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">พิมพ์  <span class="caret"></span></button>

              <ul class="dropdown-menu" role="menu">	
                            <li><a href="#" onClick="';
			if (in_array($menu_name, $attached_report)) {
	  			$print_btn_html .= 'print_pdf_attached();';
			}else{
	  			$print_btn_html .= 'print_pdf();';
			}
	  
	  $print_btn_html .= '';
	  $print_btn_html .= '" >พิมพ์แบบ PDF</a></li>
             	<li><a href="#" onClick="';
	  		$print_btn_html .= 'print_excel();';
	  $print_btn_html .= '" >พิมพ์แบบ EXCEL</a></li>
              	<!--li><a href="#" onClick="print_word();" >พิมพ์แบบ WORD</a></li>-->
              </ul>';
      $print_btn_html .= '<form id="frm-export" method="post" action="'.$GLOBALS['path_is'].'system/profile_his/profile_his_report_pdf.php" target=_blank>
			       <input type="hidden" id="report_id_is" name="report_id_is" value="'.$menu_name.'">
                   <input type="hidden" id="pdf_body" name="pdf_body" value="'.$html.'">
			       <input type="hidden" id="SEARCH_TYPEr" name="SEARCH_TYPEr" value="'.$SEARCH_TYPE.'">
			       <input type="hidden" id="report_print_name" name="report_print_name" value="">
			       <input type="hidden" id="report_print_name2" name="report_print_name2" value="">
			       <input type="hidden" id="report_print_name3" name="report_print_name3" value="">
				   
				   ';
      $print_btn_html .= '</form>';
      $print_btn_html .= '<form id="frm-export_exc" method="post" action="'.$GLOBALS['path_is'].'system/profile_his/profile_his_report_excel.php"  target=_blank>
			       <input type="hidden" id="report_id_is" name="report_id_is" value="'.$menu_name.'">
                   <input type="hidden" id="pdf_body" name="pdf_body" value="'.$html.'">
			       <input type="hidden" id="SEARCH_TYPEr" name="SEARCH_TYPEr" value="'.$SEARCH_TYPE.'">
               </form>';
/*	   
      $print_btn_html .= '<form id="frm-export_word" method="post" action="'.$GLOBALS['path_is'].'system/profile_his/profile_his_report_word.php"  target=_blank>
			       <input type="hidden" id="report_id_is" name="report_id_is" value="'.$menu_name.'">
                   <input type="hidden" id="pdf_body" name="pdf_body" value="'.$html.'">
			       <input type="hidden" id="SEARCH_TYPEr" name="SEARCH_TYPEr" value="'.$SEARCH_TYPE.'">
               </form>';  
*/		   			   
      $print_btn_html .= '
	     </div>
     </div>
 </div>   ';

return $print_btn_html;	
} 
	
function xlsBOF() { 
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);  
    return; 
} 

function xlsEOF() { 
    echo pack("ss", 0x0A, 0x00); 
    return; 
} 

function xlsWriteNumber($Row, $Col, $Value) { 
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
    echo pack("d", $Value); 
    return; 
} 

function xlsWriteLabel($Row, $Col, $Value ) { 
    $L = strlen($Value); 
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
    echo $Value; 
return; 
} 

function html_report_header($id,$title_1 = "",$arr_txt=array()){
    $th_start = " <th style=' padding-top:10px; padding-bottom:10px; ";
	
	$table_thead_start = " <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px; ' class='table table-bordered table-striped table-hover table-condensed' >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
	<tr class='bgHead'> ";
	
	
	switch ($id) {
		case 2:
		case 37:
		case 50:
   
	 
		$html   =  $table_thead_start ;
		$html   .= "
          ".$th_start." padding-top:10px; padding-bottom:10px; width:3cm;' >".center_strong("ลำดับ")."</th>
          ".$th_start." padding-top:10px; padding-bottom:10px; ' >".center_strong("สำนัก / กอง")." </th>
          ".$th_start." padding-top:10px; padding-bottom:10px; width:3cm;' >".center_strong("ข้าราชการ")." </th>
    </tr>
  </thead>
	 ";
	 
			break;
		case 3:
		case 51:
	     $search_is = (int)$title_1;
		 if($search_is == 1){
		    $title_name = "ตำแหน่ง";
		 }
		 if($search_is==2){
		    $title_name = "ระดับ";
		 }
		 if($search_is == 3){
		    $title_name = " ประเภทตำแหน่ง ";
 
		 }
		 if($search_is == 0){
		    $title_name = " ประเภทตำแหน่ง ";
 
		 }	 
		$html   =  $table_thead_start ;
		$html   .= $th_start."' >".center_strong("ลำดับ")."</th>
    ".$th_start."width:50%; ' ><div align='center'><strong ><span id='subject_name'>".$title_name."</span></strong></div></th>
    ".$th_start."'> ".center_strong("ชาย")." </th>
    ".$th_start."'> ".center_strong("หญิง")." </th>
    ".$th_start."'> ".center_strong("รวม")."  </th> 
  </tr>
  </thead>
	";  
			break;
		case 4:
		case 39:   
		case 52:		
		if($id == 4){ $txt_title = "ข้าราชการ"; }
		if($id == 39){ $txt_title = "พนักงานราชการ"; }
		if($id == 52){ $txt_title = "ลูกจ้างประจำ"; }
		$html   =  $table_thead_start ;
		$html   .=  $th_start." width:2cm;'   rowspan=2>".center_strong("ลำดับ")." </th>
    ".$th_start."'  rowspan=2 >  ".center_strong("สังกัด / กอง")."  </th>
    ".$th_start."'   colspan=2><div align='center'><strong>".$txt_title."</strong></div></th>
    ".$th_start." width:2cm;'   rowspan=2  vertical-align=middle> ".center_strong("รวม")." </th>
  </tr>
  <tr class='bgHead'>
    ".$th_start." width:3cm;'  >".center_strong("ชาย")."</th>
    ".$th_start." width:3cm;'   >".center_strong("หญิง")." </th>
 
  </tr>
 
  </thead>
	"; 
			break;
			
		case 5:	
		
	     $search_is = (int)$title_1;
		 if($search_is == 1){
		    $title_name = "ระดับการศึกษา";
		 }
		 if($search_is==2){
		    $title_name = "สถาบันศึกษา";
		 }
		 if($search_is == 3){
		    $title_name = " ประเทศที่สำเร็จการศึกษา ";
 
		 }
		 if($search_is == 0){
		    $title_name = " ระดับการศึกษา ";
 
		 }	 
		
		
		$html   =  $table_thead_start ;
		$html   .= "
    ".$th_start."'    rowspan=2>".center_strong("ลำดับ")." </th>
    ".$th_start."' rowspan=2><div align='center'><strong>".$title_name."</strong></div></th>
    ".$th_start."'  colspan=2>".center_strong("ข้าราชการ")."</th>
    ".$th_start."'   rowspan=2>".center_strong("รวม")."</th>
    
  </tr>
  <tr class='bgHead'>
    ".$th_start."'   >".center_strong("ชาย")."</th>
    ".$th_start."'  >".center_strong("หญิง")." </th>
  </tr>
</thead>
	"; 
		
		break;
		
		case 6:	
		$html = "";
		break;
		
		case 7:
		case 40: 
		case 53: 
	     $search_is = (int)$title_1;
		 if($search_is == 1){
		    $title_name = "อายุ";
		 }
		 if($search_is==2){
		    $title_name = "ช่วงอายุ";
		 }
 
		 if($search_is == 0){
		    $title_name = " อายุ ";
 
		 }	 
		 
		if($id == 7){ $txt_title = "ข้าราชการ"; }
		if($id == 40){ $txt_title = "พนักงานราชการ"; }
		if($id == 53){ $txt_title = "ลูกจ้างประจำ"; }	
		$html   =  $table_thead_start ;
		$html   .= "
    ".$th_start."'  rowspan=2>".center_strong("ลำดับ")."</th>
    ".$th_start."'  rowspan=2><div align='center'><strong>".$title_name."</strong></div></th>
    ".$th_start."'  colspan=2><div align='center'><strong>".$txt_title."</strong></div></th>
    ".$th_start."'   rowspan=2><div align='center'><strong>รวม</strong></div></th>
 
  </tr>
  <tr  class='bgHead'>
    ".$th_start."'   ><div align='center' ><strong>ชาย</strong></div></th>
    ".$th_start."' ><div align='center' ><strong>หญิง</strong></div></th>
  </tr>
   </thead>
	";
	break;
	  case 8:
	  case 41:
	  case 54:
		$html   =  $table_thead_start ;
		$html   .= "
    ".$th_start."'   >".center_strong("ลำดับ")."</th>
    ".$th_start."     ' ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
    ".$th_start."     ' ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
    ".$th_start."    ' >".center_strong("ชื่อ - สกุล")."</th>
    ".$th_start."     ' ><div align='center'><strong>ตำแหน่งในสายงาน</strong></div></th>
    ".$th_start."     ' ><div align='center'><strong>เงินเดือน</strong></div></th>
    ".$th_start."     ' ><div align='center'><strong>สังกัดตามกรอบ</strong></div></th>
    ".$th_start."     ' ><div align='center'><strong>สังกัดตามปฎิบัติ</strong></div></th>
	
  </tr>
   </thead>";
	  break;
 
	  case 544444:
	 
		$html   =  $table_thead_start ;
		$html   .= "
    ".$th_start."'    rowspan=2>".center_strong("ลำดับ")."</th>
    ".$th_start."'  rowspan=2><div align='center'><strong>ปีงบประมาณ</strong></div></th>
    ".$th_start."' colspan=3>".center_strong("ข้าราชการ")."</th>
    ".$th_start."'  colspan=3><div align='center'><strong>ลูกจ้างประจำ</strong></div></th>
 
  </tr>
  <tr  class='bgHead'>
    ".$th_start."'  ><div align='center'   ><strong>จำนวนเกษียณ</strong></div></th>
    ".$th_start."'  ><div align='center'  ><strong>จำนวนทั้งหมด</strong></div></th>
    ".$th_start."'  ><div align='center'   ><strong>อัตราการเกษียณ</strong></div></th>
    ".$th_start."'  ><div align='center'   ><strong>จำนวนเกษียณ</strong></div></th>
    ".$th_start."' ><div align='center'   ><strong>จำนวนทั้งหมด</strong></div></th>
    ".$th_start."' ><div align='center' ><strong>อัตราการเกษียณ</strong></div></th>
  </tr>
  </thead>
	";
	  break;
	  
	  case 19:
	  case 20:
	  case 60:
	  case 62:
		$html   =  $table_thead_start ;
		$html   .= "
    ".$th_start." width:3%;  '  >".center_strong("ลำดับ")."</th>
    ".$th_start." width:13%; ' ><div align='center'><strong>เลขประจำตัวประชาชน </strong></div></th>
    ".$th_start." width:8%;  ' ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
    ".$th_start."  width:12%;  ' >".center_strong("ชื่อ - สกุล")."</th>
    ".$th_start."  width:10%;  ' ><div align='center'><strong>ตำแหน่ง</strong></div></th>
    ".$th_start." width:8%;  ' ><div align='center'><strong>ระดับ</strong></div></th>
    ".$th_start." width:13%;  ' ><div align='center'><strong>ตำแหน่งทางการบริหาร</strong></div></th>
    ".$th_start."  width:6%;  ' ><div align='center'><strong>เงินเดือน</strong></div></th>
    ".$th_start."  width:7%;  ' ><div align='center'><strong>สังกัดกรอบ</strong></div></th>
    ".$th_start." width:7%;  ' ><div align='center'><strong>สังกัดปฎิบัติ</strong></div></th>
    ".$th_start."  width:13%;  ' ><div align='center'><strong>วันที่เกษียณอายุราชการ</strong></div></th>
  </tr>
 
  </thead>
	";
	  break;


	  case 191:
	 
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."   ' rowspan=2 >".center_strong("ลำดับ")."</th>
	 ".$th_start."    '  rowspan=2><div align='center'><strong>เลขประจำตัวประชาชน </strong></div></th>
	 ".$th_start."    ' rowspan=2 >".center_strong("ชื่อ - สกุล")."</th>
    

	 ".$th_start."    ' colspan=5><div align='center'><strong>ตำแหน่งที่ปฎิบัติราชการแทน</strong></div></th>
	 ".$th_start."   ' rowspan=2 ><div align='center'><strong>ประเภทการถือครอง</strong></div></th>
     
  </tr>
 
  <tr  class='bgHead'>
	 ".$th_start."  ' ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
	 ".$th_start."   width:11%;  ' ><div align='center'><strong>ตำแหน่ง</strong></div></th>
	 ".$th_start."  width:10%; ' ><div align='center'><strong>ระดับ</strong></div></th>
	 ".$th_start."' ><div align='center'><strong>ตำแหน่งทางการบริหาร</strong></div></th>
	 ".$th_start."   ' ><div align='center'><strong>วันที่ดำรงตำแหน่ง </strong></div></th>
  </tr>
 
  </thead>
	";
	  break;


	  case 9:
	  
		
	     $search_is = (int)$title_1;
		 if($search_is == 1){
		    $title_name = "วุฒิการศึกษา";
		 }
		 if($search_is==2){
		    $title_name = "สาขาวิชาเอก";
		 }
 
		 if($search_is == 0){
		    $title_name = " วุฒิการศึกษา ";
 
		 }	 
		
 
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'  rowspan=2>".center_strong("ลำดับ")."</th>
	 ".$th_start."'   rowspan=2>  ".center_strong($title_name)."  </th>
	 ".$th_start."'   colspan=2>".center_strong("ข้าราชการ")."</th>
	 ".$th_start."'   rowspan=2><div align='center'><strong>รวม</strong></div></th>
    
  </tr>
  <tr  class='bgHead'>
	 ".$th_start."'  ><div align='center'  ><strong>ชาย</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong>หญิง</strong></div></th>
 
  </tr>
 
  </thead>
	";  
	  break;


	  case 11:
	  case 42:
	  case 56:
	  	 $title_text = ' ปีงบประมาณ';
		if($id == 11){ $txt_title = "ข้าราชการ"; }
		if($id == 42){ $txt_title = "พนักงานราชการ"; }
		if($id == 56){ $txt_title = "ลูกจ้างประจำ"; }
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'  rowspan=2>".center_strong("ลำดับ")."</th>
	 ".$th_start."'   rowspan=2>   ".center_strong($title_text)."  </th>
	 ".$th_start."'   colspan=2>    ".center_strong($txt_title)."  </th>
	 ".$th_start."'   rowspan=2><div align='center'><strong>รวม</strong></div></th>
    
  </tr>
  <tr  class='bgHead'>
	 ".$th_start."'  ><div align='center'  ><strong>ชาย</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong>หญิง</strong></div></th>
 
  </tr>
 
  </thead>
	";  
	  break; 
	  
	  case 12:
	  case 14:

	 
	  case 57:
	  
	  if($id<"30"){ $title = "ข้าราชการ"; }
	  if($id=="42"){ $title = "พนักงานราชการ"; }
	  if($id>"55"){ $title = "ลูกจ้างประจำ"; }
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'   colspan=2>   ".center_strong($title)."   </th>
	 ".$th_start."'   rowspan=2><div align='center'><strong>รวม</strong></div></th>
  </tr>
  <tr  class='bgHead'>
	 ".$th_start."'  ><div align='center'  ><strong>ชาย</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong>หญิง</strong></div></th>
  </tr>
  </thead>
	";  
	  break;
	  
	  case 13:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'  >".center_strong("ลำดับ")."</th>
	 ".$th_start."'  ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
	 ".$th_start."'  ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
	 ".$th_start."'  >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start."'  ><div align='center'><strong>ตำแหน่ง</strong></div></th>
	 ".$th_start."'  ><div align='center'><strong>เงินเดือน</strong></div></th>
	 ".$th_start."'  ><div align='center'><strong>สังกัดตามกรอบ</strong></div></th>
	 ".$th_start."'  ><div align='center'><strong>สังกัดปฎิบัติ</strong></div></th>
	 ".$th_start."'  ><div align='center'><strong>สถานะ</strong></div></th>
  </tr>
  </thead>";
	  break;
	  
	  
 

	  case 57222:

 

	 
	  	 $title_text = ' ปีงบประมาณ';
	    
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'  rowspan=2>".center_strong("ลำดับ")."</th>
	 ".$th_start."'   rowspan=2> ".center_strong($title_text)."  </th>
	 ".$th_start."'   colspan=2>".center_strong("ข้าราชการ")."</th>
	 ".$th_start."'   colspan=2><div align='center'><strong>ลูกจ้างประจำ</strong></div></th>
	 ".$th_start."'   colspan=2><div align='center'><strong>พนักงานราชการ</strong></div></th>
	 ".$th_start."'   rowspan=2><div align='center'><strong>รวม</strong></div></th>
  </tr>
  <tr  class='bgHead'>
	 ".$th_start."'  ><div align='center'  ><strong>ชาย</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong>หญิง</strong></div></th>
	 ".$th_start."' ><div align='center'  ><strong>ชาย</strong></div></th>
	 ".$th_start."'   ><div align='center' ><strong>หญิง</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong>ชาย</strong></div></th>
	 ".$th_start."'><div align='center' ><strong>หญิง</strong></div></th>
  </tr>
 
  </thead>
	";  
	  break;	
	  
	  case 10:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'   rowspan=3><div align='center'  ><strong>ประเภท </strong></div></th>
	 ".$th_start."'    rowspan=3><div align='center'  ><strong> รวม</strong></div></th>
	 ".$th_start."'   colspan=13><div align='center'  ><strong> ระดับ</strong></div></th>
  </tr>
  <tr class='bgHead'>
	 ".$th_start."'    colspan=4><div align='center'  ><strong>ทั่วไป </strong></div></th>
	 ".$th_start."'   colspan=5><div align='center'  ><strong>วิชาการ </strong></div></th>
	 ".$th_start."'    colspan=2><div align='center'  ><strong> อำนวยการ </strong></div></th>
	 ".$th_start."'    colspan=2><div align='center'  ><strong> บริหาร</strong></div></th>
  </tr>
  <tr class='bgHead'>
	 ".$th_start."'  ><div align='center'  ><strong> ปฏิบัติงาน</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong> ชำนาญงาน</strong></div></th>
	 ".$th_start."' ><div align='center'  ><strong> อาวุโส </strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong> ทักษะพิเศษ</strong></div></th>
	 ".$th_start."' ><div align='center'  ><strong> ปฏิบัติการ</strong></div></th>
	 ".$th_start."'   ><div align='center'  ><strong> ชำนาญการ</strong></div></th>
	 ".$th_start."'   ><div align='center'  ><strong> ชำนาญการพิเศษ</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong> เชี่ยวชาญ</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong> ทรงคุณวุฒิ</strong></div></th>
	 ".$th_start."'  ><div align='center'  ><strong> ต้น</strong></div></th>
	 ".$th_start."'   ><div align='center'  ><strong> สูง</strong></div></th>
	 ".$th_start."'   ><div align='center'  ><strong> ต้น</strong></div></th>
	 ".$th_start."'   > ".center_strong("สูง")."  </th>
  </tr>
 </thead>	  
	  ";
	  break;
	  /*
	  case 15:
	  $html = "";
	  break; 
	 */ 
	  /* 888888888888888888888 */
	  
	  case 16:
	  case 43:
	  case 55:
	  case 58:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start." width:3%;  '  >".center_strong("ลำดับ")."</th>
	 ".$th_start." width:14%; ' ><div align='center'><strong>เลขประจำตัวประชาชน </strong></div></th>
	 ".$th_start." width:10%;  ' ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
	 ".$th_start."  width:17%;  ' >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start."  width:8%;  ' ><div align='center'><strong>ตำแหน่ง</strong></div></th>
	 ".$th_start."  width:9%;  ' ><div align='center'><strong>ระดับ</strong></div></th>
	 ".$th_start." width:14%;  ' ><div align='center'><strong>ตำแหน่งทางการบริหาร</strong></div></th>
	 ".$th_start."  width:7%;  ' ><div align='center'><strong>เงินเดือน</strong></div></th>
	 ".$th_start."  width:9%;  ' ><div align='center'><strong>สังกัดกรอบ</strong></div></th>
	 ".$th_start." width:9%;  ' ><div align='center'><strong>สังกัดปฎิบัติ</strong></div></th>
  </tr>
 
  </thead>";
	  break;
	  
	  case 17:  
		$html   =  $table_thead_start ;
		$html   .= "
    <th style='  width:3%;  '  >".center_strong("ลำดับ")."</th>
    <th style='  width:14%; ' ><div align='center'><strong>เลขประจำตัวประชาชน </strong></div></th>
    <th style='  width:10%;  ' ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
    <th style='  width:17%;  ' >".center_strong("ชื่อ - สกุล")."</th>
     <th style='  width:8%;  ' ><div align='center'><strong>ตำแหน่ง</strong></div></th>
    <th style='  width:7%;  ' ><div align='center'><strong>เงินเดือน</strong></div></th>
    <th style='  width:9%;  ' ><div align='center'><strong>ระดับเดิม</strong></div></th>
    <th style='  width:9%;  ' ><div align='center'><strong>ระดับใหม่</strong></div></th>
    <th style='  width:14%;  ' ><div align='center'><strong>วัที่ถือครองระดับใหม่</strong></div></th>
 
    <th style='  width:9%;  ' ><div align='center'><strong>สังกัดปฎิบัติ</strong></div></th>
  </tr>
 
  </thead>
	"; 
	  break;
	  
	  case 18:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."  width:5%;  '  >".center_strong("ลำดับ")."</th>
	 ".$th_start." width:15%;  ' ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
	 ".$th_start."  width:20%;  ' >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start." width:30%; ' ><div align='center'><strong>ตำแหน่งเดิม </strong></div></th>
	 ".$th_start."  width:30%; ' ><div align='center'><strong>ตำแหน่งใหม่ </strong></div></th>
  </tr>
 
  </thead>
	"; 
	  break;	  
	  
	  case 15:
	  case 44:
	  case 59:

		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start." width:4%;  '  >".center_strong("ลำดับ")."</th>
	 ".$th_start." width:10%;  ' ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
	 ".$th_start." width:10%;  ' ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
	 ".$th_start." width:20%;  ' >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start." width:20%; ' ><div align='center'><strong>ตำแหน่งในสายงาน</strong></div></th>
	 ".$th_start." width:10%; ' ><div align='center'><strong>สังกัดเดิม</strong></div></th>
	 ".$th_start."  width:10%; ' ><div align='center'><strong>สังกัดใหม่</strong></div></th>
  </tr>
 
  </thead>
	"; 
	  break;
	  

	 
	  case 62222:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."   width:4%;  '  >".center_strong("ลำดับ")."</th>
	 ".$th_start."  width:6%; ' ><div align='center'><strong>ปีงบประมาณ </strong></div></th>
	 ".$th_start."  width:10%;  ' ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
	 ".$th_start."  width:40%;  ' >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start."  width:10%;  ' ><div align='center'><strong>วัันที่เกษียณ</strong></div></th>
  </tr>
 
  </thead>
	"; 
	  break;
	  
	  case 21:

		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."  width:4%; '    >".center_strong("ลำดับ")."</th>
	 ".$th_start."  width:10%; '  ><div align='center'><strong>เลขประจำตัวประชาชน </strong></div></th>
	 ".$th_start." width:10%; '  ><div align='center'><strong>เลขที่ตำแหน่ง </strong></div></th>
	 ".$th_start."   width:15%;  ' >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start." width:10%;  ' ><div align='center'><strong>ตำแหน่ง</strong></div></th>
	 ".$th_start." width:10%;  ' ><div align='center'><strong>ระดับ</strong></div></th>
	 ".$th_start."   width:10%;  ' ><div align='center'><strong>วันที่เริ่มต้นถือครองระดับ</strong></div></th>
	 ".$th_start."  width:10%;  ' ><div align='center'><strong>เงินเดือน</strong></div></th>
	 ".$th_start."  width:10%;  ' ><div align='center'><strong>ตำแหน่งทางการบริหาร</strong></div></th>
	 ".$th_start."  width:10%;  ' ><div align='center'><strong>วันที่บรรจุ</strong></div></th>
 	 ".$th_start." width:10%;  ' ><div align='center'><strong>อายุราชการ</strong></div></th>
  </tr>
 
  </thead>
	"; 
	  break;
	  
	  case 22:
	  case 45:	  
	  case 61:	  
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start." width:10%; '   >".center_strong("ลำดับ")."</th>
	 ".$th_start."  width:15%;  '  >".center_strong("เลขประจำตัวประชาชน")."  </th>
	 ".$th_start."  width:10%; '   >".center_strong("เลขที่ตำแหน่ง")."   </th>
	 ".$th_start."  width:23%;  '  >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start."   width:12% '  ><div align='center'><strong>ตำแหน่งในสายงาน </strong></div></th>
	 ".$th_start."     '  ><div align='center'><strong>ระดับ</strong></div></th>
	 ".$th_start."      '  ><div align='center'><strong>ตำแหน่งทางการบริหาร</strong></div></th>
	 ".$th_start."   width:7%;  '  ><div align='center'><strong>เงินเดือน</strong></div></th>
	 ".$th_start." width:12%; '  ><div align='center'><strong>สังกัดตามกรอบ</strong></div></th>
	 ".$th_start."   width:19%; '  ><div align='center'><strong>สังกัดตามปฎิบัติงาน</strong></div></th>
  </tr>
  </thead>
	"; 
	break;
	
	case 23:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'  ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
	 ".$th_start."'  ><div align='center'><strong>ชื่อ - สกุล</strong></div></th>
	 ".$th_start."'><div align='center'><strong>เลขที่ตำแหน่ง </strong></div></th>
	 ".$th_start."' ><div align='center'><strong>ตำแหน่งในสายงาน </strong></div></th>
	 ".$th_start."' ><div align='center'><strong>ระดับ </strong></div></th>
	 ".$th_start."' ><div align='center'><strong>สังกัดปฎิบัติ </strong></div></th>
 
	 ".$th_start."'><div align='center'><strong>หลักสูตรฝึกอบรม </strong></div></th>
	 ".$th_start."' ><div align='center'><strong>รุ่น </strong></div></th>
	 ".$th_start."' ><div align='center'><strong>วันที่เริ่มอบรม</strong></div></th>
	 ".$th_start."' ><div align='center'><strong>วันที่สิ้นสุดอบรม</strong></div></th>
	 ".$th_start."' ><div align='center'><strong>หน่วยงานที่จัดอบรม</strong></div></th>
  </tr></thead>
   
	"; 
	break;
	
	
	
	case 24:
	$html = "
 <thead width='100%' border='0' cellspacing='0' cellpadding='0' > 
 <tr class='bgHead' class='table table-bordered table-striped table-hover table-condensed' >
	 ".$th_start."width:13%;     ' XRXX  >".center_strong("ลำดับ")."</th>
	 ".$th_start."width:13%;   ' XRXX  ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
	 ".$th_start."  width:8%;    ' XRXX  ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
	 ".$th_start." width:20%;   ' XRXX >".center_strong("ชื่อ - สกุล")."</th>
	 ".$th_start." width:20% '  XRXX ><div align='center'><strong>ตำแหน่งทางการบริหาร</strong></div></th>
	 ".$th_start." width:22% '  XRXX ><div align='center'><strong>สำนัก/กอง </strong></div></th>
  </tr>
  </thead>
   
	"; 
	break;
	
	case 25:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start." width:10%; '   >".center_strong("ลำดับ")."</th>
	 ".$th_start." '  >  ".center_strong("เลขที่ตำแหน่ง")."  </th>
	 ".$th_start." '  >  ".center_strong("ประเภทตำแหน่ง")."  </th>
	 ".$th_start." '  > ".center_strong("ตำแหน่ง")."   </th>
	 ".$th_start." '  >".center_strong("ระดับ")."   </th>
	 ".$th_start." '  >  ".center_strong("สายงาน")."   </th>
	 ".$th_start." '  > ".center_strong("ตำแหน่งทางการบริหาร")."  </th>
	 ".$th_start."'  >  ".center_strong("สถานะ")."    </th>
	 ".$th_start."'  >  ".center_strong("ชื่อ - สกุล ผู้ถือครอง")."   </th>
	 ".$th_start."'  > ".center_strong("สังกัดปฎิบัติ")."</th>
  </tr>
  
  </thead>
	"; 
	break; 
	
	case 26:
	case 48:
	case 64:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempMinistry&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;Organize&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;DivisionName&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempPositionNo&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempLine&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempPositionType&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempLevel&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempManagePosition&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempSkill&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempOganizeType&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempProvince&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempPositionStatus&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempPrename&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempFirstName&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempLastName&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempCardNo&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempGender&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempBirthDate&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempStartDate&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempSalary&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempPositionSalary&nbsp;&nbsp;</strong></div></th>	
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempEducationLevel&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempEducationName&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempEducationMajor&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempGraduated&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>tempEducationCountry&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempScholarType&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempMovementType&nbsp;&nbsp;</strong></div></th>
	 ".$th_start."'><div align='center'><strong>&nbsp;&nbsp;tempMovementDate&nbsp;&nbsp;</strong></div></th>
  </tr>
  
  </thead>
	"; 
	break; 

	case 27:
		$html   =  $table_thead_start ;
		$html   .= "
	 ".$th_start." width:10%; '   ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
	 ".$th_start." width:10%; '   ><div align='center'><strong>ประเภทตำแหน่ง</strong></div></th>
	 ".$th_start." width:10%; '   ><div align='center'><strong>ระดับ</strong></div></th>
	 ".$th_start." width:10%; '   ><div align='center'><strong>สายงาน</strong></div></th>
	 ".$th_start." width:10% '  ><div align='center'><strong>ตำแหน่งในสายงาน </strong></div></th>
	 ".$th_start." width:10%; '   ><div align='center'><strong>ตำแหน่งทางการบริหาร</strong></div></th>
	 ".$th_start." width:10%; '   ><div align='center'><strong>เงินเดือน</strong></div></th>
	 ".$th_start." width:15% '  ><div align='center'><strong>สังกัดตามกรอบ</strong></div></th>
 
  </tr>
  </thead>"; 
	break;
	case 28:
		$html   =  $table_thead_start ;
		$html   .= "
     ".$th_start." width:25%; '  ><div align='center'><strong>ประเภทตำแหน่ง</strong></div></th>
     ".$th_start." '  ><div align='center'><strong>ตำแหน่งในสายงาน</strong></div></th>
      ".$th_start."  width:15%;  '  ><div align='center'><strong>ข้าราชการ</strong></div></th>
  </tr>
  </thead>"; 
	break;

     case 29:
	 case 46:
	 case 63:
		$html   =  $table_thead_start ;
		$html   .= "
    ".$th_start."width:8%; '   >".center_strong("ลำดับ")."</th>
    ".$th_start."width:12%;  '  ><div align='center'><strong>เลขประจำตัวประชาชน </strong></div></th>
    ".$th_start."width:20%;   '  >".center_strong("ชื่อ - สกุล")."</th>
    ".$th_start."width:18%;  '  ><div align='center'><strong>ตระกูลเครื่องอิสริยาภรณ์ </strong></div></th>
    ".$th_start."width:18%;    '  ><div align='center'><strong>ชั้นเครื่องราชอิสริยาภรณ์ </strong></div></th>
    ".$th_start."'><div align='center'><strong>วันที่ได้รับพระราชทาน </strong></div></th>
	".$th_start."'><div align='center'><strong>วันที่จ่ายเครื่องราชฯ </strong></div></th>
	".$th_start."'><div align='center'><strong>วันที่ส่งคืนเครื่องราชฯ </strong></div></th>

  </tr>
 
  </thead>
	"; 
	break;
    case 30:

		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:10%; '  rowspan='2'>".center_strong("ลำดับ")."</th>
".$th_start."width:20%;  '   rowspan='2'><div align='center'><strong>ประเภทของตำหน่ง </strong></div></th>
".$th_start."width:20%;  '   rowspan='2'><div align='center'><strong>ระดับ </strong></div></th>
".$th_start."width:20%;  '   rowspan='2'><div align='center'><strong>ตำแหน่งในสายงาน </strong></div></th>
".$th_start."width:20%; ' colspan=4  ><div align='center'><strong>สถานภาพของตำแหน่ง</strong></div></th>
".$th_start."width:5%; '  rowspan='2'><div align='center'><strong>รวม</strong></div></th>
 
  </tr>
   <tr class='bgHead'>
".$th_start."'><div align='center'><strong>ว่าง ไม่มีเงิน</strong></div></th>
".$th_start."'><div align='center'><strong>ว่าง มีเงิน</strong></div></th>
".$th_start."'> ".center_strong("มีคนถือครอง")."     </th>
".$th_start."'  ".center_strong("ยุบเลิก")." > </th>
  </tr>
  </thead>
	"; 
	break;
	case 34:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."'> ".center_strong("สถานภาพของตำแหน่ง")."    </th>
".$th_start."'> ".center_strong("ข้าราชการ")."   </th>
  </tr>	
		</thead> ";
	break;
	
    case 32222:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:10%; '  rowspan='2'>".center_strong("ลำดับ")."</th>
".$th_start."width:10%;  '   rowspan='2'><div align='center'><strong>ตำแหน่ง </strong></div></th>
".$th_start."width:10%; ' colspan=2  ><div align='center'><strong>สถานภาพของตำแหน่ง</strong></div></th>
".$th_start."width:5%; '  rowspan='2'><div align='center'><strong>รวม</strong></div></th>
 
  </tr>
   <tr class='bgHead'>
".$th_start."' >  ".center_strong("ว่าง ไม่มีเงิน")."  </th>
".$th_start."' >  ".center_strong("ว่าง มีเงิน")."   </th>
  </tr>
  </thead>
	"; 
	break;
	
	case 32:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." width:3%; '  >".center_strong("ลำดับ")."</th>
".$th_start."   '  >  ".center_strong("เลขที่ตำแหน่ง")." </th>
".$th_start."  '  > ".center_strong("ประเภทตำแหน่ง")."   </th>
".$th_start." width:17%; '  >".center_strong("สายงาน")."  </th>
".$th_start." width:17%; '  >   ".center_strong("ตำแหน่งในสายงาน")."  </th>
".$th_start."  ' >".center_strong("ระดับ")."</th>
".$th_start."  ' > ".center_strong("เงินเดือน")."  </th>
".$th_start."  ' >  ".center_strong("สังกัดกรอบ")." </th>
".$th_start."  ' > ".center_strong("สถานะ")."   </th>
  </tr>
  </thead>"; 
	break;
	
	
	
	case 33:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." width:25%; '   >".center_strong("ลำดับ")."</th>
".$th_start."' >".center_strong("ประเภทตำแหน่ง")."  </th>
".$th_start." width:25%; '    > ".center_strong("จำนวน")."  </th>
  </tr>
  </thead>
	"; 
	break;


    case 33222:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:10%; '  rowspan='2'>".center_strong("ลำดับ")."</th>
".$th_start."width:20%;  '   rowspan='2'><div align='center'><strong>ตำแหน่ง </strong></div></th>
".$th_start."width:20%; ' colspan=5  ><div align='center'><strong>สถานภาพของตำแหน่ง</strong></div></th>
".$th_start."width:5%; '  rowspan='2'><div align='center'><strong>รวม</strong></div></th>
 
  </tr>
   <tr class='bgHead'>
".$th_start."'><div align='center'><strong>ทั่วไป</strong></div></th>
".$th_start."'><div align='center'><strong>วิชาการ</strong></div></th>
".$th_start."'><div align='center'><strong>อำนวยการ</strong></div></th>
".$th_start."'><div align='center'><strong>บริหาร</strong></div></th>
".$th_start."'><div align='center'><strong>ระบบซี</strong></div></th>
  </tr>
  </thead>
	"; 
	break;
	
	case 35:
	case 47: 
	case 65:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:5%; '   >".center_strong("ลำดับ")."</th>
".$th_start."width:5%;  '    >   ".center_strong("ปี")."  </th>
".$th_start."width:25%;  '   >  ".center_strong("ประเภทการลา")."  </th>  
".$th_start."width:10%; '  > ".center_strong("จำนวน ( วัน )")." </th>
".$th_start."width:10%; '  >".center_strong("จำนวน ( ครั้ง )")."</th>
  </tr>
  </thead>
	";  
	break;
		 
	case 38:   	
		$html   =  $table_thead_start ;
		$html   .= " 
".$th_start."width:5%; '   >".center_strong("ลำดับ")."</th>
".$th_start."'    > ".center_strong($title_1)."   </th>
".$th_start."'  > ".center_strong("ชาย")."   </th>
".$th_start."'> ".center_strong("หญิง")."   </th>
".$th_start."'>  ".center_strong("รวม")."   </th>
  </tr>
  </thead> ";
	break;

		case 51:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:3%; '   >".center_strong("ลำดับ")."</th>
".$th_start."width:22%; ' > ".center_strong("เลขประจำตัวประชาชน")." </th>
".$th_start."width:18%; ' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."width:20%; ' > ".center_strong("ตำแหน่ง ระดับ และกลุ่มงาน")." </th>
 
  </tr>
  </thead>
	";  
	break;


		case 52222:   
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:3%; '   >".center_strong("ลำดับ")."</th>
".$th_start."width:22%; ' ><div align='center'><strong>เลขประจำตัวประชาชน </strong></div></th>
".$th_start."width:18%; ' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."width:20%; ' ><div align='center'><strong>";
	if($id==39){
	$html .= "ตำแหน่ง กลุ่มงาน และด้านการปฎิบัติงาน";
	}
	if($id==52){
	$html .= "ตำแหน่ง ระดับ และกลุ่มงาน";
	}
	$html .= "</strong></div></th>
".$th_start."width:5%; ' > ".center_strong("เพศ")."</th>
  </tr>
  </thead>
	";  
	break;
		


		case 53: 		  
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:3%;'   >".center_strong("ลำดับ")."</th>
".$th_start."width:22%;' > ".center_strong("เลขประจำตัวประชาชน")."  </th>
".$th_start."width:18%;' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."width:20%;' > ";
	if($id==40){  $x_title =   "ตำแหน่ง กลุ่มงาน และด้านการปฎิบัติงาน";}
	if($id==53){  $x_title =   "ตำแหน่ง ระดับ และกลุ่มงาน";}
$html .= center_strong($x_title)." </th>
".$th_start."width:5%;' >  ".center_strong("อายุ")." </th>
  </tr>
  </thead>
	";  
	break;
	

	  case 555555:
	 
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."' rowspan=2>".center_strong("ลำดับ")."</th>
".$th_start."' rowspan=2><div align='center'><strong>ปีงบประมาณ</strong></div></th>
".$th_start."' colspan=3><div align='center'><strong>";
	if($id==41){
	$html .= "พนักงานราชการ";
	}
	if($id==55){
	$html .= "ลูกจ้างประจำ";
	}
	$html .= "</strong></div></th>
 
 
  </tr>
  <tr  class='bgHead'>
".$th_start."' ><div align='center'  ><strong>จำนวนผู้ออกจากราชการ</strong></div></th>
".$th_start."' ><div align='center'   ><strong>จำนวนทั้งหมด</strong></div></th>
".$th_start."' ><div align='center'      ><strong>อัตราการที่ออกจากราชการ</strong></div></th>
  </tr>
  </thead>
	";
	  break;
	
		
		case 201:
		case 202:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:10%; '   >".center_strong("ลำดับ")."</th>
".$th_start."width:37%;'  > ".center_strong("หน่วยงาน")."  </th>
".$th_start."width:10%;'  > ".center_strong("จำนวน <br/>( คน )")." </th>
".$th_start."width:11%;'   >".center_strong("เงินเดือนทั้งหมด <br/> ณ ".toThaiNumber($title_1)." <br/>( บาท )")."</th>
".$th_start."width:10%;'  ><div align='center'><strong>วงเงินเลื่อน <br/>๓ % <br/>( บาท ) </strong></div></th>";
	   if($id!=202){ 
	   $html   .=  "
".$th_start."width:11%;  '  > ".center_strong("วงเงินจัดสรรสุทธิ  ๒.๕ % <br/>( บาท ) ")."</th>
".$th_start."width:12%; '  > ".center_strong("กันเงินไว้ในอำนาจ <br/> อปภ. 0.๕ % <br/>( บาท ) ")." </div></th> ";
	   }
	   $html   .=  "</tr>
  
  </thead>
	"; 

 
	
        break;
		case 203:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."width:5%; '  rowspan='2' >".center_strong("ลำดับ")."</th>
".$th_start."' rowspan='2' ><div align='center'><strong>เลขประจำตัว<br/>ประชาชน</strong></div></th>
".$th_start."' rowspan='2' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."' colspan='4'  ><div align='center'><strong>ตำแหน่งและส่วนราชการ</strong></div></th>
".$th_start."' rowspan='2' ><div align='center'><strong>ป่วย</strong></div></th>
".$th_start."' rowspan='2' ><div align='center'><strong>กิจ</strong></div></th>
".$th_start."' rowspan='2'  ><div align='center'><strong>ป่วยจำเป็น</strong></div></th>
".$th_start."' rowspan='2' ><div align='center'><strong>มาสาย</strong></div></th>
".$th_start."' rowspan='2'  ><div align='center'><strong>คลอดบุตร</strong></div></th>
".$th_start."' rowspan='2' ><div align='center'><strong>อุปสมบท</strong></div></th>
".$th_start."' rowspan='2'  ><div align='center'><strong>ศึกษา / อบรม</strong></div></th>
".$th_start."' rowspan='2'  ><div align='center'><strong>เงินเดือน<br/>เดิม<br/>( บาท )</strong></div></th>
".$th_start."' rowspan='2'  ><div align='center'><strong>ฐานในการ<br/>คำนวณ<br/>( บาท )</strong></div></th>
".$th_start."' colspan='2' ><div align='center'><strong>ผลการประเมิน</strong></div></th>
".$th_start."' rowspan='2'  ><div align='center'><strong>ร้อยละที่<br/>ได้เลื่อน</strong></div></th>
".$th_start."' rowspan='2'  ><div align='center'><strong>จำนวนเงินที่<br/>ได้เลื่อน<br/>( บาท )</strong></div></th>	
".$th_start."' rowspan='2'  ><div align='center'><strong>เงินเดือน<br/>ที่ได้รับ<br/>( บาท )</strong></div></th>
".$th_start."' rowspan='2' ><div align='center'><strong>หมายเหตุ</strong></div></th>
".$th_start."' rowspan='2' ><div align='center'><strong>สังกัดปฎิบัติ</strong></div></th>
  </tr>
   <tr class='bgHead'>
".$th_start."'   ><div align='center'><strong>ชื่อตำแหน่งในการบริหารงาน</strong></div></th>
".$th_start."'   ><div align='center'><strong>ประเภท</strong></div></th>
".$th_start."'   ><div align='center'><strong>ระดับตำแหน่ง</strong></div></th>
".$th_start."'   ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
".$th_start."'   ><div align='center'><strong>ระดับ ร้อยละ</strong></div></th>
".$th_start."'   ><div align='center'><strong>คะแนน</strong></div></th>
  </tr>
  
  </thead>
	"; 
        break;	
		
		case 204:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." width:5%; '  rowspan='2' ><div align='center'><strong>ลำดับ<br/>ที่</strong></div></th>
".$th_start." width:10%;  '  rowspan='2' ><div align='center'><strong>เลขประจำตัว</strong></div></th>
".$th_start."  width:20%;  '  rowspan='2' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."  width:23%;   ' colspan='2'  ><div align='center'><strong>ชื่อตำแหน่ง - กลุ่มงาน</strong></div></th>
".$th_start."   width:7%;'  rowspan='2' ><div align='center'><strong>ค่าตอบแทน<br/>เดิม <br/>( บาท )</strong></div></th>
".$th_start."  width:8%; ' colspan='2'  ><div align='center'><strong>ผลการประเมิน</strong></div></th>
".$th_start."   width:5%;'  rowspan='2' ><div align='center'><strong>ร้อยละ<br/>ที่ได้เลื่อน</strong></div></th>
".$th_start."  width:8%;'  rowspan='2' ><div align='center'><strong>จำนวนเงิน<br/>ที่ได้เลื่อน <br/>( บาท ) </strong></div></th>
".$th_start."   width:7%;'  rowspan='2' ><div align='center'><strong>ค่าตอบแทน<br/>ที่ได้รับ <br/>( บาท ) </strong></div></th>
".$th_start." width:8%;  '  rowspan='2' ><div align='center'><strong>หมายเหตุ</strong></div></th>
  </tr>
   <tr class='bgHead'>
".$th_start." width:13%;' ><div align='center'><strong>กลุ่มงาน</strong></div></th>
".$th_start."' ><div align='center'><strong>เลขที่ตำแหน่ง</strong></div></th>
".$th_start."' ><div align='center'><strong>คะแนน</strong></div></th>
".$th_start."width:5%;' >  ".center_strong("ระดับ")."   </th>
  </tr>
    </thead>
  <tr style='background-color:#fff;'  > 
".$th_start."'>   </th>
".$th_start."'>   </th>
".$th_start."'>   </th>
".$th_start."' colspan=2  > <u><strong> ".DEPARTMENT_OF_DISATER." </strong></u></th>
".$th_start."'>   </th>
".$th_start."'>   </th>
".$th_start."'>   </th>
".$th_start."'>   </th>
".$th_start."'>   </th>
".$th_start."'>   </th>
".$th_start."'>   </th>

  </tr>
  
  

	"; 
		break;
		
		
		case 205:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." '    ><div align='center'><strong>ลำดับ<br/>ที่</strong></div></th>
".$th_start."width:13%;'      ><div align='center'><strong>เลขประจำตัวประชาชน</strong></div></th>
".$th_start." '    >".center_strong("ชื่อ - สกุล")."</th>
".$th_start." '    ><div align='center'><strong>ตำแหน่ง</strong></div></th>
".$th_start." '    ><div align='center'><strong>เลขที่<br/>ตำแหน่ง</strong></div></th>
".$th_start." '   ><div align='center'><strong>ค่าตอบแทน<br/> บาท/เดือน</strong></div></th>
".$th_start." '    ><div align='center'><strong>ให้ได้รับเงินเพิ่ม<br/> การครองชีพ<br/>ชั่วคราว</strong></div></th>
".$th_start." '    >  ".center_strong("รวมรายได้")."  </th>
  </tr>
  </thead>";	
   break;	
		
	case 206:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." '  rowspan='2' > ".center_strong("ที่")."   </th>
".$th_start."width:13%;' rowspan='2'     > ".center_strong("เลขประจำตัว<br/>ประชาชน")."  </th>
".$th_start." '  rowspan='2' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start." ' colspan='4'  >".center_strong("ตำแหน่งและส่วนราชการ")."   </th>
".$th_start." ' rowspan='2'     ><div align='center'><strong>เงินเดือน<br/>เดิม<br/> ( บาท )</strong></div></th>
".$th_start." ' rowspan='2'     ><div align='center'><strong>ฐานในการ<br/>คำนวณ<br>( บาท )</strong></div></th>
".$th_start." ' colspan='2'     ><div align='center'><strong>ผลการประเมิน</strong></div></th>
".$th_start." ' rowspan='2'     ><div align='center'><strong>ร้อยละที่<br/>ได้เลื่อน</strong></div></th>
".$th_start." ' rowspan='2'     ><div align='center'><strong>จำนวนเงินที่<br/>ได้เลื่อน <br/>( บาท )</strong></div></th>
".$th_start." ' rowspan='2'     ><div align='center'><strong>เงินเดือน<br/>ที่ได้รับ <br/>( บาท )</strong></div></th>
".$th_start." ' rowspan='2'     ><div align='center'><strong>หมายเหตุ</strong></div></th>
  </tr>
   <tr class='bgHead'>
".$th_start."' ><div align='center'><strong>ชื่อตำแหน่ง<br/>ในการบริหารงาน</strong></div></th>
".$th_start."' ><div align='center'><strong>ประเภท</strong></div></th>
".$th_start."' ><div align='center'><strong>ระดับ<br/>ตำแหน่ง</strong></div></th>
".$th_start."' >  ".center_strong("เลขที่<br/>ตำแหน่ง")."   </th>
".$th_start."' >  ".center_strong("ระดับ")."    </th>
".$th_start."' > ".center_strong("คะแนน")."    </th>
   </tr>
   </thead>";
	break;	
		
	case 207:
		$html   =  $table_thead_start ;
		$html   .= " 
".$th_start."'  rowspan='2' > ".center_strong("ที่")."   </th>
".$th_start."width:13%;' rowspan='2'     >  ".center_strong("เลขประจำตัว<br/>ประชาชน")."  </th>
".$th_start."width:15%; '  rowspan='2' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."' colspan='4'  > ".center_strong("ตำแหน่งและส่วนราชการ")."   </th>
".$th_start."' rowspan='2'     ><div align='center'><strong>เงินเดือน<br/>ที่ได้รับ <br/>( บาท )</strong></div></th>
".$th_start."width:12%; ' rowspan='2'     ><div align='center'><strong>ให้ได้รับเพิ่ม<br/>การครองชีพชั่วคราว<br/>รายเดือน ( บาท )</strong></div></th>
".$th_start." ' rowspan='2'     ><div align='center'><strong>รวมรายได้ <br/>( บาท )</strong></div></th>
".$th_start."' rowspan='2'     >  ".center_strong("หมายเหตุ")."  </th>
  </tr>
   <tr class='bgHead'>
".$th_start."' ><div align='center'><strong>ชื่อตำแหน่ง<br/>ในการบริหารงาน</strong></div></th>
".$th_start."' ><div align='center'><strong>ประเภท</strong></div></th>
".$th_start."' ><div align='center'><strong>ระดับ<br/>ตำแหน่ง</strong></div></th>
".$th_start."' ><div align='center'><strong>เลขที่<br/>ตำแหน่ง</strong></div></th>
 
   </tr>
   </thead>";
	break;	
	
	
	case 208:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start."'  rowspan='2' > ".center_strong("ที่")."   </th>
".$th_start."width:13%;' rowspan='2'     >  ".center_strong("เลขประจำตัว<br/>ประชาชน")."  </th>
".$th_start." '  rowspan='2' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start." ' colspan='4'  > ".center_strong("ตำแหน่งและส่วนราชการ")."   </th>
".$th_start."' rowspan='2'  >  ".center_strong("เงินเดือนเดิม <br/>( บาท )")."  </th>
".$th_start." ' rowspan='2' >  ".center_strong("ฐานในการคำนวณ <br/>( บาท )")."  </th>
".$th_start." ' colspan='2'   >  ".center_strong("ผลการประเมิน")."  </th>
".$th_start." ' rowspan='2'  > ".center_strong("ร้อยละที่ได้เลื่อน")."  </th>
".$th_start." width:7%; ' rowspan='2'  > ".center_strong("จำนวนเงิน<br/>ที่ได้เลื่อน <br/>( บาท )")."   </th>
".$th_start." width:7%; ' rowspan='2' > ".center_strong("เงินเดือน<br/>ที่ได้รับ <br/>( บาท )")."   </th>
".$th_start." width:7%; ' rowspan='2' >".center_strong("เงินเดือนขั้นสูง <br/>( บาท )")."  </th>
".$th_start."width:7%; ' rowspan='2'>".center_strong("ให้ได้รับค่าตอบแทนพิเศษ <br/>( บาท )")."   </th>
".$th_start." ' rowspan='2'  >   ".center_strong("หมายเหตุ")."  </th>
  </tr>
   <tr class='bgHead'>
".$th_start."' >   ".center_strong("ชื่อตำแหน่งในการบริหารงาน")." </th>
".$th_start."' >   ".center_strong("ประเภท")."   </th>
".$th_start."' >   ".center_strong("ระดับตำแหน่ง")."   </th>
".$th_start."' >   ".center_strong("เลขที่ตำแหน่ง")."   </th>
".$th_start."' >   ".center_strong("ระดับ")."    </th>
".$th_start."' >   ".center_strong("คะแนน")."  </th>
   </tr>
   </thead>";
	break;		

	case 209:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." '  rowspan='2' >   ".center_strong("ที่")."  </th>
".$th_start."width:13%;' rowspan='2'     ><div align='center'><strong>เลขประจำตัว<br/>ประชาชน</strong></div></th>
".$th_start."'  rowspan='2' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."' colspan='4'  > ".center_strong("ตำแหน่งและส่วนราชการ")."    </th>
".$th_start." '  rowspan='2' ><div align='center'><strong>ป่วย</strong></div></th>
".$th_start." '  rowspan='2' ><div align='center'><strong>ลากิจ</strong></div></th>
".$th_start."'  rowspan='2' ><div align='center'><strong></strong></div></th>
".$th_start." '  rowspan='2' ><div align='center'><strong>มาสาย</strong></div></th>
".$th_start." '  rowspan='2' ><div align='center'><strong>คลอดบุตร</strong></div></th>
".$th_start." '  rowspan='2' ><div align='center'><strong>อุปสมบท</strong></div></th>
".$th_start." '  rowspan='2' ><div align='center'><strong></strong></div></th>
".$th_start." '  rowspan='2' >  ".center_strong("เงินเดือนเดิม <br/>( บาท )")."  </th>
".$th_start." ' rowspan='2'     > ".center_strong("ฐานในการคำนวณ <br/>( บาท )")."  </th>
".$th_start." ' colspan='2'   > ".center_strong("ผลการประเมิน")."     </th>
".$th_start." ' rowspan='2'  > ".center_strong("ร้อยละที่ได้เลื่อน")."     </th>
".$th_start." ' rowspan='2' >   ".center_strong("จำนวนเงินที่ได้เลื่อน <br/>( บาท )")."   </th>
".$th_start." ' rowspan='2' >  ".center_strong("เงินเดือนที่ได้รับ <br/>( บาท )")."  </th>
    </tr>
	
   <tr class='bgHead'>
".$th_start."' > ".center_strong("ชื่อตำแหน่งในการบริหารงาน")."   </th>
".$th_start."' > ".center_strong("ประเภท")."      </th>
".$th_start."' >  ".center_strong("ระดับตำแหน่ง")."   </th>
".$th_start."' >   ".center_strong("เลขที่ตำแหน่ง")."  </th>
".$th_start."' >  ".center_strong("ระดับ")."   </th>
".$th_start."' >  ".center_strong("คะแนน")."  </th>
   </tr>
  </thead>";
	break;	


	case 210:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." '  rowspan='2' >  ".center_strong("ที่")." </th>
".$th_start."width:13%;' rowspan='2' >".center_strong("เลขประจำตัว<br/>ประชาชน")." </th>
".$th_start." '  rowspan='2'>".center_strong("ชื่อ - สกุล")."</th>
".$th_start." ' colspan='4' >".center_strong("ตำแหน่งและส่วนราชการ")."   </th>
".$th_start." '  rowspan='2'>".center_strong("เงินเดือนเดิม <br/>( บาท )")."      </th>
".$th_start." ' rowspan='2' >".center_strong("ฐานในการคำนวณ <br/>( บาท )")."   </th>
".$th_start." ' colspan='2' >".center_strong("ผลการประเมิน")."    </th>
".$th_start." ' rowspan='2' >".center_strong("ร้อยละที่ได้เลื่อน")."     </th>
".$th_start." ' rowspan='2' >".center_strong("จำนวนเงินที่ได้เลื่อน <br/>( บาท )")."   </th>
".$th_start." ' rowspan='2' >".center_strong("เงินเดือนที่ได้รับ <br/>( บาท )")."  </th>
".$th_start." ' rowspan='2' >".center_strong("ให้ได้รับค่าตอบแทนพิเศษ <br/>( บาท )")."   </th>
".$th_start." ' rowspan='2' >".center_strong("สังกัดกรอบ")."      </th>
    </tr>
	
   <tr class='bgHead'>
".$th_start."' >   ".center_strong("ชื่อตำแหน่งในการบริหารงาน")."  </th>
".$th_start."' >  ".center_strong("ประเภท")."       </th>
".$th_start."'  > ".center_strong("ระดับตำแหน่ง")."     </th>
".$th_start."' >  ".center_strong("เลขที่ตำแหน่ง")."    </th>
".$th_start."' >  ".center_strong("ระดับ")."     </th>
".$th_start."' >  ".center_strong("คะแนน")."     </th>
   </tr>
  </thead>";
	break;	

    case 211:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." '   > ".center_strong("ที่")."       </th>
".$th_start."width:13%;'>".center_strong("เลขประจำตัวประชาชน")."</th>
".$th_start."' >  ".center_strong("เลขที่ตำแหน่ง")." </th>
".$th_start." '   >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."' >  ".center_strong("ตำแหน่งในสายงาน")."   
".$th_start."' ><div align='center'><strong>ระดับ</strong></div></th>
".$th_start." '      ><div align='center'><strong>สังกัด ( ปฎิบัติ )</strong></div></th>
".$th_start." '  >    ".center_strong("จัดการข้อมูล")."    </th>
   </tr>
  </thead>"; 
	break;

	case 301:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." '  rowspan='2' >".center_strong("ลำดับ")."</th>
".$th_start." '  rowspan='2' >".center_strong("ชื่อ - สกุล")."</th>
".$th_start."width:13%;' rowspan='2'  >".center_strong("เลขประจำตัวประชาชน")."</th>
".$th_start." ' colspan='3'  >  ".center_strong("ตำแหน่งและส่วนราชการ")." </th>
".$th_start." ' rowspan='2'  > ".center_strong("ค่าจ้าง<br/>ที่เต็มขั้น <br/>( บาท )")." </th>
".$th_start." ' colspan='3'  >".center_strong("ค่าตอบแทนพิเศษ")."</th>
".$th_start."'  rowspan='2'     >   ".center_strong("ผลการประเมิน")."</th>
  </tr>                           
                      
   <tr class='bgHead'>
".$th_start." width:13%;' > ".center_strong("สังกัด / ตำแหน่ง")."</th>
".$th_start."' >".center_strong("ลำดับ")."</th>
".$th_start."' >".center_strong("เลขที่<br/>ตำแหน่ง")."</th>
".$th_start."' >".center_strong("ร้อยละ ๒ <br/>( บาท )")."</th>
".$th_start."' >".center_strong("ร้อยละ ๔ <br/>( บาท )")."</th>
".$th_start."' >".center_strong("ร้อยละ ๖ <br/>( บาท )")."</th>
  </tr>   
                    
  </thead>";
	break;	
	

		
	case 302:
		$html   =  $table_thead_start ;
		$html   .= "
".$th_start." '  rowspan='2' >".center_strong("ลำดับ")."</th>  
".$th_start." '  rowspan='2' > ".center_strong("ชื่อ - สกุล")."</th>
".$th_start."width:13%;' rowspan='2'  >".center_strong("เลขประจำตัวประชาชน")."</th>
".$th_start." ' colspan='3'  >".center_strong("ตำแหน่งและส่วนราชการ")."</th>
".$th_start." ' colspan='2'  >".center_strong("อัตราค่าจ้าง")."</th>
".$th_start." ' rowspan='2'  >".center_strong("หมายเหตุ")."</th>        
  </tr>
    
   <tr class='bgHead'>
".$th_start."' > ".center_strong("สังกัด / ตำแหน่ง")."</th>
".$th_start."' > ".center_strong("ระดับ")."</th>
".$th_start."' > ".center_strong("เลขที่<br/>ตำแหน่ง")."</th>
".$th_start."' >".center_strong("ก่อนเลื่อน <br/>( บาท ) ")."</th>
".$th_start."' >".center_strong("ให้ได้รับ <br/>( บาท )")."</th>
 
  </tr>
  
  </thead>";
	break;	
				
	} //switch
	
	return $html;
 
}

function center_strong($txt){
   return "<div align='center'><strong>".$txt."</strong></div>";
}
 

function sql_where_age($AGE_BETWEEN=0,$type=2){
       $q_where = '';
	   if($AGE_BETWEEN>0){
	   if($type==2){
		   switch ($AGE_BETWEEN) {
			case 1:
			$q_where = ' and DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) < 20   ';
			break;
	
			case 2:
			$q_where = '  and ( (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) > 19 ) and (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) < 30))   ';
			break;	
			
			case 3:
			$q_where = '  and ( (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) > 29 ) and (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) < 40))   ';
			break;
			
			case 4:
			$q_where = '  and ( (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) > 39 ) and (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) < 50))   ';
			break;
			
			case 5:
			$q_where = '  and ( (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) > 49 ) and (DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) < 61))   ';
			break;
			
			case 6:
			$q_where = ' and DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) > 60   ';
			break;
			
			}//switch
		 }else{  // type
		 
			$q_where = ' and DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) = '.$AGE_BETWEEN.'   ';
		 }
	} // if > 0
 
     return $q_where;

}

    function officer_year_between($yearis=0,$filed_date = 'b.COM_SDATE'){
	    if($yearis > 2500){
	    	$yearis2 = $yearis-543;
		}else{
	    	$yearis2 = $yearis;
		}
	   $q_where = " AND ".$filed_date." between convert(datetime,'10/01/".($yearis2-1)."') and convert(datetime,'09/30/".($yearis2)."') ";
	
	   return $q_where;
	}
	
    function officer_year_not_between($yearis=0,$filed_date = 'b.COM_SDATE'){
	    if($yearis > 2500){
	    	$yearis2 = $yearis-543;
		}else{
	    	$yearis2 = $yearis;
		}
	   $q_where = " AND (".$filed_date." not between convert(datetime,'10/01/".($yearis2-1)."') and convert(datetime,'09/30/".($yearis2)."') OR (".$filed_date." is null  ) )";
	
	   return $q_where;
	}
	
	
    function officer_in_year($yearis=0,$filed_date = 'b.PER_DATE_RESIGN'){ // ยังอยู่ในปีงบประมาณนี้ 
	    if($yearis > 2500){
	    	$yearis2 = $yearis-543;
		}else{
	    	$yearis2 = $yearis;
		}
	   $q_where = " AND (".$filed_date." not between convert(datetime,'10/01/1800') and convert(datetime,'09/30/".($yearis2)."') OR (".$filed_date." is null  ) )";
	
	   return $q_where;
	}

    function be_user_until($yearis=0,$filed_date = 'b.PER_DATE_RESIGN'){ // ยังอยู่ในปีงบประมาณนี้ 
	   $yearis2 = $yearis-543;
	   $q_where = "  AND (PER_DATE_ENTRANCE < CAST('".($yearis2)."-09-30' AS DATE))    ";
	   
	   return $q_where;
	}
	
	function not_between_bugget_year($yearis=0){
	   $yearis2 = $yearis-543;
	   $q_where = "   AND a.PER_STATUS_CIVIL = 2   AND (PER_DATE_RESIGN NOT BETWEEN CAST('".($yearis2-1)."-10-01' AS DATE) and CAST('".($yearis2)."-09-30' AS DATE))  ";
	   
	   return $q_where;
	}
	
	function not_between_bugget_year2($yearis=0){
	   $yearis2 = $yearis-543;
	   $q_where = "    AND (PER_DATE_RESIGN NOT BETWEEN CAST('".($yearis2-1)."-10-01' AS DATE) and CAST('".($yearis2)."-09-30' AS DATE)) AND (PER_DATE_ENTRANCE < CAST('".($yearis2)."-09-30' AS DATE))    ";
	   
	   return $q_where;
	}
	
	function officer_year($yearis=0,$filed_date = 'a.PER_DATE_RETIRE'){
	
	 		 $yearis2 = $yearis-543;
           	 $q_where = ' and ((year('.$filed_date.') = '.$yearis.')or(year('.$filed_date.') = '.$yearis2.'))   ';
			 
			 return  $q_where;
	
	}
	
	function table_all3group_w_gender_row($start_no=1,$value='',$officer_num_m=0,$officer_num_w=0,$regular_emp_num_m=0,$regular_emp_num_w=0,$temp_emp_sum_m=0,$temp_emp_sum_w=0,$usetd=6){
	   $all_emp_num = $officer_num_m+$regular_emp_num_m+$temp_emp_num_m+$officer_num_w+$regular_emp_num_w+$temp_emp_num_w;
	   $html = 	"<tr  style='height:0.7cm;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP   >&nbsp;&nbsp;".$value."</td> 
			 <td CENTER_TOP >".number_format($officer_num_m,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($officer_num_w,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($regular_emp_num_m,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($regular_emp_num_w,0)."&nbsp;&nbsp;</td>
			 <td CENTER_TOP >".number_format($temp_emp_sum_m,0)."&nbsp;&nbsp;</td> 	
			 <td CENTER_TOP >".number_format($temp_emp_sum_w,0)."&nbsp;&nbsp;</td> 	
			 <td CENTER_TOP >".number_format($all_emp_num,0)."&nbsp;&nbsp;</td>   
		 </tr>";
 		return $html;
	}
	
	function table_all3group_w_gender_row1($start_no=1,$value='',$officer_num_m=0,$officer_num_w=0 ){
	   $all_emp_num = $officer_num_m+$officer_num_w;
	   $html = 	"<tr  style='height:0.7cm; padding-left:3px;'> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP  >".$value."</td> 
			 <td CENTER_TOP >".number_format($officer_num_m,0)."&nbsp;&nbsp;</td> 
			 <td CENTER_TOP >".number_format($officer_num_w,0)."&nbsp;&nbsp;</td> 
  	
			 <td CENTER_TOP >".number_format($all_emp_num,0)."&nbsp;&nbsp;</td>   
		 </tr>";
 		return $html;
	}

	function table_all3group_w_gender_sum($officer_sum_m=0,$officer_sum_w=0,$regular_emp_sum_m=0,$regular_emp_sum_w=0,$temp_emp_sum_m=0,$temp_emp_sum_w=0,$usetd=6){
	    $sum_all = $officer_sum_m+$regular_emp_sum_m+$temp_emp_sum_m+$officer_sum_w+$regular_emp_sum_w+$temp_emp_sum_w;
		$html  = "<tr style='height:0.7cm;'> 
			 <td CENTER_TOP   colspan='2' ><div align='center'><strong>รวม ( อัตรา )</strong></div></td> 
			 <td CENTER_TOP ><div ><strong>".number_format($officer_sum_m,0)."&nbsp;&nbsp;</strong></div></td> 
			 <td CENTER_TOP ><div  ><strong>".number_format($officer_sum_w,0)."&nbsp;&nbsp;</strong></div></td>
			 <td CENTER_TOP ><div  ><strong>".number_format($regular_emp_sum_m,0)."&nbsp;&nbsp;</strong></div></td> 
			 <td CENTER_TOP ><div  ><strong>".number_format($regular_emp_sum_w,0)."&nbsp;&nbsp;</strong></div></td> 
			 <td CENTER_TOP ><div  ><strong>".number_format($temp_emp_sum_m,0)."&nbsp;&nbsp;</strong></div></td> 	
			 <td CENTER_TOP ><div  ><strong>".number_format($temp_emp_sum_w,0)."&nbsp;&nbsp;</strong></div></td> 
			 <td CENTER_TOP ><div ><strong>".number_format($sum_all,0)."&nbsp;&nbsp;</strong></div></td> 		 
		 </tr>";
		 return $html;
		 
	
	} // function 
	
	function table_all3group_w_gender_sum1($officer_sum_m=0,$officer_sum_w=0 ){
	    $sum_all = $officer_sum_m+$officer_sum_w;
		$html  = "<tr style='height:0.7cm;'> 
			 <td CENTER_TOP   colspan='2' ><div align='center'><strong>รวม ( อัตรา )</strong></div></td> 
			 <td CENTER_TOP ><div ><strong>".number_format($officer_sum_m,0)."&nbsp;&nbsp;</strong></div></td> 
			 <td CENTER_TOP ><div  ><strong>".number_format($officer_sum_w,0)."&nbsp;&nbsp;</strong></div></td>
 
			 <td CENTER_TOP ><div ><strong>".number_format($sum_all,0)."&nbsp;&nbsp;</strong></div></td> 		 
		 </tr>";
		 return $html;
		 
	
	} // function 
	
	

	function menu_profilehis_report($postion_type_id = 1,$run_id=0,$report_menu=array(),$paramlink='',$startend=''){
	   $html = '';
	  if($startend ==1){
	    $html .= '<div class="row">';
	  }
	  
	  $html .= '<div class="col-xs-12 col-md-6"><div class="row formSep"><a href = "profile_his_report_'.$postion_type_id.'_'.$report_menu['report_id'].'.php?'.$paramlink.'" class="report_link">'.$run_id.'. '.$report_menu['name'].'</a></div></div>';
	  if($startend == 2){
	    $html .= '</div>';
	  }
	  return $html;
	}

	function menu_profilehis_report2($postion_type_id = 1,$run_id=0,$report_menu=array(),$paramlink='',$startend=''){
	   $html = '';
	  if($startend ==1){
	    $html .= '<div class="row">';
	  }
	  
	  $html .= '<div class="col-xs-12 col-md-6"><div class="row formSep"><a href = "report_salary_'.$postion_type_id.'_'.$report_menu['report_id'].'.php?'.$paramlink.'" class="report_link">'.$run_id.'. '.$report_menu['name'].'</a></div></div>';
	  if($startend == 2){
	    $html .= '</div>';
	  }
	  return $html;
	}
	
 
function getMimeType($filename)
{
    $mimetype = false;
    if(function_exists('finfo_fopen')) {
        // open with FileInfo
    } elseif(function_exists('getimagesize')) {
        // open with GD
    } elseif(function_exists('exif_imagetype')) {
       // open with EXIF
    } elseif(function_exists('mime_content_type')) {
       $mimetype = mime_content_type($filename);
    }
    return $mimetype;
}



	function menu_salary_report($run_id=0,$id=0,$paramlink='',$name=''){
	  $html = '<div class="row formSep"><a href = "report_salary_1_'.$id.'.php?'.$paramlink.'" class="report_link">'.$run_id.'. '.$name.'</a></div>';
	  return $html;
	}
 
	function made_panel_heading($title = ''){
	
	  $html = '<div class="panel-heading" align="center" style="background-image:linear-gradient(to bottom, #428bca 0%, #357ebd 100%)">
					<h3 class="panel-title"><span style="position:relative; top:-10px; z-index:5; color:#FFF;">'.$title.'</span></h3>
				</div>        
<div align="center" style="position:relative; top:-47px;"><img src="'.$GLOBALS['path_is'].'images/brand_01.gif"></div>';
      return $html;
	}

	function get_name_salup($name=''){
	   $name = str_replace("&", "",$name);
	   $name = str_replace("amp;", "",$name);
	   $name = str_replace("nbsp;", " ",$name);
	   return $name;
	}
	
	function active_title($title=''){
	  $html = '<li class="active">'.$title.'</li>';
	  echo $html;
	}
 
   
	function made_rowhead_form($title = '',$id=0){
	  $html = ' <div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$id.'" onClick="$(\'.switchPic'.$id.'\').toggle();">'.switchPic($GLOBALS['path_is'],"switchPic".$id, "0").' '.$title.'</a>
				</div>  ';
	  return $html;
	}
	
	
	function attached_sql($where = ""){
	   $sql = " SELECT A.PERCENT_SPE,A.NAME,A.SALARY_NOW,A.SALARY_NEW, A.SALARY_SPE_NOW,A.SALARY_SPE_NEW,A.SAL_COMPENSATION_4,A.SALARY_UP,A.SCORE_PERCENT, A.LEVEL_SALARY_MID ,A.REMARKS, A.PER_ID,A.LEVEL_SALARY_MAX,  
A.SAL_COM_ID, A.SAL_COM_SPE, A.SAL_COM_TEMP,
 A.POS_NO, A.SALARY_SPE_UP,A.SAL_UP_ID, TYPE_NAME_TH,LEVEL_NAME_TH,
LINE_NAME_TH , A.UPDATE_DATE, A.CREATE_DATE,
A.ORG_ID_4, A.SCORE  
,B.PER_IDCARD
,F.ORG_SHORTNAME_TH ,F.ORG_NAME_TH AS ORG_NAME_3
,H.ORG_NAME_TH AS ORG_NAME_4
,G.MANAGE_NAME_TH
,J.LEVEL_NAME
FROM SAL_UP_SALARY A 
INNER JOIN PER_PROFILE B ON A.PER_ID = B.PER_ID 
LEFT JOIN SETUP_POS_TYPE C ON A.TYPE_ID = C.TYPE_ID 
LEFT JOIN SETUP_POS_LINE D ON A.LINE_ID = D.LINE_ID 
LEFT JOIN SETUP_POS_LEVEL E ON A.LEVEL_ID = E.LEVEL_ID 
LEFT JOIN SETUP_ORG F ON A.ORG_ID_3 = F.ORG_ID 
LEFT JOIN SETUP_ORG H ON A.ORG_ID_4 = H.ORG_ID 
LEFT JOIN SETUP_POS_MANAGE G ON A.MANAGE_ID = G.MANAGE_ID 
LEFT JOIN SAL_SCORE I ON A.SCORE_ID = I.SCORE_ID 
LEFT JOIN SAL_LEVEL_SCORE J ON I.LV_SCORE_ID = J.LV_SCORE_ID  
LEFT JOIN SAL_COMMAND K ON A.SAL_COM_ID = K.SAL_COM_ID 
LEFT JOIN SAL_COMMAND M ON A.SAL_COM_SPE = M.SAL_COM_ID  
LEFT JOIN SAL_COMMAND N ON A.SAL_COM_TEMP = N.SAL_COM_ID 
".$where."  ORDER BY F.ORG_NAME_TH ASC ";
     return $sql;
 
	}
	
  function get_ORG_sql($where = ""){
   $sql = "  select ORG_ID, ORG_NAME_TH  from SETUP_ORG   WHERE OL_ID IN ( 6,16 )  AND ((ORG_PARENT_ID = 15) OR (ORG_ID = 15)) ".$where."  ORDER BY ORG_SEQ ASC";
   return $sql;
  }
  
  function ORG_basic_where(){
    $sql = " OL_ID IN ( 6,16 ) AND ((ORG_PARENT_ID = 15) OR (ORG_ID = 15)) ";
	return $sql;
  }

function btn_do_center($ajax='',$position = 'c'){
			$html  = '';
			if($position=='c'){
				$html  .= '  <div class="row" style="margin:0 auto; width:10%;"> <center>';
			}
			$html .= '<button type="button" class="btn btn-primary" onClick="'.$ajax.'">ค้นหา</button> ';
			if($position=='c'){
				$html .= '</center></div> ';
			}
			return $html;
	}
	
function label_data_on_row($label=array(),$data=array()){
   
   $data_count = count($label);
   $od_chk = 0;
   $html = "";
   for($i=0;$i<$data_count;$i++){
       if( $od_chk == 0){
			$html .= "<div class='row formSep'>";
	   } 
	   $html .= "<div class='col-xs-12 col-sm-2' style=' font-weight:bold;' >".$label[$i];
	   if($label[$i]!=""){ 
	   $html .= "  :";
	   }
	   $html .= "</div>";
	   $html .= "<div class='col-xs-12 col-sm-3'>".$data[$i]."</div>";
       if( $od_chk == 1){
   			$html .= "</div>  ";
	   } 
	   $od_chk++;
	   if($od_chk ==2){
	      $od_chk =0;
	   }
	}
 
   echo $html;
}

function restr_html($html){

	$html =  str_replace("CENTER_TOP",$GLOBALS['CENTER_TOP_HTML'],$html);
	$html =  str_replace("LEFT_TOP",$GLOBALS['LEFT_TOP_HTML'],$html);		
	$html =  str_replace("RIGHT_TOP",$GLOBALS['RIGHT_TOP_HTML'],$html);		
	$html =  str_replace("XRXX","",$html);
	
	return $html;
} 

 function th_show($title="",$style=""){
   $html = "<th style='height:1cm; border:solid 1px #000000;".$style."  ' ><div align='center'><strong>".$title."</strong></div></th>";
   echo $html;
 }

 function tr_show_no_found($title='',$colspan=1){
	echo "<tr style='background-color:#DAEDF4;'><td align=\"center\" colspan=\"".$colspan."\">".$title."</td></tr>";
 }
 function pdf_show_no_found($title='',$colspan=1){
       return "<tr><td align=\"center\" colspan=\"".$colspan."\" style='border:solid 1px #000000;' >".$title."</td></tr>";
}

function list_scriptinclude($menu_name=0){
   $html  = '';   
   $html .= '<link href="'.$GLOBALS['path_is'].'images/splashy/splashy.css" rel="stylesheet">'; 
   $html .= '<link href="'.$GLOBALS['path_is'].'css/main.css" rel="stylesheet">';
   $html .= '<link href="'.$GLOBALS['path_is'].'bootstrap/css/bootstrap.css" rel="stylesheet">';  
   $html .= '<link href="'.$GLOBALS['path_is'].'bootstrap/css/bootstrap-theme.css" rel="stylesheet">';
   $html .= '<link href="'.$GLOBALS['path_is'].'bootstrap/css/bootstrap-modal.css" rel="stylesheet">';
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/jquery.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/transition.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/holder.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/collapse.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/dropdown.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/modal.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/carousel.js"></script>';   
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/respond.min.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'bootstrap/js/html5shiv.js"></script>'; 
   $html .= '<script src="'.$GLOBALS['path_is'].'js/func.js"></script>'; 
   echo $html;
}

function display_download_me($path_img='',$PER_FILE='',$download_txt=''){

	if (!file_exists($path_img.$PER_FILE)) {   
		echo "ไม่มี";                     
	}else{
		 echo displayDownloadFileAttach($path_img,$PER_FILE,$download_txt);
	}
}
	
function update_date_name($UPDATE_DATE =''){
		$UPDATE_DATE = str_replace(" ","_",$UPDATE_DATE);
		$UPDATE_DATE = str_replace("__","_",$UPDATE_DATE);
		$UPDATE_DATE = str_replace(":","_",$UPDATE_DATE);
		return $UPDATE_DATE;
}
				/*<div class="row head-form">				
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onClick="$('.switchPic1').toggle();"><?php echo switchPic($path,"switchPic1", "0");?> รายงานทะเบียนประวัติ</a>
				</div>*/
	
	
	
?>