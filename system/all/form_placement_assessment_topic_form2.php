<?php
$path = "../../";
include($path."include/config_header_top.php");
$page = $_REQUEST['page'];
$s_name_th = $_REQUEST['s_name_th'];
$PT_ID = 1;
$org_id_3;

if(!empty($s_name_th)  && ($s_name_th!='undefined')){
   $ConName.=" AND (a.PER_FIRSTNAME_TH LIKE '%".ctext(trim($s_name_th))."%' OR a.PER_MIDNAME_TH LIKE '%".ctext(trim($s_name_th))."%' OR a.PER_LASTNAME_TH LIKE '%".ctext(trim($s_name_th))."%') ";
}

$field=" A.POS_NO,A.PER_IDCARD,A.PER_ID,A.PREFIX_ID,A.PER_FIRSTNAME_TH,A.PER_MIDNAME_TH,A.PER_LASTNAME_TH,A.PER_ID,B.LINE_NAME_TH,C.LEVEL_NAME_TH,D.MANAGE_NAME_TH,E.MT_NAME_TH,F.LG_NAME_TH ,G.TYPE_NAME_TH,A.ORG_ID_3,A.ORG_ID_4";
$table="PER_PROFILE  A
				LEFT JOIN  SETUP_POS_LINE  B ON A.LINE_ID = B.LINE_ID
				LEFT JOIN SETUP_POS_LEVEL C ON A.LEVEL_ID = C.LEVEL_ID
				LEFT JOIN SETUP_POS_MANAGE D ON A.MANAGE_ID = D.MANAGE_ID
				LEFT JOIN SETUP_POS_MANAGE_TYPE E ON A.MT_ID = E.MT_ID 
				LEFT JOIN SETUP_POS_TYPE G ON A.TYPE_ID = G.TYPE_ID
				LEFT JOIN SETUP_ORG H ON A.ORG_ID_3 = H.ORG_ID 
				LEFT JOIN SETUP_POS_LINE_GROUP F ON F.LG_ID = A.LG_ID";
$pk_id="a.PER_ID";
$wh=" 1=1 AND  ORG_ID_3 = '".$org_id_3."' ".$ConName;
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
	<div class="col-xs-12 col-md-6"><input type="text" id="name_serch" name="name_serch" class="form-control" placeholder="<?php echo $arr_txt['name'];?>" value="<?php echo $s_name_th;?>" ></div>
</div>
<div class="row">
<div class="col-xs-12 col-md-10" align="center">
<button type="button" class="btn btn-primary" onClick="search_pop('form_placement_assessment_topic.php','show_display2',$('#name_serch').val());">ค้นหา</button>
</div>
</div>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<thead>
			<tr class="info">
				<th width="5%"><div align="center">เลือก</div></th>
				<th width="20%"><div align="center"><strong><?php echo $arr_txt['name'];?></strong></div></th>
				<th width="34%"><div align="center"><strong>ตำแหน่ง</strong></div></th>
            </tr>
		</thead>
		<tbody>
		<?php
		if($nums > 0){
			$i=1;
			while($rec = $db->db_fetch_array($exc)){
				//func แสดงข้อมูลชื่อ
				$name=Showname($rec["PREFIX_ID"],$rec["PER_FIRSTNAME_TH"],$rec["PER_MIDNAME_TH"],$rec["PER_LASTNAME_TH"]);
				
				$position = ' ประเภทตำแหน่ง: '.text($rec['TYPE_NAME_TH']);
				$position .= '<br>ระดับ : '.text($rec['LEVEL_NAME_TH']);
				$position .= '<br>ตำแหน่งทางการบริหาร : '.text($rec['MANAGE_NAME_TH']);
				$position .= '<br>สำนัก/กลุ่ม : '.get_org_name($rec['ORG_ID_3']);
				$position .= '<br>กลุ่มงาน : '.get_org_name($rec['ORG_ID_4']);
	
				?>
                
                <tr>
                   
                      <td align="center">
                    <input type="radio" id="chk<?php echo $i;?>" name="chk" value="<?php echo $rec['PER_ID'];?>" onClick="return_name2('<?php echo $rec['PER_ID'];?>','<?php echo $name;?>','<?php echo get_idCard($rec['PER_IDCARD']);?>' ,'<?php echo text($rec['TYPE_NAME_TH']);?>' ,'<?php echo text($rec['LEVEL_NAME_TH']);?>','<?php echo text($rec['LG_NAME_TH']);?>','<?php echo text($rec['LINE_NAME_TH']);?>' , '<?php echo text($rec['MT_NAME_TH']);?>','<?php echo text($rec['MANAGE_NAME_TH']);?>','<?php echo get_org_name($rec['ORG_ID_3']); ?>','<?php echo get_org_name($rec['ORG_ID_4']);?>')"></td>
                    <td align="left"><?php echo $name; ?></td>
                    <td align="left"><?php echo $position;?></td>
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