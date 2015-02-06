<?php 
$menu_name = 203;
 

$sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
   if($AGE_IS > 2500){
      $AGE_IS = $AGE_IS-543;
   }
}
$S_ROUND = (int)$_POST['S_ROUND'];

$title_1 = $year_fillter_is;
// filter area

include_once("inc_report_top.php");
?>
<script>
function chk_me(){
       var year_val = $("#AGE_IS option").filter(":selected").val();
	   if(year_val==""){
		   alert('กรุณา<?php echo $arr_txt['spec_me'].$arr_txt['year_bdg']; ?>ค่ะ');
		   
		   return false;
		   exit();
	   }

   searchData();
}
</script>
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
				<div class="col-xs-12 col-md-1">
                <select name="S_ROUND" id="S_ROUND" class="selectbox form-control" placeholder="เลือกรอบ">
                    <option value=""></option>
					<?php 
                    for($r=1;$r<=2;$r++){
                        ?>
                        <option value="<?php echo $r;?>" <?php if($r == $S_ROUND){ echo "selected"; }?>><?php echo $r;?></option>
                        <?php
                    }
                    ?>
                </select>
                </div>
				<div class="col-xs-12 col-md-1"><button type="button" class="btn btn-primary" onClick="searchData();">ค้นหา</button></div>
			</div>
<?php
   $arr_org = array();

 
if($AGE_IS > 0){
        $sql = " select a.PER_ID,a.TYPE_ID,a.LEVEL_ID,a.LINE_ID,a.MANAGE_ID,a.ORG_ID_1,a.ORG_ID_2,a.ORG_ID_3,a.ORG_ID_4   
				 ,d.LINE_NAME_TH,c.LEVEL_NAME_TH ,e.ORG_NAME_TH,b.TYPE_NAME_TH ,a.POS_ID,a.SCORE,a.SALARY_NOW,a.SCORE_PERCENT,a.LEVEL_SALARY_MID,a.REMARKS,a.SALARY_NEW,
				 f.ORG_SHORTNAME_TH,a.SCORE_ID,h.LEVEL_NAME
		from SAL_UP_SALARY  a
				LEFT JOIN SETUP_POS_TYPE b ON a.TYPE_ID = b.TYPE_ID   
				LEFT JOIN SETUP_POS_LEVEL c ON a.LEVEL_ID = c.LEVEL_ID  
				LEFT JOIN SETUP_POS_LINE d ON a.LINE_ID = d.LINE_ID  
				LEFT JOIN SETUP_ORG e ON a.ORG_ID_4 = e.ORG_ID    
				LEFT JOIN SETUP_ORG f ON a.ORG_ID_3 = f.ORG_ID 
        LEFT JOIN SAL_SCORE g ON a.SCORE_ID = g.SCORE_ID
        LEFT JOIN SAL_LEVEL_SCORE h ON g.LV_SCORE_ID = h.LV_SCORE_ID  
		where   PER_ID > 0  and  a.YEAR_BDG = ".$AGE_IS."  AND a.CONFIRM_TYPE = 2 AND a.ROUND  = ".$S_ROUND." ";    
		$query = $db->query($sql); 
		$num_rows = $db->db_num_rows($query);
	    while($rec = $db->db_fetch_array($query)){
 
	    $per_id = (int)$rec['PER_ID']; 
		$SCORE_ID = (int)$rec['SCORE_ID'];
		
		$LINE_NAME = (trim($rec['LINE_NAME_TH']) != '') ? text($rec['LINE_NAME_TH']) : '-'; //
		$LEVEL_NAME = (trim($rec['LEVEL_NAME_TH']) != '') ? text($rec['LEVEL_NAME_TH']) : '-'; //
		$ORG_NAME = (trim($rec['ORG_NAME_TH']) != '') ? text($rec['ORG_NAME_TH']) : '-'; //
		$TYPE_NAME = (trim($rec['TYPE_NAME_TH']) != '') ? text($rec['TYPE_NAME_TH']) : '-'; //
		$SCORE = (int)$rec['SCORE'];
		$SCORE_PERCENT = $rec['SCORE_PERCENT'];
		$LEVEL_SALARY_MID = (int)$rec['LEVEL_SALARY_MID'];
	    $POSITION_NO = (int)$rec['LINE_ID'];
		$OLD_SALARY = (int)$rec['SALARY_NOW'];
		$NEW_SALARY = (int)$rec['SALARY_NEW'];
		$SALARY_UP = $NEW_SALARY - $OLD_SALARY;
		$REMARKS = $rec['REMARKS'];
		$club = text($rec['ORG_SHORTNAME_TH']);
		$LEVEL_SCORE_NAME = $rec['LEVEL_NAME'];
	 
        $sql = " select  PER_ID, PREFIX_ID, PER_IDCARD, PER_FIRSTNAME_TH, PER_MIDNAME_TH, PER_LASTNAME_TH, POS_ID  
from PER_PROFILE    
where PER_PROFILE.DELETE_FLAG = '0' AND PER_PROFILE.ACTIVE_STATUS = '1' 
AND PT_ID = '1'   AND POSTYPE_ID = 1
AND PER_ID = ".$per_id."
  ";    //echo $sql; exit();
		$query = $db->query($sql); 
		$num_rows = $db->db_num_rows($query);
	    $rec = $db->db_fetch_array($query);

		$id_card = $rec['PER_IDCARD'];
		$PER_NAME = Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);

	 /*
        $sql = "  select LEVEL_NAME from SAL_SCORE a 
		          LEFT JOIN SAL_LEVEL_SCORE b ON a.LV_SCORE_ID = b.LV_SCORE_ID
				   where a.SCORE_ID = ".SCORE_ID." ";
    //echo $sql; exit();
		$query = $db->query($sql); 
	    $rec = $db->db_fetch_array($query);
		$LEVEL_SCORE_NAME = $rec['LEVEL_NAME'];
		*/
    
		$html  .= "<tr   ".$tr_detail_style."> 
			 <td CENTER_TOP  >".$start_no."</td> 
			 <td LEFT_TOP   >&nbsp;".$id_card."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$PER_NAME."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$LINE_NAME."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$TYPE_NAME."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$LEVEL_NAME."&nbsp; </td> 
			 <td CENTER_TOP   >&nbsp;".$POSITION_NO."&nbsp; </td> 
			 <td CENTER_TOP >".number_format(0,0)."&nbsp;</td> 
			 <td CENTER_TOP >".number_format(0,0)."&nbsp;</td> 
			 <td CENTER_TOP >".number_format(0,0)."&nbsp;</td> 
			 <td CENTER_TOP >".number_format(0,0)."&nbsp;</td> 
			 <td CENTER_TOP >".number_format(0,0)."&nbsp;</td> 
			 <td CENTER_TOP >".number_format(0,0)."&nbsp;</td> 
			 <td CENTER_TOP >".number_format(0,0)."&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($OLD_SALARY,2)."&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($LEVEL_SALARY_MID,2)."&nbsp;</td> 
			 <td LEFT_TOP   >&nbsp;".$LEVEL_SCORE_NAME."&nbsp; </td> 
			 <td RIGHT_TOP >".number_format($SCORE,2)."&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($SCORE_PERCENT,2)."&nbsp;</td> 
			 <td CENTER_TOP >".number_format($SALARY_UP,2)."&nbsp;</td> 
			 <td RIGHT_TOP >".number_format($NEW_SALARY,2)."&nbsp;</td>  
			 <td LEFT_TOP   >&nbsp;".$REMARKS."&nbsp; </td> 
			 <td LEFT_TOP   >&nbsp;".$club."&nbsp; </td> 
		 </tr>";
		 $start_no++;
		}//while 
		
	 
	 
} // if $AGE_IS  > 0
include_once("inc_report_bottom.php"); 
// End report 1
?>