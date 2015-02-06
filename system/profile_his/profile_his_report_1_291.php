<?php 
$path = "../../";
include($path."include/config_header_top.php");
$link = "menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id;  /// for mobile
$paramlink = url2code($link);
 
$postype_id_is = (int)$_GET['postype_id'];
if($postype_id_is==0){
	$postype_id_is = (int)$_POST['POSTYPE_ID_is'];
}

$menu_name = 26;
if($postype_id_is==1){ $menu_num = "25".$number_subfix;}
if($postype_id_is==3){ $menu_num = "46".$number_subfix;}
if($postype_id_is==5){ $menu_num = "62".$number_subfix;}

$$AGE_IS = (int)$_POST['$AGE_IS'];
$$AGE_IS2 = (int)$_POST['$AGE_IS2'];

//ประเภทการถือครอง
$arr_poshis_live = array(  
	'1' => 'ปกติ',
	'2' => 'ปฏิบัติราชการแทน',
	'3' => 'รักษาราชการแทน',
	'4' => 'ช่วยราชการภายในสำนักงานฯ',
	'5' => 'ช่วยราชการภายนอกสำนักงานฯ'
);

 

include_once("inc_csv_search.php");  

$html_start = "<table width='100%' id='x_width_scoll' name='x_width_scoll' border='0' cellspacing='0' cellpadding='0' style='margin-bottom:15px;margin-left: 0px; width: 800px;  white-space: nowrap; overflow: hidden;' class='table table-bordered table-striped table-hover table-condensed'    width='100%' role='grid'  >
	<thead width='100%' border='0' cellspacing='0' cellpadding='0' >
  <tr class='bgHead'> ";
        $out_header = "";
		
include_once($php_body); 
			 
$html_end   = "</table></div>"; 
include_once("inc_print_btn_and_output.php"); ?>
        
            </div>

         </div> 
 </div> 
  <?php
   $out = "";
   $out .= $out_header;
 
foreach($list_csv as $arr) { // gen data body
	$arr = str_replace(",", "&sbquo;",$arr);
    $out .= implode(",", $arr) . "\r\n";
}    
   ?>    
    <center> 
    <form id="frm-291csv" method="post" action="profile_his_report_1_291csv.php" target="_blank">
       <input type="hidden" name="listme" id="listme" value="<?php echo $out; ?>" >
       <input type="hidden" name="listnum" id="listnum" value="<?php echo $start_no; ?>" >
       <input type="hidden" name="postype_id_csv" id="postype_id_csv" value="<?php echo $postype_id_is; ?>" >
       <button type="button" class="btn btn-primary dropdown-toggle"  onClick="csv_export291();"  > ส่งออกข้อมูลในรูปแบบ CSV   </button>
    </form>
  
 
 
    
 <br/><br/>
    
</center></div>
	<?php include_once("report_footer.php"); ?>
</div>
</body>
</html>
    
    