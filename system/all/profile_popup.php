<?php
$path = "../../";
include($path."include/config_header_top.php");
ini_set("max_execution_time" , 160);

$sql = "SELECT 	a.*
		FROM	PER_PROFILE a
		WHERE 	a.PER_ID = '".$_GET['PER_ID']."'";
$query = $db->query($sql);
$num=$db->db_num_rows($query);
$data_main = $db->db_fetch_array($query);

if($num>0){
	if($data_main['PER_DATE_BIRTH']){
		$data_main['AGE_PERSON']=diff_date(conv_date(text($data_main['PER_DATE_BIRTH'])),"y",(date('Y')+543).date('md'));
	}//if
	if($data_main['AGE_OCCUPLY']){
		$data_main['AGE_OCCUPLY']=diff_date(conv_date(text($data_main['PER_DATE_OCCUPLY'])),"y",(date('Y')+543).date('md'));
	}//if
}//if

$arr_pos_line=GetSqlSelectArray("LINE_ID", "LINE_NAME_TH", "SETUP_POS_LINE", "ACTIVE_STATUS='1' AND DELETE_FLAG='0' AND TYPE_ID = '".$data_main['TYPE_ID']."'","LINE_NAME_TH");

$arr_tamb=GetSqlSelectArray("TAMB_ID", "TAMB_NAME_TH", "SETUP_TAMB", "AMPR_ID='".$data_main['ADD_AMPR_ID']."' AND ACTIVE_STATUS='1' AND DELETE_FLAG='0'", "TAMB_NAME_EN");
			
$arr_ampr=GetSqlSelectArray("AMPR_ID", "AMPR_NAME_TH", "SETUP_AMPR", "PROV_ID='".$data_main['ADD_PROV_ID']."' AND ACTIVE_STATUS='1' AND DELETE_FLAG='0'", "AMPR_NAME_EN");

//org3
$arr_org3=GetSqlSelectArray(
						"a.ORG_ID",
						"a.ORG_NAME_TH",
						"SETUP_ORG as a", 
						"a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$data_main['ORG_ID_2']."' ", 
						"ORG_NAME_TH");
//org4
$arr_org4=GetSqlSelectArray(
						"a.ORG_ID",
						"a.ORG_NAME_TH",
						"SETUP_ORG as a", 
						"a.ACTIVE_STATUS='1' AND a.DELETE_FLAG='0' AND a.ORG_PARENT_ID='".$data_main['ORG_ID_3']."'  ", 
						"ORG_NAME_TH");
?>
<div class="row formSep">
    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">ชื่อ-นามสกุล (ไทย):</span></div>
    <div class="col-xs-12 col-md-8"><?php echo Showname($data_main["PREFIX_ID"],$data_main["PER_FIRSTNAME_TH"],$data_main["PER_MIDNAME_TH"],$data_main["PER_LASTNAME_TH"]); ?></div>
</div>
<div class="row formSep">
    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">Name-Surname (English):</span></div>
    <div class="col-xs-12 col-md-8"><?php echo Showname($data_main["PREFIX_ID"],$data_main["PER_FIRSTNAME_EN"],$data_main["PER_MIDNAME_EN"],$data_main["PER_LASTNAME_EN"]); ?></div>
</div>
<div class="row formSep">
    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">วันเกิด:</div>
    <div class="col-xs-12 col-md-2" ><?php echo conv_date(text($data_main['PER_DATE_BIRTH'])); ?></div>
    <div class="col-xs-12 col-md-1" style="white-space:nowrap;">อายุ:</div>
    <div class="col-xs-12 col-md-2"><?php echo text($data_main['AGE_PERSON']); ?><input name="AGE_PERSON" type="hidden" value="<?php echo $data_main['AGE_PERSON']; ?>"> ปี</div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">&nbsp;</div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><strong>ประวัติการราชการ</strong></div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">โดยเริ่มรับราชการ เมื่อวันที่:</div>
    <div class="col-xs-12 col-md-8" ><?php echo conv_date(text($data_main['PER_DATE_OCCUPLY'])); ?></div>	
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">ปัจจุบันดำรงตำแหน่ง:</div>
    <div class="col-xs-12 col-md-8" ><?php echo text($arr_pos_line[$data_main['LINE_ID']]); ?></div>	
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">กลุ่มงาน:</div>
    <div class="col-xs-12 col-md-8" ><?php echo text($arr_org4[$data_main['ORG_ID_4']]); ?></div>	
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-3" style="white-space:nowrap;">สำนัก/กลุ่ม:</div>
    <div class="col-xs-12 col-md-8" ><?php echo text($arr_org3[$data_main['ORG_ID_3']]); ?></div>	
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">&nbsp;</div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><strong>ระดับการศึกษา</strong></div>
    <div class="col-xs-12 col-md-2" ></div>	
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปริญญาตรี:</div>
</div>
    
<div id="tri_row">
<?php
     $sql_edu="SELECT 	a.EDU_GPA,
                        d.EM_NAME_TH,
                        c.ED_NAME_TH,
                        e.INS_NAME_TH
                FROM	PER_EDUCATEHIS a LEFT JOIN 
                        SETUP_EDU_DEGREE c ON a.ED_ID = c.ED_ID LEFT JOIN 
                        SETUP_EDU_MAJOR d ON a.EM_ID = d.EM_ID LEFT JOIN 
                        SETUP_EDU_INSTITUTE e ON a.INS_ID = e.INS_ID
                WHERE	a.EL_ID='7' AND
                        a.PER_ID='".$_GET['PER_ID']."'";
    $exc_edu=$db->query($sql_edu);
    while($row_edu=$db->db_fetch_array($exc_edu)){
    ?>
        <div class="row formSep">
        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาขา</div>
        <div class="col-xs-12 col-md-2"><?php echo text($row_edu['EM_NAME_TH']." ".$row_edu['ED_NAME_TH']); ?></div>	
        <div class="col-xs-12 col-md-1" style="white-space:nowrap;">สถานศึกษา</div>
        <div class="col-xs-12 col-md-2"><?php echo text($row_edu['INS_NAME_TH']); ?></div>
        <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ผลคะแนนรวมโดยเฉลี่ย</div>
        <div class="col-xs-12 col-md-1"><?php echo text(number_format($row_edu['EDU_GPA'],2)); ?></div>
        </div>
    <?php
    }//while
    ?>
</div>
  
<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ปริญญาโท:</div>
</div>
    
<div id="tol_row">
<?php
 $sql_edu="SELECT 	a.EDU_GPA,
                    d.EM_NAME_TH,
                    c.ED_NAME_TH,
                    e.INS_NAME_TH
            FROM	PER_EDUCATEHIS a LEFT JOIN 
                    SETUP_EDU_DEGREE c ON a.ED_ID = c.ED_ID LEFT JOIN 
                    SETUP_EDU_MAJOR d ON a.EM_ID = d.EM_ID LEFT JOIN 
                    SETUP_EDU_INSTITUTE e ON a.INS_ID = e.INS_ID
            WHERE	a.EL_ID='8' AND
                    a.PER_ID='".$_GET['PER_ID']."'";
$exc_edu=$db->query($sql_edu);
while($row_edu=$db->db_fetch_array($exc_edu)){
?>
    <div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">สาขา</div>
    <div class="col-xs-12 col-md-2"><?php echo text($row_edu['EM_NAME_TH']." ".$row_edu['ED_NAME_TH']); ?></div>	
    <div class="col-xs-12 col-md-1" style="white-space:nowrap;">สถานศึกษา</div>
    <div class="col-xs-12 col-md-2"><?php echo text($row_edu['INS_NAME_TH']); ?></div>
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">ผลคะแนนรวมโดยเฉลี่ย</div>
    <div class="col-xs-12 col-md-1"><?php echo text(number_format($row_edu['EDU_GPA'],2)); ?></div>
    </div>
 <?php
}//while
?>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">&nbsp;</div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><strong>ประวัติการเปลี่ยนชื่อ</strong></div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-12" style="white-space:nowrap;">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr class="bgHead">
          <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
          <th><div align="center"><strong>วันที่เปลี่ยน</strong></div></th>
          <th width="35%"><div align="center"><strong>ชื่อ-นามสกุลเดิม (ไทย)</strong></div></th>
          <th width="35%"><div align="center"><strong>ชื่อ-นามสกุลเดิม (อังกฤษ)</strong></div></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i=1;
    $sql_his="SELECT	a.NAMEHIS_LAST_PREFIX_ID,
						a.NAMEHIS_LAST_FIRSTNAME_TH,
						a.NAMEHIS_LAST_MIDNAME_TH,
						a.NAMEHIS_LAST_LASTNAME_TH,
						a.NAMEHIS_LAST_FIRSTNAME_EN,
						a.NAMEHIS_LAST_MIDNAME_EN,
						a.NAMEHIS_LAST_LASTNAME_EN,
						a.NAMEHIS_CHANGEDATE
				FROM	PER_NAMEHIS AS a
                WHERE	a.PER_ID = '".$_GET['PER_ID']."' ";
    $exc_his=$db->query($sql_his);
    while($row_his=$db->db_fetch_array($exc_his)){
    ?>
      <tr>
        <td align="center"><?php echo $i; ?>.</td>
        <td align="center"><?php echo conv_date($row_his['NAMEHIS_CHANGEDATE']); ?></td>
        <td align="center"><?php echo Showname($row_his["NAMEHIS_LAST_PREFIX_ID"],$row_his["NAMEHIS_LAST_FIRSTNAME_TH"],$row_his["NAMEHIS_LAST_MIDNAME_TH"],$row_his["NAMEHIS_LAST_LASTNAME_TH"]); ?></td>
        <td align="center"><?php echo Showname($row_his["NAMEHIS_LAST_PREFIX_ID"],$row_his["NAMEHIS_LAST_FIRSTNAME_EN"],$row_his["NAMEHIS_LAST_MIDNAME_EN"],$row_his["NAMEHIS_LAST_LASTNAME_EN"]); ?></td>
      </tr>
    <?php
        $i++;
    }//while
	?>
      </tbody>
    </table>
    </div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;">&nbsp;</div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-2" style="white-space:nowrap;"><strong>ประวัติการเดินทางไปศึกษา/ฝึกอบรม/ดูงาน/แลกเปลี่ยน</strong></div>
</div>

<div class="row formSep">
    <div class="col-xs-12 col-md-12" style="white-space:nowrap;">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr class="bgHead">
          <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
          <th><div align="center"><strong>โครงการ</strong></div></th>
          <th width="30%"><div align="center"><strong>หลักสุตร/กิจกรรม</strong></div></th>
          <th width="15%"><div align="center"><strong>วันที่</strong></div></th>
          <th width="10%"><div align="center"><strong>ระยะเวลา</strong></div></th>
        </tr>
    </thead>
    <tbody>
    <?php
    //ฝึกอบรม/จริยธรรม/ดูงาน
    $i=1;
    $sql_his="SELECT	b.GEN_SDATE,
						b.GEN_EDATE,
						b.NUM_YEAR,
						b.NUM_MONTH,
						b.NUM_DAY,
						b.ADDRESS_NAME,
						d.PROJECT_NAME_TH,
						a.COURSE_NAME_TH
				FROM	DEV_COURSE AS a INNER JOIN 
						DEV_GEN AS b ON a.COURSE_ID = b.COURSE_ID INNER JOIN 
						DEV_USER_REGIS AS c ON b.GEN_ID = c.GEN_ID INNER JOIN 
						DEV_PROJECT AS d ON d.PROJECT_ID = a.PROJECT_ID
                WHERE	c.PER_ID = '".$_GET['PER_ID']."' ";
    $exc_his=$db->query($sql_his);
    while($row_his=$db->db_fetch_array($exc_his)){
    ?>
      <tr>
        <td align="center"><?php echo $i; ?>.</td>
        <td><?php echo text($row_his['PROJECT_NAME_TH']); ?></td>
        <td><?php echo text($row_his['COURSE_NAME_TH']); ?></td>
        <td align="center"><?php echo conv_date($row_his['GEN_SDATE'])." - ".conv_date($row_his['GEN_EDATE']); ?></td>
        <td align="center"><?php 
        echo ($row_his['NUM_YEAR']>0?$row_his['NUM_YEAR']." ปี ":"");
        echo ($row_his['NUM_MONTH']>0?$row_his['NUM_MONTH']." เดือน ":"");
        echo ($row_his['NUM_DAY']>0?$row_his['NUM_DAY']." วัน ":"");
        ?></td>
        </tr>
    <?php
        $i++;
    }//while

    //แลกเปลี่ยน
    $sql_his="SELECT	a.TOTAL_YEAR,
						a.TOTAL_MONTH,
						a.TOTAL_DATE,
						a.EX_SDATE,
						a.EX_EDATE,
						c.PROJECT_NAME_TH
				FROM	DEV_EX_EXCHANGE AS a INNER JOIN 
						DEV_EX_USER_REGIS AS b ON a.EXCHANGE_ID = b.EXCHANGE_ID INNER JOIN 
						DEV_PROJECT AS c ON a.PROJECT_ID = c.PROJECT_ID
				WHERE	b.PER_ID = '".$_GET['PER_ID']."' ";
    $exc_his=$db->query($sql_his);
    while($row_his=$db->db_fetch_array($exc_his)){
    ?>
      <tr>
        <td align="center"><?php echo $i; ?>.</td>
         <td><?php echo text($row_his['PROJECT_NAME_TH']); ?></td>
        <td align="center">&nbsp;</td>
        <td align="center"><?php echo conv_date($row_his['EX_SDATE'])." - ".conv_date($row_his['EX_SDATE']); ?></td>
        <td align="center"><?php 
        echo ($row_his['TOTAL_YEAR']>0?$row_his['TOTAL_YEAR']." ปี ":"");
        echo ($row_his['TOTAL_MONTH']>0?$row_his['TOTAL_MONTH']." เดือน ":"");
        echo ($row_his['TOTAL_DATE']>0?$row_his['TOTAL_DATE']." วัน ":"");
        ?></td>
        </tr>
    <?php
        $i++;
    }//while
    ?>
      </tbody>
    </table>
    </div>
</div>

<div class="table-responsive"></div>
<?php $db->db_close();?>