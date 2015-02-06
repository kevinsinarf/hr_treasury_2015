<?php
$path = "../../";
include($path."include/config_header_top.php");

$key_index = $_REQUEST['key_index'];
$arr_prefix=GetSqlSelectArray("PREFIX_ID", "PREFIX_NAME_TH", "SETUP_PREFIX", "ACTIVE_STATUS='1' and DELETE_FLAG='0'", "PREFIX_NAME_TH");
?>

<div class="container-full">
    <div class="col-xs-12 col-sm-12">
        <div class="groupdata" >
		<form id="frm-popadd" method="post" action="" name="frm-popadd">
        <input type="hidden" id="proc" name="proc" value="<?php echo "add"; ?>">
        <input type="hidden" id="key_index" name="key_index" value="<?php echo $key_index; ?>">
        
        <div class="row formSep">
			<div class="col-xs-12 col-md-4" style="white-space:nowrap;"><?php echo $arr_txt['idcard']; ?> : <span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-5">
                <input type="text" id="ADD_SP_IDCARD" name="ADD_SP_IDCARD" class="form-control idcard" placeholder="<?php echo $arr_txt['idcard'];?>"  maxlength="13" onblur="chk_idcard(this, this.value);" >
           </div>
    	</div>
        
        <div class="row formSep">
			<div class="col-xs-12 col-md-4" style="white-space:nowrap;"><?php echo $arr_txt['title']; ?> : <span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-5">
                <?php 
						echo GetHtmlSelect('ADD_PREFIX_ID','ADD_PREFIX_ID',$arr_prefix,$arr_txt['title']."",'','','','1');
					?>
           </div>
    	</div>
        
        <div class="row formSep">
           <div class="col-xs-12 col-md-4" style="white-space:nowrap;"><?php echo $arr_txt['fname']; ?> : <span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-5">
                <input type="text" id="ADD_SP_FIRSTNAME_TH" name="ADD_SP_FIRSTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['fname']; ?>" maxlength="100" >
           </div>
    	</div>
        
        <div class="row formSep">
           <div class="col-xs-12 col-md-4" style="white-space:nowrap;"><?php echo $arr_txt['mname']; ?> : &nbsp;</div>
			<div class="col-xs-12 col-md-5">
                <input type="text" id="ADD_SP_MIDNAME_TH" name="ADD_SP_MIDNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['mname']; ?>" maxlength="100" >
           </div>
    	</div>
        
        <div class="row formSep">
           <div class="col-xs-12 col-md-4" style="white-space:nowrap;"><?php echo $arr_txt['lname']; ?> : <span style="color:red;">*</span>&nbsp;</div>
			<div class="col-xs-12 col-md-5">
                <input type="text" id="ADD_SP_LASTNAME_TH" name="ADD_SP_LASTNAME_TH" class="form-control" placeholder="<?php echo $arr_txt['lname']; ?>" maxlength="100" >
           </div>
    	</div>
        
        <div class="formlast">
			<div class="col-xs-12 col-sm-12" align="center">
			  <button type="button" id="add_pop" class="btn btn-primary" onClick="chkinput_pop('frm-popadd');">บันทึก</button>
			  <button type="button" class="btn btn-default" onClick="search_pop('form_sp_profile_popup.php','show_display','',$('#key_index').val());">ยกเลิก</button></button>
			</div>
        </div>
      </form>
    </div>
  </div>
  </div>
</div>