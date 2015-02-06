<?php header ('Content-type: text/html; charset=utf-8');
$menu_name = 211;
$menu_num = "8. ";
$sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 
$NAME = $_POST['s_name'];
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
}
$s_ORG_ID = (int)$_POST['ORG_ID_3'];

$title_1 = $year_fillter_is;


if($_POST['REPORT_TYPE']=="print_me"){
 include_once("report_salary_1_211_pdf.php"); 
}

if($_POST['REPORT_TYPE']=="print_all"){
 include_once("report_salary_1_211_pdf_all.php"); 
}

// filter area

include_once("inc_report_top.php");


  $arr_org3=GetSqlSelectArray("a.ORG_ID", "a.ORG_NAME_TH", "SETUP_ORG as a", "a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='15' ", "case when ORG_SEQ IS NULL then 1 else 0 end, ORG_SEQ");

?>
<script>
function year_select_please(){
       var year_val = $("#AGE_IS option").filter(":selected").val();
       var round_val = $("#ROUND option").filter(":selected").val();
	   if(round_val==""){
		   alert('กรุณา<?php echo $arr_txt['spec_me']; ?>รอบก่อนค่ะ');
		   
		   return false;
		   exit();
	   }
   searchData();
}

function print_pdf211(id){
	   if(id > 0){ 
	   		$('#frm-export'+id).submit();
	   }else{
	   		$('#frm-exportall').submit();
	   }
}

</script>


	<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ปีงบประมาณ : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-2">
                <select name="AGE_IS" id="AGE_IS" class="selectbox form-control" placeholder="ปีงบประมาณ">
						<?php 
                        for($y=$YEAR_BUDGET;$y>=$YEAR_BUDGET_PREV;$y--){
                            ?>
                            <option value="<?php echo $y;?>" <?php if($y == $AGE_IS){ echo "selected";} ?>><?php echo $y;?></option>
                            <?php	
                        }
                        ?>
                   </select>			
			</div>
			
			<div class="col-xs-12 col-sm-2 col-sm-offset-2" style="white-space:nowrap;">รอบ : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-2">
				<select name="ROUND" id="ROUND" class="selectbox form-control" placeholder="เลือกรอบ">
                    <option value=""></option>
		 
                       <option value="1" <?php if(1 == $ROUND){ echo "selected"; }?>> รอบที่ 1 (1 ตุลาคม - 31 มีนาคม) </option>
                       <option value="2" <?php if(2 == $ROUND){ echo "selected"; }?>> รอบที่ 2 (1 เมษายน - 30 กันยายน) </option>       
                </select>
			</div>
 
 
		</div>
        
	<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อ - สกุล :  </div>
			<div class="col-xs-12 col-sm-2">
						<input type="text" name="s_name" id="s_name" value="<?=$NAME;?>"   class="form-control" placeholder="ชื่อ - สกุล"  >		
			</div>
			
			<div class="col-xs-12 col-sm-2 col-sm-offset-2" style="white-space:nowrap;">สังกัด ( ปฎิบัติ ) :  </div>
			<div class="col-xs-12 col-sm-2">
	 <?php echo GetHtmlSelect('ORG_ID_3','ORG_ID_3',$arr_org3,'ระดับกอง/สำนัก/กลุ่ม',$ORG_ID_3,'onchange="getORG(this);"','','1');?>
			</div>
 
 
		</div>
        
        
        
         <center> <button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);return year_select_please();">ค้นหา</button> </center>
        
</form>
<?php
$arr_org = array();
$where_is = " WHERE A.YEAR_BDG = '".$AGE_IS."' AND A.ROUND = '".$ROUND."'   AND A.POSTYPE_ID =1 "; // ออกเฉพาะข้าราชการเท่านั้นแหละ
if($NAME !=""){ 
 	$where_is .=  " AND A.NAME    like '%".ctext($NAME)."%' ";
}
if($s_ORG_ID !=""){
 	$where_is .=  " AND A.ORG_ID_3  = '".$s_ORG_ID."' ";
}  


//CONFIRM_TYPE

$sql =  attached_sql($where_is);
 
$query = $db->query($sql);
$nums = $db->db_num_rows($query);  
 
					if($nums > 0){
						$i = 1;
						$ORG_NAME_OLD = "";
						$SAL_UP_ID_all = "";
						while($rec = $db->db_fetch_array($query)){
							$final = 0;
							$org4 = (int)$rec['ORG_ID_4'];
							$UPDATE_DATE = $rec['UPDATE_DATE'];
							if($UPDATE_DATE==""){
								$UPDATE_DATE = $rec['CREATE_DATE'];
							}
							$PER_IDCARD = (int)$rec['PER_IDCARD'];
							$SCORE = $rec['SCORE'];
							
							$SAL_COM_ID = (int)$rec['SAL_COM_ID']; // คำสั่งมีหรือเปล่า
							$SAL_COM_SPE = (int)$rec['SAL_COM_SPE'];
													
							$SCORE_PERCENT = $rec['SCORE_PERCENT']." % ";
							$LEVEL_SCORE_NAME = text($rec['LEVEL_NAME']);
							$REMARKS = text($rec['REMARKS']);  
							$SALARY_UP = $rec['SALARY_UP'];
							$SALARY_SPE_NOW = $rec['SALARY_SPE_NOW'];
							$SALARY_SPE_NEW = $rec['SALARY_SPE_NEW'];
							$SALARY_NOW = $rec['SALARY_NOW'];
							$SAL_UP_ID = (int)$rec['SAL_UP_ID'];
							$SALARY_NEW = $rec['SALARY_NEW'];
							$SALARY_SPE_UP = $rec['SALARY_SPE_UP'];
							$SAL_COMPENSATION_4 = $rec['SAL_COMPENSATION_4'];
							$ORG_SHORTNAME_TH = $rec['ORG_SHORTNAME_TH'];
							$LEVEL_SALARY_MID = $rec['LEVEL_SALARY_MID']; //ฐานในการคำนวณ
							$PER_NAME =   get_name_salup(text($rec['NAME']));
							$POSITION_NO = (trim($rec['POS_NO'])!='') ? toThaiNumber($rec['POS_NO']) : '-';
							$TYPE_NAME_TH = text($rec['TYPE_NAME_TH']);
							$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-';
							$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-';
							$ORG_NAME = (trim($rec['ORG_NAME_3']) != '') ? text($rec['ORG_NAME_3']) : '-';
							$POSITION_NAME = '<strong>เลขที่ตำแหน่ง</strong> : '.$POSITION_NO.'<br><strong>ตำแหน่งในสายงาน</strong> : '.$LINE_NAME.'<br><strong>ระดับตำแหน่ง</strong> : '.$LEVEL_NAME.'<br><strong>กลุ่มงาน</strong> : '.$ORG_NAME;

						    $PERCENT = @($SALARY_UP/$SALARY_NOW)*100;
							$ORG_NAME_IS = text($ORG_SHORTNAME_TH);
							
 
 
							$sql_org4 = "SELECT ORG_NAME_TH FROM SETUP_ORG WHERE  ORG_ID = '".$org4."' ";
							$query_org4 = $db->query($sql_org4);
							$rec_org4 = $db->db_fetch_array($query_org4);
							
							$sql_IDCARD = "SELECT PER_IDCARD FROM PER_PROFILE WHERE  PER_ID = '".$rec['PER_ID']."' ";
							$query_IDCARD = $db->query($sql_IDCARD);
							$IDCARD = $db->db_fetch_array($query_IDCARD);
							
							$all_sallary = $SAL_COMPENSATION_4+$SALARY_SPE_NEW;
							
							
  							$UPDATE_DATE = update_date_name($UPDATE_DATE);	  
							$file_name = $path . "cache-report/211-report/".$SAL_UP_ID."_".$UPDATE_DATE.".txt";
         
							if (!file_exists($file_name)) {   // new file , so made it.  
 								include("report_salary_1_211_madetxtfile.php");
								 
							}else{ // old file 
							}
							$SAL_UP_ID_all .= $file_name.",";
							
						  $html .= "<tr style='background-color:#fff;'  > 
							<td CENTER_TOP >".toThaiNumber(number_format($i,0))."</td>

							<td CENTER_TOP >".toThaiNumber(get_idCard($IDCARD['PER_IDCARD']))."</td>
							<td CENTER_TOP >".$POSITION_NO."</td>
							<td LEFT_TOP >".$PER_NAME."</td>

							<td LEFT_TOP >".$LINE_NAME."</td>
					 
							<td LEFT_TOP >".$LEVEL_NAME."</td>

  
							<td RIGHT_TOP > ".$ORG_NAME_IS."</td>
							<td CENTER_TOP > 
							<form id='frm-export".$SAL_UP_ID."' method='post' action='".$_SERVER['PHP_SELF']."?v=23423' target=_blank>
							 <button type='button' ta-toggle='modal' class='btn btn-default btn-xs' data-backdrop='static'  onclick='print_pdf211(".$SAL_UP_ID.");return false;' >
							 <input type='hidden' name='SAL_UP_ID_is' id='SAL_UP_ID_is' value='".$SAL_UP_ID."' >
							 <input type='hidden' name='REPORT_TYPE' id='REPORT_TYPE' value='print_me' >
							 <input type='hidden' name='AGE_IS' id='AGE_IS' value='".$AGE_IS."' >
							 <input type='hidden' name='ROUND' id='ROUND' value='".$ROUND."' >
							 <input type='hidden' name='PER_NAME' id='PER_NAME' value='".$PER_NAME."' >
							 <input type='hidden' name='POSITION_NO' id='POSITION_NO' value='".$POSITION_NO."' >
							 <input type='hidden' name='LINE_NAME' id='LINE_NAME' value='".$LINE_NAME."' >
							 <input type='hidden' name='LEVEL_NAME' id='LEVEL_NAME' value='".$LEVEL_NAME."' >
							 <input type='hidden' name='SALARY_NOW_is' id='SALARY_NOW_is' value='".$SALARY_NOW."' >
							 <input type='hidden' name='SALARY_UP_is' id='SALARY_UP_is' value='".$SALARY_UP."' >
							 <input type='hidden' name='SALARY_NEW_is' id='SALARY_NEW_is' value='".$SALARY_NEW."' >
							 <input type='hidden' name='SCORE_PERCENT_is' id='SCORE_PERCENT_is' value='".$rec['SCORE_PERCENT']."' >
							 <input type='hidden' name='SALARY_SPE_UP_is' id='SALARY_SPE_UP_is' value='".$SALARY_SPE_UP."' >
							 <input type='hidden' name='LEVEL_SALARY_MID_is' id='LEVEL_SALARY_MID_is' value='".$LEVEL_SALARY_MID."' >						 
							 <input type='hidden' name='ORG_NAME_IS' id='ORG_NAME_IS' value='".$ORG_NAME_IS."' >
							 <input type='hidden' name='REMARK_IS' id='REMARK_IS' value='".$REMARK."' >
							 <input type='hidden' name='UPDATE_DATE' id='UPDATE_DATE' value='".$UPDATE_DATE."' >
							 <span class='glyphicon glyphicon-pencil'></span> ออกหนังสือ</button>    
							</form> 
							";  
						  	$i++; 

						   $html .= " </td> 
						  </tr> ";
						     
						}
	 				  }
	        $SAL_UP_ID_all = trim($SAL_UP_ID_all, ","); 
			
			$all_btn = "";
			if($nums > 1){ 
	        $all_btn = " <form id='frm-exportall' method='post' action='".$_SERVER['PHP_SELF']."?v=23423' target=_blank>
							 <button type='button'  class='btn btn-primary dropdown-toggle'  onclick='print_pdf211(0);return false;' >
							 <input type='hidden' name='REPORT_TYPE' id='REPORT_TYPE' value='print_all' >
							 <input type='hidden' name='SAL_UP_ID_all' id='SAL_UP_ID_all' value='".$SAL_UP_ID_all."' >
							 <span class='glyphicon glyphicon-pencil'></span> ออกหนังสือทั้งหมด</button>    
							</form> ";
			}
 
	 
include_once("inc_report_bottom.php"); 
// End report 1
?>