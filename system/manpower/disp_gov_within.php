<?php
session_start();
$path = "../../";
include($path . "include/config_header_top.php");

$link = "r=home&menu_id=" . $menu_id . "&menu_sub_id=" . $menu_sub_id;  /// for mobile
$paramlink = url2code($link);

$filter = "";

$sql = "
with recursive_member as (
	select a.ORG_ID , a.ORG_PARENT_ID , a.ORG_NAME_TH , b.OL_SEQ, a.ACTIVE_STATUS, a.ORG_SEQ
	from SETUP_ORG a
	left join SETUP_ORG_LEVEL b on a.OL_ID = b.OL_ID
	where ORG_ID = '15' AND a.DELETE_FLAG = '0'
	
	union all
	
	select a.ORG_ID , a.ORG_PARENT_ID , a.ORG_NAME_TH , b.OL_SEQ, a.ACTIVE_STATUS, a.ORG_SEQ
	from SETUP_ORG a
	inner join SETUP_ORG_LEVEL b on a.OL_ID = b.OL_ID
	inner join recursive_member c on a.ORG_PARENT_ID = c.ORG_ID
	where a.DELETE_FLAG = '0'
)
select * from recursive_member order by case when ORG_SEQ is null then 1 else 0 end, ORG_SEQ";



$query = $db->query($sql);
$nums = $db->db_num_rows($query);
$arrList = array();
while ($rec = $db->db_fetch_array($query)) {
    $rec = array_change_key_case($rec, CASE_LOWER);

    $arr[] = array("org_id" => $rec["org_id"], "org_parent_id" => $rec["org_parent_id"]);
    $arrData[$rec["org_id"]] = array("name" => text($rec["org_name_th"]), "status"=>$rec['active_status']);
}

$arrList = create_array(405, $arr);

function create_array($number, $data) {
    $result = array();
    foreach ($data as $row) {
        if ($row['org_parent_id'] == $number) {
            $result[$row['org_id']] = create_array($row['org_id'], $data);
        }
    }
    return $result;
}

function recursive_list($arr, $seq,$db) {
    global $arrData;
    foreach ($arr as $key => $arrVal) {

        $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('" . $key . "');\">".$img_edit." แก้ไข</a> ";
        $edit1 = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData1('" . $key . "');\"><span class=\"glyphicon glyphicon-home\"></span> ที่อยู่</a> ";
        if ($seq > 1) {
            //$delete = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"deleteData('" . $key . "');\">".$img_del." ลบ</a> ";
            //$delete = "";
            $sql_sub= "SELECT ORG_PARENT_ID FROM SETUP_ORG WHERE ORG_PARENT_ID = '".$key."' AND DELETE_FLAG = '0'";
            $sql_form =  $db->query($sql_sub);
            //$data_sub=$db->db_fetch_array($sql_form);
			$num_sub = $db->db_num_rows($sql_form);
		    if($num_sub == 0){
                $delete = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"deleteData('" . $key . "');\">".$img_del." ลบ</a> ";
		    }
            if ($seq == '3'){
                $addSub = "";
            } else { 
                $addSub = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"addData('" . $key . "', '" . $seq . "');\"><span class=\"glyphicon glyphicon-plus\"></span> เพิ่ม</a> ";
            }
        }
		$status = ($arrData[$key]["status"] == '1') ? "ใช้งาน" : "ไม่ใช้งาน";
		if($seq == 2){
        echo "
		<tbody>
		<tr>
			<th bgcolor=\"#FFFFFF\" style=\"padding-left:" . (20 * $seq) . "px;\">" . $arrData[$key]["name"] . "</th>
			<td align=\"center\" bgcolor=\"#FFFFFF\">".$status."</td>
			<td align=\"center\" bgcolor=\"#FFFFFF\" >" . $addSub . $edit . $edit1 . $delete . "</td>
		</tr>
		";
		}else{
		echo "
		<tr class='sub'>
			<td bgcolor=\"#FFFFFF\" style=\"padding-left:" . (20 * $seq) . "px;\">" . $arrData[$key]["name"] . "</td>
			<td align=\"center\" bgcolor=\"#FFFFFF\">".$status."</td>
			<td align=\"center\" bgcolor=\"#FFFFFF\" >" . $addSub . $edit . $edit1 . $delete . "</td>
		</tr>
		";
		}
		
        if (count($arrVal) > 0) {
            recursive_list($arrVal, $seq + 1,$db);
        }
    }
	echo "</tbody>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="language" content="en" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>ระบบบริหารจัดการสารสนเทศด้านทรัพยากรบุคคล</title>
        <link href="<?php echo $path; ?>css/main.css" rel="stylesheet">
        <link href="<?php echo $path; ?>images/splashy/splashy.css" rel="stylesheet">
        <link href="<?php echo $path; ?>bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $path; ?>bootstrap/css/bootstrap-theme.css" rel="stylesheet">
        <link href="<?php echo $path; ?>bootstrap/css/bootstrap-modal.css" rel="stylesheet">
        <link href="<?php echo $path; ?>bootstrap/css/chosen.css" rel="stylesheet">
        <script src="<?php echo $path; ?>bootstrap/js/jquery.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/transition.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/holder.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/collapse.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/dropdown.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/modal.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/carousel.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/respond.min.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/html5shiv.js"></script>
        <script src="<?php echo $path; ?>bootstrap/js/chosen.jquery.js"></script>
        <script src="<?php echo $path; ?>js/func.js"></script>
        <script src="js/disp_gov_within.js?<?php echo rand(); ?>"></script>
    </head>
    <body>
        <div class="container-full">
            <div>
			<?php include($path . "include/header.php"); ?>
            </div>
            <div>
                <?php include($path . "include/menu.php"); ?>
            </div>
                <div class="col-xs-12 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="index.php?<?php echo $paramlink; ?>">หน้าแรก</a></li>
                        <li class="active"><?php echo showMenu($menu_sub_id); ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-12" id="content">
                    <div class="groupdata" >
                        <form id="frm-search" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input name="proc" type="hidden" id="proc" value="<?php echo $proc; ?>">
                            <input name="menu_id" type="hidden" id="menu_id" value="<?php echo $menu_id; ?>">
                            <input name="menu_sub_id" type="hidden" id="menu_sub_id" value="<?php echo $menu_sub_id; ?>">
                            <input name="page" type="hidden" id="page" value="<?php echo $page; ?>">
                            <input name="page_size" type="hidden" id="page_size" value="<?php echo $page_size; ?>">
                            <input name="org_parent_id" type="hidden" id="org_parent_id">
                            <input name="org_id" type="hidden" id="org_id">
                            <input name="org_id1" type="hidden" id="org_id1">
                            <input name="seq" type="hidden" id="seq">
                            
                          
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover collapsible">
                                        <thead>
                                            <tr class="bgHead">
                                                <th width="70%"><div align="center"><strong>ชื่อหน่วยงาน</strong></div></th>
                                                <th width="10%"><div align="center"><strong>สถานะการใช้งาน</strong></div></th>
                                                <th width="20%"><div align="center"><strong>จัดการข้อมูล</strong></div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
                                        if (count($arrList) > 0) {
                                            foreach ($arrList as $key => $arrVal) {
                                                $addSub = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"addData('" . $key . "', '" . $seq . "');\"><span class=\"glyphicon glyphicon-plus\"></span> เพิ่ม</a> ";
                                                $edit = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData('" . $key . "');\">".$img_edit." แก้ไข</a> ";
                                                $edit1 = "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"javascript:void(0);\" onClick=\"editData1('" . $key . "');\"><span class=\"glyphicon glyphicon-home\"></span> ที่อยู่</a> ";
												$status = ($arrData[$key]["status"] == '1') ? "ใช้งาน" : "ไม่ใช้งาน";
												?>
                                                <tr >
                                                    <td bgcolor="#FFFFFF"><strong><?php echo $arrData[$key]["name"]; ?></strong></td>
                                                    <td align="center" bgcolor="#FFFFFF" ><?php echo $status; ?></td>
                                                    <td align="center" bgcolor="#FFFFFF" ><?php echo $addSub . $edit .$edit1; ?></td>
                                                </tr>
												<?php
                                                if (count($arrVal) > 0) {
                                                    recursive_list($arrVal, 2,$db);
                                                }
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                        </form>
                    </div>
                  </div>
            <div style="text-align:center; bottom:0px;"><?php include($path . "include/footer.php"); ?></div>
        </div> 
  
    </body>
</html>
