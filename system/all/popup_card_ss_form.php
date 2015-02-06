<?php
$path = "../../";
include($path."include/config_header_top.php");

$page = $_REQUEST['page'];
$s_name_th = $_REQUEST['s_name_th'];
$PT_ID = $_REQUEST['PT_ID'];
$ORG_ID_3 = $_REQUEST['ORG_ID_3'];
$ORG_ID_4 = $_REQUEST['ORG_ID_4'];

if(!empty($s_name_th)  && ($s_name_th!='undefined')){
   $ConName.=" AND (SS_FIRSTNAME_TH LIKE '%".ctext(trim($s_name_th))."%' OR SS_MIDNAME_TH LIKE '%".ctext(trim($s_name_th))."%' OR SS_LASTNAME_TH LIKE '%".ctext(trim($s_name_th))."%') ";
}
/*if(!empty($PT_ID)  && ($PT_ID!='undefined')){
   $ConName.=" AND (a.PT_ID = '".ctext(trim($PT_ID))."' ) ";
}
if(!empty($ORG_ID_3)  && ($ORG_ID_3!='undefined')){
   $ConName.=" AND (a.ORG_ID_3 = '".ctext(trim($ORG_ID_3))."' ) ";
}
if(!empty($ORG_ID_4)  && ($ORG_ID_4!='undefined')){
   $ConName.=" AND (a.ORG_ID_4 = '".ctext(trim($ORG_ID_4))."' ) ";
}*/
?>

<?
$field="*";
$table="SS_PROFILE";
$pk_id="SS_ID";
$wh=" 1=1 ".$ConName;
$orderby="order by SS_FIRSTNAME_TH, SS_MIDNAME_TH, SS_LASTNAME_TH asc";
$notin=$wh." and ".$pk_id." not in (select top ".($goto/2)." ".$pk_id." from ".$table." where ".$wh." ".$orderby.") ".$orderby;

$SQL = "select top 10 ".$field." from ".$table." where ".$notin;
$SQLALL = "select * from ".$table." where ".$wh;
list($pagination,$exc,$total_pages)=$db->pageTable($SQL, $SQLALL, $page, "page", $ConPOST,$s_file,$span);
//echo $ConPOST.">>>";
$nums=$db->db_num_rows($exc);
?>

<div class="row">
	<div class="col-xs-12 col-md-4"><?php echo $arr_txt['name'];?></div>
	<div class="col-xs-12 col-md-6"><input type="text" id="name_serch" name="name_serch" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name_th;?>" ></div>
</div>
<div class="row">
<div class="col-xs-12 col-md-10" align="center">
<button type="button" class="btn btn-primary" onClick="search_pop('popup_card_ss_form.php','show_display',$('#name_serch').val());">ค้นหา</button>
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
					$name=Showname($rec["PREFIX_ID"],$rec["SS_FIRSTNAME_TH"],$rec["SS_MIDNAME_TH"],$rec["SS_LASTNAME_TH"]);
		?>
			<tr>
				<td align="center">
                <input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['SS_ID'];?>" onClick="return_name('<?php echo $rec['SS_ID'];?>','<?php echo $name;?>');">
                </td>
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