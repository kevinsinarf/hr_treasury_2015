<?php 
$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 38; 
if($postype_id_is > 0){
	if($postype_id_is==5){
$menu_name = 51; 
	}
} 

 if($menu_name==38){
     //$wh_pt_id = " AND  d.PT_ID = 1  ";
	 $s_title_label02 = "กลุ่มงาน";
	 $s_title_label03 = "ด้านการปฎิบัติงาน";
 }
 if($menu_name==51){
     //$wh_pt_id = " AND  d.PT_ID = 2  ";
	 $s_title_label02 = "ระดับ";
	 $s_title_label03 = "กลุ่มงาน";
 }

$sum_all = 1;
$year_fillter_is = '';
$AGE_IS = (int)$_POST['AGE_IS']; 
if($AGE_IS > 0){
   $year_fillter_is = $AGE_IS;
}
$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");  

  
   $sql_type = "select TYPE_ID, TYPE_NAME_TH ";
   $sql_type .= " from SETUP_POS_TYPE WHERE POSTYPE_ID = ".$postype_id_is." AND ACTIVE_STATUS = 1  "; 
 
    $sql_type .= " ORDER BY TYPE_NAME_TH ASC";
	$query_type = $db->query($sql_type); 

   //echo $sql_type; 
// เลือกเฉพาะที่มีอยู่จริง 
   $sql_line = "select DISTINCT a.LINE_ID,b.LINE_NAME_TH,a.POSTYPE_ID from POSITION_FRAME a 
left join setup_pos_line b on a.line_id = b.line_id
where a.ACTIVE_STATUS = 1 AND a.POSTYPE_ID = ".$postype_id_is."
  "; 
 
    $sql_line .= " ORDER BY b.LINE_NAME_TH ASC";
	$query_line = $db->query($sql_line); 

  

   $sql_level = "select LEVEL_ID, LEVEL_NAME_TH ";
   $sql_level .= " from SETUP_POS_LEVEL  WHERE ACTIVE_STATUS = 1  AND POSTYPE_ID = ".$postype_id_is." "; 
 
    $sql_level .= " ORDER BY LEVEL_NAME_TH ASC";
	$query_level = $db->query($sql_level); 

?>
 

		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ประเภทตำแหน่ง :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="TYPE_ID" name="TYPE_ID" class="selectbox form-control" placeholder="ทั้งหมด "     >   
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_type)){?>
                        <option value="<?php echo $rec1['TYPE_ID']?>"   <?php echo ($rec1['TYPE_ID'] == $TYPE_ID?"selected":"");?>  >
                        <?php echo text($rec1['TYPE_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2">
 <button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(3);searchData();">ค้นหา</button>	
			</div>
        </div>
        


		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $s_title_label02; ?> :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="LINE_ID" name="LINE_ID" class="selectbox form-control" placeholder="ทั้งหมด"     >   
                      <option value=""></option>
                      <?php while($rec1 = $db->db_fetch_array($query_line)){?>
                        <option value="<?php echo $rec1['LINE_ID']?>"   <?php echo ($rec1['LINE_ID'] == $LINE_ID?"selected":"");?>   >
                        <?php echo text($rec1['LINE_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2">
 <button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button>	
			</div>
        </div>
 
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"><?php echo $s_title_label03; ?> :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="LEVEL_ID" name="LEVEL_ID" class="selectbox form-control" placeholder="ทั้งหมด"     >   
                      <option value=""></option>
                      <?php while($rec2 = $db->db_fetch_array($query_level)){?>
                        <option value="<?php echo $rec2['LEVEL_ID']?>"  <?php echo ($rec2['LEVEL_ID'] == $LEVEL_ID?"selected":"");?>  >
                        <?php echo text($rec2['LEVEL_NAME_TH'])?></option>
                      <?php }?>
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"></div>
			<div class="col-xs-12 col-sm-2">
                    <button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(2);searchData();">ค้นหา</button>
			</div>
        </div>
 
<?php  
   $filed_add = "  ,b.PER_FIRSTNAME_TH,b.PER_LASTNAME_TH,b.PER_IDCARD ";
   $q_where = '';	
   if($SEARCH_TYPE==1){ 
   		if($LINE_ID>0){
		   $q_where = ' AND a.LINE_ID = '.$LINE_ID.' ';
		}  
	}// if
	
   if($SEARCH_TYPE==2){ 
 
   		if($LEVEL_ID>0){ 
		   $q_where = ' AND a.LEVEL_ID = '.$LEVEL_ID.' ';
		}
		 
	}// if
	

	 
   if($SEARCH_TYPE==3){ 
   
   		if($TYPE_ID>0){
		 
		   $q_where = ' AND a.TYPE_ID = '.$TYPE_ID.' ';
		}
		 
	}// if
	 
 
		   
		   $sql_list = "SELECT  A.PER_SALARY_POSITION,A.PER_SALARY,A.POS_NO,A.LINE_ID,A.PER_ID, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, A.PER_DATE_BIRTH, A.PER_DATE_ENTRANCE, 
	A.PER_DATE_OCCUPLY, A.PER_DATE_RETIRE,  D.CV_NAME_TH  ,A.PER_FILE_PIC ,E.TYPE_NAME_TH, A.PER_SALARY_POSITION ,A.ORG_ID_3
   ,F.LEVEL_NAME_TH,G.LINE_NAME_TH,A.PER_IDCARD
	FROM PER_PROFILE A
 
	LEFT JOIN ANNOUNCE_SETUP_CIVIL_TYPE D ON A.CV_ID = D.CV_ID
  LEFT JOIN SETUP_POS_TYPE E ON A.TYPE_ID = E.TYPE_ID
  LEFT JOIN SETUP_POS_LEVEL F ON A.LEVEL_ID = F.LEVEL_ID 
  LEFT JOIN SETUP_POS_LINE G ON A.LINE_ID = G.LINE_ID 
	WHERE a.POSTYPE_ID = ".$postype_id_is."   AND A.ACTIVE_STATUS = 1 AND A.DELETE_FLAG = 0  
 
	 ".$q_where; 
	
		   //echo $sql_list; exit();
		   $query_list = $db->query($sql_list); 
		   $get_nums=$db->db_num_rows($query_list);
 			while($rec_list = $db->db_fetch_array($query_list)){
			$PER_NAME = Showname($rec_list["PREFIX_ID"],$rec_list["PER_FIRSTNAME_TH"],$rec_list["PER_MIDNAME_TH"],$rec_list["PER_LASTNAME_TH"]);
	  	    $line_name_th = text(wordwrap($rec_list['TYPE_NAME_TH']))." ".text(wordwrap($rec_list['CV_NAME_TH']))." ".text(wordwrap($rec_list['LEVEL_NAME_TH']))." ".text(wordwrap($rec_list['LINE_NAME_TH']));
			$html  .= "<tr  style='height:0.7cm;'> 
				 <td CENTER_TOP  >".$start_no."</td> 
				 <td LEFT_TOP   >&nbsp;".text($rec_list['PER_IDCARD'])."&nbsp;  </td> 
				 <td LEFT_TOP   >&nbsp;".$PER_NAME."&nbsp; </td>
				 <td LEFT_TOP   >&nbsp;".$line_name_th."&nbsp; </td>";
			$html  .= " </tr>";
			$start_no++;		
			}
		$html  .= "<tr style='height:0.7cm;'> 
			 
			 <td CENTER_TOP   colspan='3' ><div align='center'><strong>รวมจำนวน  </strong></div></td> 
			 <td CENTER_TOP ><strong>".number_format($get_nums,0)."&nbsp;คน&nbsp;</strong></td> 
 
			 		 
		 </tr>";		 

		//} //foreach 
  // } // $arr_org; 


include_once("inc_report_bottom.php"); 
// End report 1
?>