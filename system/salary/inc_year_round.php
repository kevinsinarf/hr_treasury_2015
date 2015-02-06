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
			<div class="col-xs-12 col-sm-3">
				<select name="ROUND" id="ROUND" class="selectbox form-control" placeholder="รอบ">
                    <option value=""></option>
		 
                       <option value="1" <?php if(1 == $ROUND){ echo "selected"; }?>> รอบที่ 1 (1 ตุลาคม - 31 มีนาคม) </option>
                       <option value="2" <?php if(2 == $ROUND){ echo "selected"; }?>> รอบที่ 2 (1 เมษายน - 30 กันยายน) </option>       
                </select>
			</div>
			<div class="col-xs-12 col-sm-2">
	  				
			</div>
            

<?php
   $s_ORG_NAME_TH = $_POST['s_ORG_NAME_TH'];
   $arr_org = array();
   $sql_org = "select ORG_ID, ORG_NAME_TH ";
   $sql_org .= " from SETUP_ORG  "; 
   $sql_org .= " WHERE ".ORG_basic_where();
   if(($s_OT_ID==5)||($s_OT_ID==6)){
	   $sql_org .= " and OT_ID = ".$s_OT_ID." ";
   }
    if($s_ORG_NAME_TH!=""){
	   //$sql_org .= " and ORG_NAME_TH LIKE '%".ctext($s_ORG_NAME_TH)."%' ";
	   $sql_org .= " and ORG_ID = {$s_ORG_NAME_TH} ";
    }
    $sql_org2 .= " ORDER BY ORG_SEQ ASC";
	$query_org = $db->query($sql_org." ORDER BY ORG_SEQ ASC"); 
	$num_rows = $db->db_num_rows($query_org);
	
   $sql_org2 = "select ORG_ID, ORG_NAME_TH ";
   $sql_org2 .= " from SETUP_ORG  "; 
   $sql_org2 .= " WHERE   ".ORG_basic_where();
   
 
   $sql_org2 .= " ORDER BY ORG_SEQ ASC";
   $query_org2 = $db->query($sql_org2); 
	
	?>   
            
 
            
            
            
            
            
            <br/><br/><br/>
             <div align="center" ><button type="button" class="btn btn-primary" onClick="$('#SEARCH_TYPE').val(1);return year_select_please();">ค้นหา</button> </div>
 
		</div>
        


<?php 
			if (in_array($menu_name, $attached_report)) { ?>
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
    
<?php } ?>
        
    