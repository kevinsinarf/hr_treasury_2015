<?php 
 
 
$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 40; 
if($postype_id_is > 0){
	if($postype_id_is==5){
$menu_name = 53; 
	}
} 

 if($menu_name==40){
     //$wh_pt_id = " AND  d.PT_ID = 1  ";
 
 }
 if($menu_name==53){
     //$wh_pt_id = " AND  d.PT_ID = 2  ";
 
 }

 
$sum_all = 1;
$year_fillter_is = '';
// POST Value;
$AGE_BETWEEN = $_POST['AGE_BETWEEN'];
$AGE_IS = $_POST['AGE_IS'];
$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");  
 

?>
 
 

        
 		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ค้นหาตามอายุ :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="AGE_IS" name="AGE_IS" class="selectbox form-control" placeholder="ค้นหาตามอายุ "     >   
                      <option value=""></option>
                      <?php for($i=18;$i<=60;$i++){
					      if($AGE_IS>0){
						     $arr_org1 = array();
					     	 $arr_org1[$AGE_IS] = $AGE_IS;
						  }else{
					     	 $arr_org1[$i] = $i; 	
						  }			  
					  ?>
                        <option value="<?php echo $i;?>"  <?php echo ($AGE_IS == $i?"selected":"");?>  >
                        <?php echo $i;?></option>
                      <?php }?>
                    </select>				
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> 			
            <div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button></div></div>
			<div class="col-xs-12 col-sm-2">
 	
			</div>
        </div>
        
     
		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">ค้นหาตามช่วงอายุ :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="AGE_BETWEEN" name="AGE_BETWEEN" class="selectbox form-control" placeholder="ค้นหาตามช่วงอายุ "     >   
                      			<option value=""></option>
                                <?php for($i=1;$i<=6;$i++){ 
								
								  if($AGE_BETWEEN>0){
									 $arr_org1 = array();
									 $arr_org2[$AGE_BETWEEN] = $age_between[$AGE_BETWEEN]['name']; 
								  }else{
									 $arr_org2[$i] = $age_between[$i]['name']; 	
								  } 
								?>
                                   <option value="<?php echo $i; ?>"    <?php echo ($AGE_BETWEEN == $i?"selected":"");?>  ><?php echo $age_between[$i]['name']; ?></option>
                                <?php } ?>
                                      
   
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">  			
            <div class="col-xs-12 col-sm-2"><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(2);searchData();">ค้นหา</button></div></div>
			<div class="col-xs-12 col-sm-2">
 
			</div>
        </div>
 
 
<?php  
 
    $q_where = '';	
	if($SEARCH_TYPE==1){ 
		if($AGE_IS>0){
			$q_where = sql_where_age($AGE_IS,1);	
		} 
	}
	if($SEARCH_TYPE==2){ 
		if($AGE_BETWEEN>0){
			$q_where = sql_where_age($AGE_BETWEEN,2);	
		} 
	}
		   
		   $sql_list = "SELECT  A.PER_SALARY_POSITION,A.PER_SALARY,A.POS_NO,A.LINE_ID,A.PER_ID, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, A.PER_DATE_BIRTH, A.PER_DATE_ENTRANCE, 
	A.PER_DATE_OCCUPLY, A.PER_DATE_RETIRE,  D.CV_NAME_TH  ,A.PER_FILE_PIC ,E.TYPE_NAME_TH, A.PER_SALARY_POSITION ,A.ORG_ID_3
   ,F.LEVEL_NAME_TH,G.LINE_NAME_TH,A.PER_IDCARD,A.PER_GENDER , DATEDIFF(YEAR,a.PER_DATE_BIRTH,GETDATE()) 'MyAge' 
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
			$MyAge = (int)$rec_list["MyAge"];
 
 
			
			$html  .= "<tr  style='height:0.7cm;'> 
				 <td CENTER_TOP  >".$start_no."</td> 
				 <td LEFT_TOP   >&nbsp;".text($rec_list['PER_IDCARD'])."&nbsp;  </td> 
				 <td LEFT_TOP   >&nbsp;".$PER_NAME."&nbsp; </td>
				 <td LEFT_TOP   >&nbsp;".$line_name_th."&nbsp; </td> 
				 <td CENTER_TOP   >&nbsp;  ".$MyAge."&nbsp; </td>";
			$html  .= " </tr>";
			$start_no++;		
			}
		$html  .= "<tr style='height:0.7cm;'> 
			 
			 <td CENTER_TOP   colspan='4' ><div align='center'><strong>รวมจำนวน  </strong></div></td> 
			 <td CENTER_TOP ><strong>".number_format($get_nums,0)."&nbsp;คน&nbsp;</strong></td> 
 
			 		 
		 </tr>";		 

		//} //foreach 
  // } // $arr_org; 


include_once("inc_report_bottom.php"); 
// End report 1
?>