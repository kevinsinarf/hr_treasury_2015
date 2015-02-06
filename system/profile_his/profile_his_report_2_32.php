<?php 
 
 
$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}
$menu_name = 39; 
if($postype_id_is > 0){
	if($postype_id_is==5){
$menu_name = 52; 
	}
} 

 if($menu_name==39){
     //$wh_pt_id = " AND  d.PT_ID = 1  ";
 
 }
 if($menu_name==52){
     //$wh_pt_id = " AND  d.PT_ID = 2  ";
 
 }


 
$sum_all = 1;
$year_fillter_is = '';
$gender = (int)$_POST['gender']; 
$my_gender = ""; 
$title_1 = $year_fillter_is;
// filter area
include_once("inc_report_top.php");  
 

?>
 

		<div class="row">
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;">เพศ :</div>
			<div class="col-xs-12 col-sm-3">
                    <select id="gender" name="gender" class="selectbox form-control" placeholder="เพศ "     >   
                      <option value=""></option>
                        <option value=""     ><?php echo $arr_txt['show_all']; ?></option>             
                        <option value="1"     ><?php echo $arr_gender[1]; ?></option>
                        <option value="2"     ><?php echo $arr_gender[2]; ?></option>          
                    </select>			
            </div>
            <div class="col-xs-12 col-sm-1"></div>
			<div class="col-xs-12 col-sm-2" style="white-space:nowrap;"> </div>
			<div class="col-xs-12 col-sm-2">
 <button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);searchData();">ค้นหา</button>	
			</div>
        </div>
 
 
 
<?php  
 
   $q_where = '';	
   if($SEARCH_TYPE==1){ 
   		if($gender>0){
		   $q_where = ' AND a.PER_GENDER = '.$gender.' ';
		}
   
		  
	}// if
	
 
	 
 
		   
		   $sql_list = "SELECT  A.PER_SALARY_POSITION,A.PER_SALARY,A.POS_NO,A.LINE_ID,A.PER_ID, A.PREFIX_ID, A.PER_FIRSTNAME_TH, A.PER_MIDNAME_TH, A.PER_LASTNAME_TH, A.PER_DATE_BIRTH, A.PER_DATE_ENTRANCE, 
	A.PER_DATE_OCCUPLY, A.PER_DATE_RETIRE,  D.CV_NAME_TH  ,A.PER_FILE_PIC ,E.TYPE_NAME_TH, A.PER_SALARY_POSITION ,A.ORG_ID_3
   ,F.LEVEL_NAME_TH,G.LINE_NAME_TH,A.PER_IDCARD,A.PER_GENDER
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
			$gender_is = (int)$rec_list["PER_GENDER"];
			if($gender_is>0){
			    $my_gender = $arr_gender[$gender_is];
			}
 
			
			$html  .= "<tr  style='height:0.7cm;'> 
				 <td CENTER_TOP  >".$start_no."</td> 
				 <td LEFT_TOP   >&nbsp;".text($rec_list['PER_IDCARD'])."&nbsp;  </td> 
				 <td LEFT_TOP   >&nbsp;".$PER_NAME."&nbsp; </td>
				 <td LEFT_TOP   >&nbsp;".$line_name_th."&nbsp; </td> 
				 <td CENTER_TOP   >&nbsp;  ".$my_gender."&nbsp; </td>";
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