<?php
$path = "../../";
include($path."include/config_header_top.php");
$PER_ID = $_GET['PER_ID'];

$field = " * ";
$table = "PENALTY_PETITION_FORM a
INNER JOIN SETUP_PREFIX b on a.INFORM_TO_PREFIX_ID = b.PREFIX_ID
INNER JOIN SETUP_CRIME_MAIN c on a.INFORM_CRIME_ID = c.CRIME_ID
INNER JOIN SETUP_PUNNISH e on e.PUNISH_ID = a.KR_PUNISH_ID";
$pk_id = "a.PENALTY_ID";
$wh = " 1=1 AND a.DELETE_FLAG = '0' AND a.PENALTY_STATUS = '4' AND INFORM_TO_PER_ID = '".$PER_ID."'";
$orderby=" order by a.INFORM_DATE DESC,a.PENALTY_ID ASC";

$sql = "select ".$field." from ".$table." where ".$wh.$orderby;
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
?>
<table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
    <thead>
        <tr class="bgHead">
            <th width="5%"><div align="center"><strong>ลำดับ</strong></div></th>
            <th width="8%"><div align="center"><strong>ปี พ.ศ.</strong></div></th>                                                            
            <th width="10%"><div align="center"><strong>จำนวนวันที่ปกติ</strong></div></th>
            <th width="10%"><div align="center"><strong>จำนวนวันที่มาสาย</strong></div></th>
            <th width="10%"><div align="center"><strong>จำนวนวันที่ลาทั้งหมด</strong></div></th>
        </tr>
    </thead>
    <tbody >
	<?php
    if($nums > 0){
        $i = 1;
        while($rec = $db->db_fetch_array($query)){
            ?>
            <tr>
                <td><?php echo $i;?>.</td>
                <td><?php //echo text($rec['CRIME_NAME_TH']);?></td>
                <td><?php //echo text($rec['PUNISH_NAME_TH']);?></td>
                <td><?php //echo $rec['KR_PERCENTAGE'];?>&nbsp;</td>
                <td><?php //echo conv_date($rec['RESULT_SDATE'],'short');?></td>
            </tr>
            <?php
            $i++;
        }
    }else{
        echo "<tr><td align=\"center\" colspan=\"5\">ไม่พบข้อมูล</td></tr>";
    }
    ?>
    </tbody>
</table>
<?php $db->db_close();?>