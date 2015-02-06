<?php
 
    for($i=1;$i<=23;$i++){ 
	
	    $title_name = $csv_tite_name2[$i]['name'];
	    if(($i==16)){
		   $title_name = $title_name." ".($AGE_IS_gen-1);
		}
	    if(($i==17)){
		   $title_name = $title_name." ".$AGE_IS_gen;
		}
    	$html_start .= " <th style='  '   ><div align='center'><strong>".$title_name."</strong></div></th>
		";
		 $out_header .= $csv_tite_name2[$i]['name'].","; //cache it.
	} // for 
 
	    $out_header .= "\r\n";
 
	
    $html_start .= "</tr>
  </thead>";
        // sql from inc_csv_search.php
		$sql .= "  AND a.POSTYPE_ID = 3 " ;
 
		
		$query_who = $db->query($sql ); 
		 $list_csv = array();
		 while($rec1 = $db->db_fetch_array($query_who)){
					$PER_ID = (int)$rec1['PER_ID'];
					$POS_STATUS = (int)$rec1['POS_STATUS'];
					if($POS_STATUS==1){ $POS_STATUS_NAME = "ว่าง ไม่มีเงิน";  }
					if($POS_STATUS==2){ $POS_STATUS_NAME = "ว่าง มีเงิน";  }
					if($POS_STATUS==3){ $POS_STATUS_NAME = "มีผู้ถือครอง";  }
					if($POS_STATUS==4){ $POS_STATUS_NAME = "ยุบเลิก";  }
		 
					$pos_no = $rec1['POS_NO'];
					$id_card = get_idCard($rec1['PER_IDCARD']);
					$gender = $rec1['PER_GENDER'];
					$firstname = text($rec1['PER_FIRSTNAME_TH']);
					$lastname = text($rec1['PER_LASTNAME_TH']);
					$type_name = text($rec1['TYPE_NAME_TH']);
				    $LINE_NAME_TH = text($rec1['LINE_NAME_TH']);
					$LEVEL_NAME_TH = text($rec1['LEVEL_NAME_TH']);
					
					$PER_DATE_BIRTH = conv_date($rec1['PER_DATE_BIRTH'],'short');
					$PER_DATE_ENTRANCE = conv_date($rec1['PER_DATE_ENTRANCE'],'short');
					$PER_DATE_RETIRE = conv_date($rec1['PER_DATE_RETIRE'],'short');
					
					$PREFIX_SHORTNAME_TH = text($rec1['PREFIX_NAME_TH']);
					
					$do_org_shortname = text($rec1['do_org_shortname']);
					$frame_org_name3 = text($rec1['frame_org_name3']);
					
					$sql_11 = " select   a.PER_ID , a.COM_SDATE,a.CONTACT_EDATE,a.CONTACT_NO,a.POS_YEAR from PER_POSITIONHIS a 
								 where a.ACTIVE_STATUS = 1 and a.DELETE_FLAG = 0 and a.PER_ID = '".$PER_ID."'
 								order by a.COM_SDATE ASC ";
				   $query_11 = $db->query($sql_11);
             	   $rec11 = $db->db_fetch_array($query_11);
				   $date11 = conv_date($rec11['COM_SDATE'],'short'); 
				   $date12 = conv_date($rec11['CONTACT_EDATE'],'short');
				   $CONTACT_NO = $rec11['CONTACT_NO'];
				   $POS_YEAR = $rec11['POS_YEAR'];
				   
				   $sql_15 = "   select   count(a.PER_ID) as count_contact  from PER_POSITIONHIS a 
								 where a.ACTIVE_STATUS = 1 and a.DELETE_FLAG = 0 and a.PER_ID = '".$PER_ID."' ";
				   $query_15 = $db->query($sql_15);
             	   $rec15 = $db->db_fetch_array($query_15);
				   $count_contact = (int)$rec15['count_contact'];
				   
				   
					 // * AGE_IS *//
					 // 27 : เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.)
					 $sql27 = " select PER_ID, SALARY, COM_SDATE from PER_SALARYHIS   where   COM_SDATE between convert(datetime,'10/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'09/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_27 = $db->query($sql27); 
             		 $rec27 = $db->db_fetch_array($query_27);
					 $search27_salary = number_format($rec27['SALARY'],0);
					 // 28 : เงินเดือนในปีงบประมาณ ช่วง 6 เดือนหลัง (1 เม.ย. - 30 ก.ย.)
					 $sql28 =" select    SALHIS_TYPE, SALHIS_UP  from PER_SALARYHIS  
                                WHERE    ACTIVE_STATUS = 1  and SALHIS_TYPE = 1  AND    COM_SDATE between convert(datetime,'10/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'09/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_28 = $db->query($sql28); 
             		 $rec28 = $db->db_fetch_array($query_28);
					 $search28_salary = number_format($rec28['SALHIS_UP'],5);
					 
			     $list_csv[$start_no] = array('1'=>number_format($start_no), // ลำดับ
				                              '2'=>$pos_no, // เลขที่ตำแหน่ง
											  '3'=> $id_card,
											  '4'=> $gender,   
											  '5'=> $POS_STATUS_NAME,   
											  '6'=> $PREFIX_SHORTNAME_TH, // คำนำ 
											  '7'=> $firstname, // ชื่อ 
											  '8'=> $lastname, // นามสกุล
											  '9'=> $PER_DATE_BIRTH,     // วันเกิด
											  '10'=>$PER_DATE_ENTRANCE,  // วันบรรจุ   
											  '11'=> $date11,   // ระยะเวลาเริ่มจ้าง 
											  '12'=> $date12,      // สิ้นสุดการจ้าง
											  '13'=> $CONTACT_NO,      // เลขที่สัญญาจ้าง
											  '14'=> $POS_YEAR,      // ปีสัญญาจ้าง  
											  '15'=> $count_contact,     // 28_จำนวนครั้งที่ทำสัญญา
											  '16'=> $search27_salary,     // ค่าตอบแทนในรอบปีงบประมาณ (1 ต.ค.)  
											  '17'=> $search28_salary,    // ร้อยละในรอบปีงบประมาณ (1 ต.ค.)  
											  '18'=>  $LINE_NAME_TH,    // ตำแหน่งสายงาน       
											  '19'=> '',   // ด้าน
											  '20'=> $LEVEL_NAME_TH,    // กลุ่มงาน
											  '21'=> '',   // ประเภทภารกิจ
											  '22'=> $do_org_shortname,   // สังกัดปฏิบัติ
											  '23'=> $frame_org_name3    // สังกัดกรอบ
						 
											  );
		 
		 
 		$html  .= "<tr  style='height:0.7cm;'> ";
		    for($i=1;$i<=23;$i++){ 
				switch ($i) {
					case 6:
					case $i>= 10 && $i<=26:
					   $css_do = "RIGHT_TOP";
						break;
					case $i>= 7 && $i<=9:
		 
					   $css_do = "LEFT_TOP";
						break;
					default:
					   $css_do = "CENTER_TOP";
				}
				$html .= "			 <td ".$css_do."  >".$list_csv[$start_no][$i]."</td>
				 ";
			}
 
		$html .= "</tr>";
			 
			$start_no++; 
		 
		 }

  
?> 