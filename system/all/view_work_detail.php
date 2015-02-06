<?php
$path = "../../";
include($path."include/config_header_top.php");
$PER_ID = $_GET['PER_ID'];
$POSMOVE_ID = $_GET['POSMOVE_ID'];

$field = " * ";
$table = "POSITION_MOVEUP ";
$pk_id = "POSMOVE_ID";
$wh = " 1=1 AND DELETE_FLAG = '0' AND POSMOVE_PER_ID = '".$PER_ID."' AND POSMOVE_ID != '".$POSMOVE_ID."'";
$orderby=" order by POSMOVE_ID DESC";

$sql = "select ".$field." from ".$table." where ".$wh.$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
?>
<table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
    <thead>
        <tr class="bgHead">
            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
            <th width="20%"><div align="center"><strong>ผลงาน</strong></div></th>                                                            
            <th width="20%"><div align="center"><strong>รายละเอียด</strong></div></th>
            <th width="10%"><div align="center"><strong>ไฟล์แนบ</strong></div></th>
        </tr>
    </thead>
    <tbody >
	<?php
    if($nums > 0){
        $i = 1;
        while($rec = $db->db_fetch_array($query)){
			$download = (trim($rec['INNOVATION_FILE']) != '') ? "<a data-toggle=\"modal\" class=\"btn btn-default btn-xs\" data-backdrop=\"static\" href=\"".$path."fileupload/file_placement/".trim($rec['INNOVATION_FILE'])."\"><span class=\"glyphicon glyphicon-download\"></span> Download File</a> " : "";
            ?>
            <tr>
                <td align="center"><?php echo $i;?>.</td>
                <td><?php echo text($rec['INNOVATION_NAME']);?></td>
                <td><?php echo text($rec['INNOVATION_DESC']);?></td>
                <td><?php echo $download;?></td>
            </tr>
            <?php
            $i++;
        }
    }else{
        echo "<tr><td align=\"center\" colspan=\"4\">ไม่พบข้อมูล</td></tr>";
    }
    ?>
    </tbody>
</table>
<?php $db->db_close();?>