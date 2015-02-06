<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$per_by = $_REQUEST['per_by'];
$s_name_th = $_REQUEST['s_name_th'];
$PT_ID = $_REQUEST['PT_ID'];
$ORG_ID_3 = $_REQUEST['ORG_ID_3'];
$ORG_ID_4 = $_REQUEST['ORG_ID_4'];

if(!empty($s_name_th)  && ($s_name_th!='undefined')){
   $ConName.=" AND (a.PER_FIRSTNAME_TH LIKE '%".ctext(trim($s_name_th))."%' OR a.PER_MIDNAME_TH LIKE '%".ctext(trim($s_name_th))."%' OR a.PER_LASTNAME_TH LIKE '%".ctext(trim($s_name_th))."%') ";
}
if(!empty($PT_ID)  && ($PT_ID!='undefined')){
   $ConName.=" AND (a.PT_ID = '".ctext(trim($PT_ID))."' ) ";
}
if(!empty($ORG_ID_3)  && ($ORG_ID_3!='undefined')){
   $ConName.=" AND (a.ORG_ID_3 = '".ctext(trim($ORG_ID_3))."' ) ";
}
if(!empty($ORG_ID_4)  && ($ORG_ID_4!='undefined')){
   $ConName.=" AND (a.ORG_ID_4 = '".ctext(trim($ORG_ID_4))."' ) ";
}

$field="a.*,
		b.ORG_NAME_TH AS ORG3,
		c.ORG_NAME_TH AS ORG4,
		d.LINE_NAME_TH,
		e.LEVEL_NAME_TH ";
		
$table="PER_PROFILE a LEFT JOIN 
		SETUP_ORG b ON a.ORG_ID_3 = b.ORG_ID LEFT JOIN 
		SETUP_ORG c ON a.ORG_ID_4 = c.ORG_ID LEFT JOIN 
		SETUP_POS_LINE d ON d.LINE_ID = a.LINE_ID LEFT JOIN 
		SETUP_POS_LEVEL e ON e.LEVEL_ID = a.LEVEL_ID";
		
$pk_id="a.PER_ID";
$wh=" 1=1 ".$ConName;
$orderby="ORDER BY a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH asc";
$notin=$wh." AND ".$pk_id." NOT IN (SELECT TOP ".($goto/2)." ".$pk_id." FROM ".$table." WHERE ".$wh." ".$orderby.") ".$orderby;

$SQL = "SELECT TOP 10 ".$field." FROM ".$table." WHERE ".$notin;
$SQLALL = "SELECT * FROM ".$table." WHERE ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
$nums=$db->db_num_rows($exc);
?>
<input type="hidden" name="per_by" value="<?php echo $per_by;?>">
<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="name_serch" name="name_serch" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name_th;?>" ></div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-10" align="center">
    <button type="button" class="btn btn-primary" onClick="search_pop('form_set_penalty_form.php','show_display',$('#name_serch').val());">ค้นหา</button>
    </div>
</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center">เลือก</div></th>
				<th width="30%"><div align="center"><strong><?php echo $arr_txt['name'];?></strong></div></th>
                <th  width="20%"><div align="center"><strong>ตำแหน่ง</strong></div></th>
                <th  width="20%"><div align="center"><strong>ระดับ</strong></div></th>
                <th width="25%"><div align="center"><strong>กลุ่มงาน</strong></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($nums > 0){
				$i=1;
				while($rec = $db->db_fetch_array($exc)){
					//func แสดงข้อมูลชื่อ
					$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
		?>
			<tr>
				<td align="center">
                <input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['PER_ID'];?>" onClick="set_eva_per('<?php echo $rec['PER_ID'];?>','<?php echo $name;?>','<?php echo text($rec['LINE_NAME_TH']);?>','<?php echo text($rec['LEVEL_NAME_TH']);?>','<?php echo text($rec['ORG3']);?>','<?php echo text($rec['ORG4']);?>','<?php echo $per_by;?>');"></td>
				<td align="left"><?php echo $name; ?></td>
                <td align="left"><?php echo text($rec['LINE_NAME_TH']);?></td>
                <td align="left"><?php echo text($rec['LEVEL_NAME_TH']);?></td>
                <td align="left"><?php echo text($rec['ORG4']);?></td>
				
			</tr>
		<?php 
					$i++;
				}//while
			}else{
				echo "<tr><td align=\"center\" colspan=\"3\">".$arr_txt['data_not_found']."</td></tr>";
			}//if
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>