<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$name_serch = $_REQUEST['name_serch'];
$PT_ID = $_REQUEST['PT_ID'];
$ORG_ID_3 = $_REQUEST['ORG_ID_3'];
$ORG_ID_4 = $_REQUEST['ORG_ID_4'];
$tb_id = $_REQUEST['tb_id'];

if(!empty($name_serch)  && ($name_serch!='undefined')){
   $ConName.=" AND (a.PER_FIRSTNAME_TH LIKE '%".ctext(trim($name_serch))."%' OR a.PER_MIDNAME_TH LIKE '%".ctext(trim($name_serch))."%' OR a.PER_LASTNAME_TH LIKE '%".ctext(trim($name_serch))."%') ";
}
$field="*";
$table="PER_PROFILE a";
$pk_id="a.PER_ID";
$wh=" ACTIVE_STATUS = 1 ".$ConName;
$orderby="order by a.PER_FIRSTNAME_TH, a.PER_MIDNAME_TH, a.PER_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
//echo $ConPOST.">>>";
$nums=$db->db_num_rows($exc);
?>

<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="name_serch" name="name_serch" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $name_serch;?>" ></div>
</div>
<div class="row">
<div class="col-xs-12 col-md-10" align="center">
<button type="button" class="btn btn-primary" onClick="search_pop('form_user_placement_app_form.php','show_display',$('#name_serch').val(), '<?php echo $tb_id;?>');">ค้นหา</button>
</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center">เลือก</div></th>
				<th width="45%"><div align="center"><strong><?php echo $arr_txt['name'];?></strong></div></th>
			</tr>
		</thead>
		<tbody>
		<?php
		if($nums > 0){
			$i=1;
			while($rec = $db->db_fetch_array($exc)){
				//func แสดงข้อมูลชื่อ
				$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
				$idcard = $rec['PER_IDCARD'];
				?>
                <tr>
                    <td align="center">
                    <input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['PER_ID'];?>" onClick="return_name('<?php echo $rec['PER_ID'];?>','<?php echo $name;?>',<?php echo $tb_id; ?>,'<?php echo $idcard;?>', '<?php echo $rec['POSTYPE_ID'];?>');"></td>
                    <td align="left"><?php echo $name; ?></td>
                </tr>
				<?php 
				$i++;
			}
		}else{
			echo "<tr><td align=\"center\" colspan=\"3\">ไม่พบข้อมูล</td></tr>";
		}
		?>
		</tbody>
	</table>
</div>
<div><?php echo $pagination;?></div>
<?php $db->db_close();?>