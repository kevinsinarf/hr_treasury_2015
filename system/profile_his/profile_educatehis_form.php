<?php
$path = "../../";
include($path."include/config_header_top.php");

$link = "r=home&menu_id=".$menu_id;  /// for mobile
$link2="menu_id=".$menu_id."&menu_sub_id=".$menu_sub_id."&PT_ID=".$PT_ID."&PER_ID=".$PER_ID."&ACT=".$ACT;
//page back
if($PT_ID=="2"){
	$page_back = "profile_his_empser.php";
	$POSTYPE_ID = '3';
}elseif($PT_ID=="3"){
	$page_back = "profile_his_emp.php";
	$POSTYPE_ID = '5';
}else{
	$page_back = "profile_his_disp.php";
	$POSTYPE_ID = '1';
}
$paramlink = url2code($link);

//POST
$PER_ID=$_POST['PER_ID'];
$EDU_ID=$_POST['EDU_ID'];

$txt = (($proc == "add") ? "เพิ่มข้อมูล":"แก้ไขข้อมูล"); 

//DATA
$sql = "SELECT A.EDU_ID,A.PER_ID,EDU_SEQ,A.EL_ID, B.EL_GROUP, A.ED_ID,EM_ID,INS_ID,A.COUNTRY_ID,EDU_GPA,A.EDU_HORNOR,A.EDU_SDATE, A.EDU_EDATE,A.EDU_SCHOLARSHIP,
A.EDU_TYPE, A.EDU_NOTE, A.ACTIVE_STATUS
FROM PER_EDUCATEHIS A
LEFT JOIN SETUP_EDU_DEGREE B ON A.ED_ID = B.ED_ID  where A.DELETE_FLAG = '0' AND A.EDU_ID = '".$EDU_ID."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$COUNTRY_ID = empty($rec['COUNTRY_ID'])?$default_country_id:$rec['COUNTRY_ID'];
$EL_ID = $rec['EL_ID'];
$EL_GROUP = $rec['EL_GROUP'];

//ระดับการศึกษา
$sql_edu="select EL_ID,EL_GROUP, EL_NAME_TH, EL_TYPE from SETUP_EDU_LEVEL where ACTIVE_STATUS='1' and DELETE_FLAG='0' order by EL_TYPE, EL_ID";
$query_edu=$db->query($sql_edu);/*
//วุฒิการศึกษา
$sql_degree = "SELECT ED_ID , (CASE WHEN ED_NAME_TH IS NULL OR ED_NAME_TH = '' THEN ED_NAME_EN ELSE ED_NAME_TH END) AS ED_NAME from SETUP_EDU_DEGREE 
                    WHERE ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND EL_GROUP= '".$EL_GROUP."' 
					ORDER BY (CASE WHEN ED_NAME_TH IS NULL OR ED_NAME_TH = '' THEN ED_NAME_EN ELSE ED_NAME_TH END) ASC "; 
//สาขาวิชาเอก
$sql_major = "SELECT EM_ID, 
				  (CASE WHEN EM_NAME_TH IS NULL OR EM_NAME_TH = '' THEN EM_NAME_EN ELSE EM_NAME_TH END) AS EM_NAME_TH
 				  FROM SETUP_EDU_MAJOR 
 				  WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' 
				  ORDER BY (CASE WHEN EM_NAME_TH IS NULL OR EM_NAME_TH = '' THEN EM_NAME_EN ELSE EM_NAME_TH END) ASC ";
//สถานศึกษา
$sql_ins = "SELECT INS_ID, (CASE WHEN INS_NAME_TH IS NULL OR INS_NAME_TH = '' THEN INS_NAME_EN ELSE INS_NAME_TH END) AS INS_NAME_TH
               FROM SETUP_EDU_INSTITUTE 
               WHERE ACTIVE_STATUS='1' and DELETE_FLAG='0' 
			   ORDER BY (CASE WHEN INS_NAME_TH IS NULL OR INS_NAME_TH = '' THEN INS_NAME_EN ELSE INS_NAME_TH END) ASC ";
*/

$arr_country=GetSqlSelectArray("COUNTRY_ID", "COUNTRY_NAME_TH", "SETUP_COUNTRY", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "COUNTRY_NAME_TH");//ประเทศ
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="language" content="en" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>

<link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
<link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
<link href="<?php echo $path; ?>css/select2.css" rel="stylesheet">
<?php /*
<link href="<?php echo $path; ?>js/select2-bootstrap.css" rel="stylesheet">
*/ ?>
<script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
<script src="<?php echo $path; ?>js/func.js"></script>
<script src="js/profile_educatehis_disp.js?<?php echo rand(); ?>"></script>
</head>
<body <?php echo $remove;?>>
<div class="container-full">
  <div><?php include($path."include/header.php");?></div>
  <div><?php include($path."include/menu.php");?></div>
  <div class="col-xs-12 col-sm-12">
    <ol class="breadcrumb">
      <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
	  <li><a href="<?php echo $page_back."?".url2code($link2);?>"><?php echo Showmenu($menu_sub_id);?></a></li>
      <li><a href="profile_educatehis_disp.php?<?php echo url2code($link2); ?>">ประวัติการศึกษา</a></li>
	  <li class="active"><?php echo $txt; ?></li>
    </ol>
  </div>
  <div class="col-xs-12 col-sm-12" id="content">
    <div class="groupdata" ><br>
	<?php include ("tab_info.php"); ?>
	<div class="clearfix"></div>
      <form id="frm-input" method="post" action="process/profile_educatehis_process.php" enctype="multipart/form-data">
        <input type="hidden" id="proc" name="proc" value="<?php echo $proc; ?>">
        <input type="hidden" id="menu_id"  name="menu_id"value="<?php echo $menu_id; ?>">
        <input type="hidden" id="menu_sub_id" name="menu_sub_id" value="<?php echo $menu_sub_id;?>">
        <input type="hidden" id="page" name="page" value="<?php echo $page; ?>">
        <input type="hidden" id="page_size" name="page_size"  value="<?php echo $page_size; ?>">
        <input type="hidden" id="PER_ID" name="PER_ID" value="<?php echo $PER_ID?>">
        <input type="hidden" id="PT_ID" name="PT_ID" value="<?php echo $PT_ID ?>">
        <input type="hidden" id="ACT" name="ACT" value="<?php echo $ACT ?>">
        <input type="hidden" id="EDU_ID" name="EDU_ID"  value="<?php echo $EDU_ID; ?>">


        <div class="row head-form">ข้อมูลประวัติการศึกษา </div>

        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ระดับการศึกษา : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-sm-3">
<?php
/*
$el_name_is = "";
if($proc == "edit"){
	$EL_ID =  $rec['EL_ID'];
	$sql1 = " select  EL_NAME_TH  from SETUP_EDU_LEVEL  where EL_ID = '".$EL_ID."' ";
	$query1 = $db->query($sql1);
	$rec1 = $db->db_fetch_array($query1);
	$el_name_is = text($rec1['EL_NAME_TH']);
}  
 */
?>
<?php /* 
<input type="text" id="EL_name" style="width:300px"  class="selectbox chzn-done" class='ajaxselect'  data-initvalue=''   value='[{"id":"<?php echo $rec['EL_ID']?>","name":"<?php echo $el_name_is; ?>"}]'   />
 <input type="hidden" id="EL_ID"   name="EL_ID" style="width:300px"   value="<?php echo $EL_ID;?>"      />
 <input type="hidden" id="EL_GROUP"   name="EL_GROUP" style="width:300px"  value="<?php echo $EL_ID;?>"    /> 
 */
 ?>
 
 
                 <select id="EL_ID" name="EL_ID" class="selectbox form-control" placeholder="ระดับการศึกษา" onChange="get_edu(this.value)" >
                    <option value=""></option>
                    <?php 
                    $t="";
                    while($rec_edu = $db->db_fetch_array($query_edu)){
                        if($t!=$rec_edu['EDU_ID']){
                            echo ($t!=''?"":"</optgroup>");
                            echo "<optgroup label='".$arr_edu_level_m[$rec_edu['EDU_ID']]."'>";
                            $t=$rec_edu['EDU_ID'];
                        }
                        ?><option value="<?php echo $rec_edu['EL_ID']?>" <?php echo ($rec_edu['EL_ID']==$rec['EL_ID']?"selected":"")?>><?php echo text($rec_edu['EL_NAME_TH']);?></option><?php
                    }
                    ?>
                </select>
 
            </div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2">วุฒิการศึกษา : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-sm-3">
            
<?php

$ed_name_is = "";
if($proc == "edit"){
	$ED_ID =  $rec['ED_ID'];
	$sql2 = " select  ED_NAME_TH  from SETUP_EDU_DEGREE  where ED_ID = '".$ED_ID."' ";
	$query2 = $db->query($sql2);
	$rec2 = $db->db_fetch_array($query2);
	$ed_name_is = text($rec2['ED_NAME_TH']);
} 

?>
<input type="hidden" id="ED_name" style="width:300px"  class="selectbox chzn-done"   class='ajaxselect'  data-initvalue=''   value='[{"id":"<?php echo $rec['ED_ID']?>","name":"<?php echo $ed_name_is; ?>"}]'   />
 <input type="hidden" id="ED_ID"   name="ED_ID" style="width:300px"      value="<?php echo $rec['ED_ID']; ?>"    />         
      
 
           
            </div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">สาขาวิชาเอก : </div>
            <div class="col-xs-12 col-sm-3">
<?php

$em_name_is = "";
if($proc == "edit"){
	$EM_ID =  $rec['EM_ID'];
	$sql3 = " select  EM_NAME_TH  from SETUP_EDU_MAJOR  where EM_ID = '".$EM_ID."' ";  
	$query3 = $db->query($sql3);
	$rec3 = $db->db_fetch_array($query3);
	$em_name_is = text($rec3['EM_NAME_TH']);
} 

?>
<input type="hidden" id="EM_name" style="width:300px"  class="selectbox chzn-done"   class='ajaxselect'  data-initvalue=''   value='[{"id":"<?php echo $rec['EM_ID']?>","name":"<?php echo $em_name_is; ?>"}]'    />
 <input type="hidden" id="EM_ID"   name="EM_ID" style="width:300px" value="<?php echo $rec['EM_ID']; ?>"      />     
            
			<?php /* echo get_Select($sql_major ,$db , array(
                    'id'=>'EM_ID',
                    'name'=>'EM_ID',
                    'class'=>'form-control selectbox',
                    's_selected'=>$rec['EM_ID'],
                    's_defualt'=>'',
                    's_key'=>'EM_ID', 
                    's_value'=>'EM_NAME_TH',
                    's_onchage'=>'',
                    's_placeholder'=>'สาขาวิชาเอก',
                    's_style'=>""
                    )
                    ); */ ?>	
            </div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2">สถาบันการศึกษา : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-sm-3">

<?php

$ins_name_is = "";
if($proc == "edit"){
	$INS_ID =  $rec['INS_ID'];
	$sql4 = " select  INS_NAME_TH  from SETUP_EDU_INSTITUTE  where INS_ID = '".$INS_ID."' ";
	$query4 = $db->query($sql4);
	$rec4 = $db->db_fetch_array($query4);
	$ins_name_is = text($rec4['INS_NAME_TH']);
} 

?>


<input type="hidden" id="INS_name" style="width:300px"  class="selectbox chzn-done"   class='ajaxselect'  data-initvalue=''   value='[{"id":"<?php echo $rec['INS_ID']?>","name":"<?php echo $ins_name_is; ?>"}]'    />
 <input type="hidden" id="INS_ID"   name="INS_ID" style="width:300px" value="<?php echo $rec['INS_ID']; ?>"    />    
            
            <?php  /* echo get_Select($sql_ins ,$db , array(
                    'id'=>'INS_ID',
                    'name'=>'INS_ID',
                    'class'=>'form-control selectbox',
                    's_selected'=>$rec['INS_ID'],
                    's_defualt'=>'',
                    's_key'=>'INS_ID', 
                    's_value'=>'INS_NAME_TH',
                    's_onchage'=>'',
                    's_placeholder'=>'สถาบันการศึกษา',
                    's_style'=>""
                    )
                    ); */ ?>	
            </div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ประเทศ : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-sm-2"><?php   echo GetHtmlSelect('COUNTRY_ID','COUNTRY_ID',$arr_country,'ประเทศ',$COUNTRY_ID,'','','1');?></div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">ผลการเรียนเฉลี่ย : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2"><input type="text" id="EDU_GPA" name="EDU_GPA" class="form-control" placeholder="ผลการเรียนเฉลี่ย" maxlength="4" value="<?php echo text(number_format($rec['EDU_GPA'],2)); ?>" onKeyUp="chkFormatNam(this.value,this.id);" ></div>
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-sm-2">สถานะของเกียรตินิยม : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-sm-2">
                <select id="EDU_HORNOR" name="EDU_HORNOR" class="selectbox form-control" placeholder="สถานะของเกียรตินิยม">
                    <option value=""></option>
                    <?php foreach($arr_act_honor as $key => $value){ ?>
                    <option value="<?php echo $key ?>" <?php echo ($rec['EDU_HORNOR'] == $key?"selected":"");?>><?php echo $value;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่เริ่มศึกษา : </div>
            <div class="col-xs-12 col-sm-2">
                <div class="input-group">
                <input type="text" id="EDU_SDATE" name="EDU_SDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec["EDU_SDATE"]);?>">
                <span class="input-group-addon datepicker" for="EDU_SDATE" >&nbsp;<span class="glyphicon glyphicon-calendar"></span>&nbsp;</span></div>	
            </div> 
            <div class="col-xs-12 col-sm-2"></div>
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap">วันที่สำเร็จการศึกษา : <span style="color:red;">*</span></div>
            <div class="col-xs-12 col-sm-2">
                <div class="input-group">
                    <input type="text" id="EDU_EDATE" name="EDU_EDATE" class="form-control" placeholder="DD/MM/YYYY" maxlength="10"  value="<?php echo conv_date($rec["EDU_EDATE"]);?>">
                    <span class="input-group-addon datepicker" for="EDU_EDATE" >&nbsp;
                    <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                    </span>
                </div>	
            </div> 
        </div>
                
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">สถานะของการได้รับทุน : <span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-sm-3">
            <label ><input type="radio" id="EDU_SCHOLARSHIP1" name="EDU_SCHOLARSHIP" value="1" <?php echo ($rec['EDU_SCHOLARSHIP']=='1'||$rec['EDU_SCHOLARSHIP']=='' ?"checked":"")?>>  <?php echo $arr_scholarship['1'];?></label>&nbsp;&nbsp;
            <label ><input type="radio" id="EDU_SCHOLARSHIP2" name="EDU_SCHOLARSHIP" value="2" <?php echo ($rec['EDU_SCHOLARSHIP']=='2'?"checked":"")?>>  <?php echo $arr_scholarship['2'];?></label></div>
            <div class="col-xs-12 col-sm-1"></div>
            <div class="col-xs-12 col-sm-2">ประเภทของวุฒิการศึกษา : <span style="color:red;">*</span>&nbsp; </div>
            <div class="col-xs-12 col-sm-3">
            <select id="EDU_TYPE" name="EDU_TYPE" class="selectbox form-control" placeholder="ประเภทของวุฒิการศึกษา">
                <option value=""></option>
                <?php foreach($arr_edu_type as $key => $value){ ?>
                    <option value="<?php echo $key ?>" <?php echo ($rec['EDU_TYPE'] == $key?"selected":"");?>><?php echo $value;?></option>
                <?php } ?>
            </select>
            </div>
        </div>
              
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2">หมายเหตุ : </div>
            <div class="col-xs-12 col-sm-3"><textarea id="EDU_NOTE" name="EDU_NOTE" class="form-control" placeholder="หมายเหตุ" maxlength="255" rows="3"><?php echo text($rec['EDU_NOTE']); ?></textarea></div>
        </div>
         
        <div class="row formSep">
            <div class="col-xs-12 col-sm-2" style="white-space:nowrap"><?php echo $arr_txt['active'];?> :&nbsp;<span style="color:red;">*</span>&nbsp;</div>
            <div class="col-xs-12 col-md-2">
            <label ><input type="radio" id="ACTIVE_STATUS1" name="ACTIVE_STATUS" value="1" <?php echo ($rec['ACTIVE_STATUS']=='1'||$rec['ACTIVE_STATUS']=='' ?"checked":"")?>> <?php echo $arr_act_status['1'];?></label>&nbsp;&nbsp;
            <label ><input type="radio" id="ACTIVE_STATUS0" name="ACTIVE_STATUS" value="0" <?php echo ($rec['ACTIVE_STATUS']=='0'?"checked":"")?> > <?php echo $arr_act_status['0'];?></label></div>
        </div>
                
        <div class="col-xs-12 col-sm-12" align="center" style="margin-top:10px;">
          <button type="button" class="btn btn-primary" onClick="chkinput();">บันทึก</button>
          <button type="button" class="btn btn-default" onClick="self.location.href='profile_educatehis_disp.php?<?php echo url2code($link2);?>';">ยกเลิก</button>
        </div>
        <br>
      </form>
    </div>
  </div>
  <div style="text-align:center; bottom:0px;">
    <?php include($path."include/footer.php"); ?>
  </div>
</div>
<script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>

<script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
<?php /*<script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>

<script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
 */ ?>
<script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>

<script src="<?php echo $path; ?>bootstrap/js/bootstrap-datepicker.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
<script src="<?php echo $path; ?>bootstrap/js/inputmask.js"></script>
 
<script src="<?php echo $path; ?>js/select2.js"></script>
<script>

















function jsonFormatResult( json ) {
 
	var markup = "<div>"+ json.name+"</div>";
	
	return markup;
}

function jsonFormatSelection_EL_ID(json ) { 
   $('#EL_ID').val(json.id);     
   $('#EL_GROUP').val(json.id); //$('#EL_GROUP').val(json.EL_GROUP);     
   
   
   return json.name; 	 
 }

function jsonFormatSelection_ED_ID(json ) { 
   $('#ED_ID').val(json.id);return json.name; 	 
 }

function jsonFormatSelection_EM_ID(json ) { 
   $('#EM_ID').val(json.id);return json.name; 	 
 }
 
function jsonFormatSelection_INS_ID(json ) { 
   $('#INS_ID').val(json.id);return json.name; 	 
 }
 
<? /*  
 
$("#EL_name").select2({
        placeholder: 'ค้นหาระดับการศึกษา ',
	minimumInputLength: 3,
	ajax: {
        url: "<?php echo $path; ?>system/dev_ajax/ajax_edu.php",
		dataType: "json",
		quietMillis: 500,
		data: function( term, page ) { return { q: term,  whattype: "EL"  }; },
		results: function( data, page ) { return {  results: data.items }; },
		cache: true
	},
	<?php if($proc == "edit"){ ?>
        initSelection: function(element, callback) {
                    callback({ id: <?php echo $EL_ID; ?>, name: '<?php echo $el_name_is; ?>' }); 
        },
	<?php } ?>
	id: 'id',
 
	formatResult: jsonFormatResult,
	formatSelection: jsonFormatSelection_EL_ID,
	dropdownCssClass: "bigdrop",
	escapeMarkup: function( m ) { return m; }
});

*/ ?>

 /*
$("#EL_name").select2("data",
     [ {"id":"2199","text":"Tom Phillips"}]
);*/

$("#ED_name").select2({
        placeholder: 'ค้นหาวุฒิการศึกษา ',
	minimumInputLength: 1,
	ajax: {
        url: "<?php echo $path; ?>system/dev_ajax/ajax_edu.php",
		dataType: "json",
		quietMillis: 500,
		data: function( term, page ) { return { q: term,  whattype: "ED" ,  EL_ID: $('#EL_ID').val()   }; },
		results: function( data, page ) { return {  results: data.items }; },
		cache: true
	},
	<?php if($proc == "edit"){ ?>
        initSelection: function(element, callback) {
                    callback({ id: <?php echo $ED_ID; ?>, name: '<?php echo $ed_name_is; ?>' }); 
        },
	<?php } ?>
	id: 'id',
	formatResult: jsonFormatResult,
	formatSelection: jsonFormatSelection_ED_ID,
	dropdownCssClass: "bigdrop",
	escapeMarkup: function( m ) { return m; }
});

$("#EM_name").select2({
        placeholder: 'ค้นหาสาขาวิชาเอก ',
	minimumInputLength: 1,
	ajax: {
        url: "<?php echo $path; ?>system/dev_ajax/ajax_edu.php",
		dataType: "json",
		quietMillis: 500,
		data: function( term, page ) { return { q: term,  whattype: "EM"     }; },
		results: function( data, page ) { return {  results: data.items }; },
		cache: true
	},
	<?php if($proc == "edit"){ ?>
        initSelection: function(element, callback) {
                    callback({ id: <?php echo $EM_ID; ?>, name: '<?php echo $em_name_is; ?>' }); 
        },
	<?php } ?>
	id: 'id',
	formatResult: jsonFormatResult,
	formatSelection: jsonFormatSelection_EM_ID,
	dropdownCssClass: "bigdrop",
	escapeMarkup: function( m ) { return m; }
});


$("#INS_name").select2({
        placeholder: 'ค้นหาสถาบันการศึกษา ',
	minimumInputLength: 1,
	ajax: {
        url: "<?php echo $path; ?>system/dev_ajax/ajax_edu.php",
		dataType: "json",
		quietMillis: 500,
		data: function( term, page ) { return { q: term,  whattype: "INS"     }; },
		results: function( data, page ) { return {  results: data.items }; },
		cache: true
	},
	<?php if($proc == "edit"){ ?>
        initSelection: function(element, callback) {
                    callback({ id: <?php echo $INS_ID; ?>, name: '<?php echo $ins_name_is; ?>' }); 
        },
	<?php } ?>
	id: 'id',
	formatResult: jsonFormatResult,
	formatSelection: jsonFormatSelection_INS_ID,
	dropdownCssClass: "bigdrop",
	escapeMarkup: function( m ) { return m; }
});


 
 /*		contentType: "application/json; charset=utf-8",*/
$('#e5xx').select2({    
        placeholder: 'ค้นหาระดับการศึกษา ',
		width: '200px',
        ajax: {
            url: "<?php echo $path; ?>system/dev_ajax/ajax_edu.php",
            dataType: 'json',
            quietMillis: 100,
            data: function (term, page) {   
			var data;
                return {
                    term: term, //search term
                    page_limit: 10 // page size
                };
            },
            results: function (data, page) {
                return { results: data.results };  
            }
        },
        initSelection: function(element, callback) {
            return $.getJSON("<?php echo $path; ?>system/dev_ajax/ajax_edu.php?id=" + (element.val()), null, function(data) { 
                    return callback(data);
            });
        },
		id: 'id',
		escapeMarkup: function( m ) { return m; }
    });
	$.ajaxSetup({ scriptCharset: "utf-8" , contentType: "application/json; charset=utf-8"});
	
 
	
	
</script>
 
</body>
</html>