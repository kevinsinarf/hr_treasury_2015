<?php 
$menu_name = 203;
$menu_num = "7. ";
$sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 

$S_ORG_ID_3 = (int)$_POST['ORG_ID_3']; // เพิ่มสำนัก 

/*
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
   if($AGE_IS > 2500){
      $AGE_IS = $AGE_IS-543;
   }
}*/
$S_ROUND = (int)$_POST['S_ROUND'];
$SAL_UP_TYPE = (int)$_POST['SAL_UP_TYPE'];

$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");
$arr_setup_org3=GetSqlSelectArray("ORG_ID", "ORG_NAME_TH", "SETUP_ORG", "ACTIVE_STATUS='1' and DELETE_FLAG='0' AND ORG_PARENT_ID = 15", "ORG_SEQ");//ORG
?>
<script>
function year_select_please(){
       var year_val = $("#AGE_IS option").filter(":selected").val();
       var S_ROUND_val = $("#S_ROUND option").filter(":selected").val();
	   if(year_val==""){
		   alert('กรุณา<?php echo $arr_txt['spec_me'].$arr_txt['year_bdg']; ?>ค่ะ');
		   
		   return false;
		   exit();
	   }else if(S_ROUND_val==""){
		   alert('กรุณาระบุรอบค่ะ');
		   
		   return false;
		   exit();
	   }
   searchData();
}
</script>
<style type="text/css">
  div.small-box {
  width:1280px;
  height:auto;
  overflow-x:scroll;
  
  }
</style>


		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $arr_txt['spec_me'].$arr_txt['year_bdg']; ?> : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-3">
                <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="<?php echo $arr_txt['year_bdg']; ?> "     >   
                  <option value=""></option>
                  <?php for($i=2557;$i>2540;$i--){?>
                    <option value="<?php echo $i;?>" <?php echo ($AGE_IS == $i?"selected":"");?>    >
                    <?php echo $i;?></option>
                  <?php }?>
                </select>				
                </div>
				<div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2">รอบ :  <span style="color:red;">*</span></div>
				 <div class="col-xs-12 col-sm-3">
 
			 
                
				<select name="S_ROUND" id="S_ROUND" class="selectbox form-control" placeholder="รอบ" style="width:200px;">
                    <option value=""></option>
		 
                       <option value="1" <?php if(1 == $S_ROUND){ echo "selected"; }?>> รอบที่ 1 (1 ตุลาคม - 31 มีนาคม) </option>
                       <option value="2" <?php if(2 == $S_ROUND){ echo "selected"; }?>> รอบที่ 2 (1 เมษายน - 30 กันยายน) </option>       
                </select>
                
                </div>
				<div class="col-xs-12 col-md-1"></div>
			</div>
            
            
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเภทการบริหาร : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-3">
                    <select id="SAL_UP_TYPE" name="SAL_UP_TYPE" class="selectbox form-control" placeholder=""     >   
                        <option value="1"   <?php if(1 == $SAL_UP_TYPE){ echo "selected"; }?>  >บริหารต้น </option>
                        <option value="2"   <?php if(2 == $SAL_UP_TYPE){ echo "selected"; }?>  >อำนวยการสูง วิชาการ เชี่ยวชาญ ทรงคุณวุฒิ</option>         
                    </select>				
                </div>
				<div class="col-xs-12 col-md-1"></div>
                <div class="col-xs-12 col-md-2"> สังกัดปฎิบัติ :  </div>
				 <div class="col-xs-12 col-sm-3">
 
	                        <?php echo GetHtmlSelect('S_ORG_ID_3', 'S_ORG_ID_3',$arr_setup_org3 , 'สังกัดปฎิบัติ' ,$S_ORG_ID_3,' style="width:200px;" ' , '1', '', ''); ?>	
                
	 
                </div>
				<div class="col-xs-12 col-md-1"></div>
			</div>
            
            
            
            
            
       <br/>   
            
             <div align="center" ><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);return year_select_please();">ค้นหา</button> </div>
 
	<br/> 
<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ชื่อรายงาน : <span style="color:red;">*</span></div>
			<div class="col-xs-12 col-sm-2">
 		        <input type="text" name="insert_report_name" id="insert_report_name" value="<?php echo $headline_title; ?>" style="width:950px;"  class="form-control" placeholder="ชื่อรายงาน"  >
			</div>
			
			<div class="col-xs-12 col-sm-2 col-sm-offset-2" style="white-space:nowrap;"></div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
			<div class="col-xs-12 col-sm-2">
	  	 
			</div>
 
		</div>
        
        
<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">เลขที่คำสั่ง :  </div>
			<div class="col-xs-12 col-sm-2">
 		        <input type="text" name="insert_report_name2" id="insert_report_name2"  value="" style="width:190px;" class="form-control" placeholder="เลขที่คำสั่ง" >
			</div>
			
			<div class="col-xs-12 col-sm-2 col-sm-offset-2" style="white-space:nowrap;">ลงวันที่ :</div>
			<div class="col-xs-12 col-sm-2">
 		        <input type="text"  name="insert_report_name3" id="insert_report_name3"  value="" style="width:297px;"  class="form-control" placeholder="ลงวันที่"  >
			</div>
			<div class="col-xs-12 col-sm-2">
	  	 
			</div>
 
		</div>
            
            
<?php
   $arr_org = array();

    $OLD_SALARY_SUM = 0;
	$SALARY_UP_SUM = 0;
if($AGE_IS > 0){
        $sql = " select a.PER_ID,a.TYPE_ID,a.LEVEL_ID,a.LINE_ID,a.MANAGE_ID,a.ORG_ID_1,a.ORG_ID_2,a.ORG_ID_3,a.ORG_ID_4   
				 ,d.LINE_NAME_TH,c.LEVEL_NAME_TH ,e.ORG_NAME_TH,b.TYPE_NAME_TH ,a.POS_ID,a.SCORE,a.SALARY_NOW,a.SCORE_PERCENT,a.LEVEL_SALARY_MID,a.REMARKS,a.SALARY_NEW,
				 f.ORG_SHORTNAME_TH,a.SCORE_ID,h.LEVEL_NAME,a.SALARY_UP,a.name
		from SAL_UP_SALARY  a
				LEFT JOIN SETUP_POS_TYPE b ON a.TYPE_ID = b.TYPE_ID   
				LEFT JOIN SETUP_POS_LEVEL c ON a.LEVEL_ID = c.LEVEL_ID  
				LEFT JOIN SETUP_POS_LINE d ON a.LINE_ID = d.LINE_ID  
				LEFT JOIN SETUP_ORG e ON a.ORG_ID_4 = e.ORG_ID    
				LEFT JOIN SETUP_ORG f ON a.ORG_ID_3 = f.ORG_ID 
        LEFT JOIN SAL_SCORE g ON a.SCORE_ID = g.SCORE_ID
        LEFT JOIN SAL_LEVEL_SCORE h ON g.LV_SCORE_ID = h.LV_SCORE_ID  
		where   PER_ID > 0  and  a.YEAR_BDG = '".$AGE_IS."' AND a.ROUND  = '".$S_ROUND."' AND a.CONFIRM_TYPE = 3 AND A.POSTYPE_ID = 1  ";  
		if($S_ORG_ID_3 > 0){    
		   $sql .= " AND A.ORG_ID_3 =   '".$S_ORG_ID_3."' ";
		}  
		if($SAL_UP_TYPE > 0){
		   $sql .= " AND SAL_UP_TYPE = '".$SAL_UP_TYPE."' ";
		}  
		//echo $sql; exit(); 
		$query = $db->query($sql); 
		$num_rows = $db->db_num_rows($query);
	    while($rec = $db->db_fetch_array($query)){
 
	    $per_id = (int)$rec['PER_ID']; 
		$SCORE_ID = (int)$rec['SCORE_ID'];
		
		$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-'; //
		$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-'; //
		$ORG_NAME = (trim($rec['ORG_NAME_TH']) != '') ? text($rec['ORG_NAME_TH']) : '-'; //
		$TYPE_NAME = (trim($rec['TYPE_NAME_TH']) != '') ? text($rec['TYPE_NAME_TH']) : '-'; //
		$SCORE = $rec['SCORE'];
		$SCORE_PERCENT = $rec['SCORE_PERCENT'];
		$LEVEL_SALARY_MID = $rec['LEVEL_SALARY_MID'];
	    $POSITION_NO = (int)$rec['LINE_ID'];
		$OLD_SALARY = $rec['SALARY_NOW'];
		$NEW_SALARY = $rec['SALARY_NEW'];
		$SALARY_UP = $rec['SALARY_UP'];
		$REMARKS = text($rec['REMARKS']);
		$club = text($rec['ORG_SHORTNAME_TH']);
		$LEVEL_SCORE_NAME = text($rec['LEVEL_NAME']);
		$PER_NAME = text($rec['name']);
		$PER_NAME = str_replace("&","",$PER_NAME);
		$PER_NAME = str_replace("amp;","",$PER_NAME);
		$PER_NAME = str_replace("nbsp;"," ",$PER_NAME);
	  
	 
        $sql_man = " select  PER_ID, PREFIX_ID, PER_IDCARD , POS_ID  
from PER_PROFILE    
where PER_PROFILE.DELETE_FLAG = '0' AND PER_PROFILE.ACTIVE_STATUS = '1' 
AND PT_ID = '1'   AND POSTYPE_ID = 1  
AND PER_ID = '".$per_id."'
  ";    //echo $sql; exit();
		$query_man = $db->query($sql_man); 
		$num_rows_man = $db->db_num_rows($query_man);
	    $rec_man = $db->db_fetch_array($query_man);

		$id_card = $rec_man['PER_IDCARD'];
        // get leave data for each person. 
        $sql_get_leave = " select * from PER_LEAVEHIS where PER_ID = '".$per_id."' AND LEAVEHIS_YEAR = '".$AGE_IS."' AND ROUND_YEAR = '".$S_ROUND."' ";  
		$query_leave = $db->query($sql_get_leave); 
	    $rec_leave = $db->db_fetch_array($query_leave);
		
        $private_relax = ($rec_leave["LEAVEHIS_PRIVATE_DAY"]+ $rec_leave["LEAVEHIS_RELAX_DAY"]);
		$LEAVEHIS_IMPORTANT_SICK_DAY = (int)$rec_leave["LEAVEHIS_IMPORTANT_SICK_DAY"];
		$html  .= "<tr   ".$tr_detail_style."> 
			 <td CENTER_TOP  >".toThaiNumber($start_no)."</td> 
			 <td LEFT_TOP   >&nbsp;".toThaiNumber($id_card)."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$PER_NAME."&nbsp; </td>  
			 <td LEFT_TOP   >&nbsp;".$LINE_NAME."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$TYPE_NAME."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$LEVEL_NAME."&nbsp; </td> 
			 <td CENTER_TOP   >&nbsp;".toThaiNumber($POSITION_NO)."&nbsp; </td>"; 
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($rec_leave["LEAVEHIS_SICK_DAY"],0))."&nbsp;</td>"; //ป่วย
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($private_relax,0))."&nbsp;</td>"; //กิจ
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($LEAVEHIS_IMPORTANT_SICK_DAY,0))."&nbsp;</td>"; // ป่วยจำเป็น
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($rec_leave["LEAVEHIS_LATE_DAY"],0))."&nbsp;</td>"; // มาสาย
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($rec_leave["LEAVEHIS_BIRTH_DAY"],0))."&nbsp;</td>"; // คลอดบุตร
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($rec_leave["LEAVEHIS_REGION_DAY"],0))."&nbsp;</td>"; // อุปสมบท 
		$html  .= "<td CENTER_TOP >".toThaiNumber(number_format($rec_leave["LEAVEHIS_STUDY_DAY"],0))."&nbsp;</td>"; // ศึกษา / อบรม
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($OLD_SALARY,2))."&nbsp;</td>";   // เงินเดือนเดิม 
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($LEVEL_SALARY_MID,2))."&nbsp;</td> "; // ฐานในการคำนวณ
		$html  .= "<td LEFT_TOP   >&nbsp;".toThaiNumber($LEVEL_SCORE_NAME)."&nbsp; </td>";
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($SCORE,2))."&nbsp;</td>"; 
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($SCORE_PERCENT,2))."&nbsp;</td>"; 
		$html  .= "<td RIGHT_TOP >".toThaiNumber(number_format($SALARY_UP,2))."&nbsp;</td> 
			 <td RIGHT_TOP >".toThaiNumber(number_format($NEW_SALARY,2))."&nbsp;</td>  
			 <td LEFT_TOP   >&nbsp;".$REMARKS."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$club."&nbsp; </td> 
		 </tr>";
		 $start_no++;
		 $OLD_SALARY_SUM = $OLD_SALARY_SUM + $OLD_SALARY;
		 $SALARY_UP_SUM = $SALARY_UP_SUM + $SALARY_UP;
		}//while 
		 $salary25_is = $OLD_SALARY_SUM * 0.025;
		 $salary_r = $salary25_is - $SALARY_UP_SUM;
		$html  .= " 
					<tr   ".$tr_detail_style."> 
			 <td RIGHT_TOP colspan=14  >&nbsp;ยอดเงินเดือนข้าราชการทั้งหมด &nbsp; </td> 
			 <td RIGHT_TOP   >".toThaiNumber(number_format($OLD_SALARY_SUM,2))."&nbsp;</td> 
			 <td LEFT_TOP colspan=4  >&nbsp;เงินที่ใช้เลื่อนทั้งหมด &nbsp; </td> 
			 <td RIGHT_TOP   >".toThaiNumber(number_format($SALARY_UP_SUM,2))."&nbsp;</td> 
			 <td LEFT_TOP colspan=4  >&nbsp; &nbsp; </td> 
		 </tr> 
		 
<tr   ".$tr_detail_style."> 
			 <td RIGHT_TOP colspan=14  >&nbsp; ยอดเงิน ๒.๕% ของเงินเดือนทั้งหมด&nbsp; </td> 
			 <td RIGHT_TOP   >".toThaiNumber(number_format($salary25_is,2))."&nbsp;</td> 
			 <td LEFT_TOP colspan=4  >&nbsp; เงินคงเหลือ&nbsp; </td> 
			 <td RIGHT_TOP   >".toThaiNumber(number_format($salary_r,2))."&nbsp;</td> 
			 <td LEFT_TOP colspan=4  >&nbsp; &nbsp; </td> 
		 </tr>
		 
		 
		";
	 
} // if $AGE_IS  > 0
include_once("inc_report_bottom.php"); 
// End report 1
?>