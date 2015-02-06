<?php
$path = "../../";
include($path."include/config_header_top.php");
$SPPOS_ID = $_GET['SPPOS_ID'];

$sql ="SELECT d.SAPA_YEAR ,d.SAPA_NUMBER,c.SS_FIRSTNAME_TH, c.SS_LASTNAME_TH ,a.SP_FIRSTNAME_TH, a.SP_LASTNAME_TH,
a.SPMAN_SALARY, a.SPMAN_SALARY_POSITION,  a.ASSIGN_SDATE, a.RESIGN_EDATE, a.PREFIX_ID
FROM SP_MANPOWER a  
LEFT JOIN SS_SAPA_POSITION b ON a.SSP_ID = b.SSP_ID
LEFT JOIN SS_PROFILE c       ON b.SSP_ID = c.SS_ID 
LEFT JOIN SS_SETUP_SAPA d    ON b.SAPA_ID = d.SAPA_ID
WHERE  SPPOS_ID = '".$SPPOS_ID."'
order by d.SAPA_YEAR";
$query = $db->query($sql);
$nums = $db->db_num_rows($query);
?>
<table align="center" class="table table-bordered table-striped table-hover table-condensed" id="tb_data">
    <thead>
        <tr class="bgHead">
            <th width="12%"><div align="center"><strong>สภาชุดที่</strong></div></th>
            <th width="20%"><div align="center"><strong>สังกัดบุคคล/หน่วยงาน</strong></div></th>                                                            
            <th width="18%"><div align="center"><strong>ชื่อ - สกุล</strong></div></th>
            <th width="10%"><div align="center"><strong>เงินเดือน</strong></div></th>
            <th width="15%"><div align="center"><strong>เงินประจำตำแหน่ง</strong></div></th>                                                            
            <th width="15%"><div align="center"><strong>วันที่เข้ารับตำแหน่ง</strong></div></th>
            <th width="15%"><div align="center"><strong>วันที่พ้นตำแหน่ง</strong></div></th>
        </tr>
    </thead>
    <tbody >
	<?php
    if($nums > 0){
        while($rec = $db->db_fetch_array($query)){
			//echo $rec['SS_LASTNAME_TH'];
			$ssp_name = Showname("",$rec["SS_FIRSTNAME_TH"],"",$rec["SS_LASTNAME_TH"]);
            ?>
            <tr>
                <td align="center"><?php echo "ชุดที่ ".text($rec['SAPA_NUMBER'])."<br>พ.ศ. ".text($rec['SAPA_YEAR']); ?></td>
                <td><?php echo 	$ssp_name; ?></td>
                <td><?php echo text($rec['SP_FIRSTNAME_TH'])." ".text($rec['SP_LASTNAME_TH']); ?></td>
                <td align="right"><?php echo number_format($rec['SPMAN_SALARY']); ?></td>
                <td align="right"><?php echo number_format($rec['SPMAN_SALARY_POSITION']); ?></td>
                <td><?php echo conv_date($rec['ASSIGN_SDATE'],'short'); ?></td>
                <td><?php echo conv_date($rec['RESIGN_EDATE'],'short');?></td>
            </tr>
            <?php
        }
    }else{
        echo "<tr><td align=\"center\" colspan=\"7\">ไม่พบข้อมูล</td></tr>";
    }
    ?>
    </tbody>
</table>
<?php $db->db_close();?>