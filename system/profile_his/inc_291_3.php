<?php
 
    for($i=1;$i<=20;$i++){ 
	
	    $title_name = $csv_tite_name3[$i]['name'];
	    if(($i==11)||($i==13)){
		   $title_name = $title_name." ".($AGE_IS_gen-1);
		}
	    if(($i==12)||($i==14)){
		   $title_name = $title_name." ".$AGE_IS_gen;
		}
    	$html_start .= " <th style='  '   ><div align='center'><strong>".$title_name."</strong></div></th>
		";
		 $out_header .= $csv_tite_name3[$i]['name'].","; //cache it.
	} // for 
	    $out_header .= "\r\n";
 
    $html_start .= "</tr>
  </thead>";

        // sql from inc_csv_search.php
		$sql .= "  AND a.POSTYPE_ID = 5 " ;
 
		$query_who = $db->query($sql ); 
		 $list_csv = array();
		 while($rec1 = $db->db_fetch_array($query_who)){
					$PER_ID = (int)$rec1['PER_ID'];
					$POS_STATUS = (int)$rec1['POS_STATUS'];
					$LINE_NAME_TH = text($rec1['LINE_NAME_TH']);
					$PER_DATE_LEVEL = conv_date($rec1['PER_DATE_LEVEL'],'short');   
					$PER_DATE_POSITION = conv_date($rec1['PER_DATE_POSITION'],'short');
	
 
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
					
					$PER_DATE_BIRTH = conv_date($rec1['PER_DATE_BIRTH'],'short');
					$PER_DATE_ENTRANCE = conv_date($rec1['PER_DATE_ENTRANCE'],'short');
					$PER_DATE_RETIRE = conv_date($rec1['PER_DATE_RETIRE'],'short');
					
					$PREFIX_SHORTNAME_TH = text($rec1['PREFIX_NAME_TH']);
					
					$do_org_shortname = text($rec1['do_org_shortname']);
					$frame_org_name3 = text($rec1['frame_org_name3']);
					
					$current_level_name = text($rec1['current_level_name']);
					
					 // * AGE_IS *//
					 // 27 : เงินเดือนในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.)
					 $sql27 = " select PER_ID, SALARY, COM_SDATE from PER_SALARYHIS   where   COM_SDATE between convert(datetime,'10/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'03/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_27 = $db->query($sql27); 
             		 $rec27 = $db->db_fetch_array($query_27);
					 $search27_salary = number_format($rec27['SALARY'],0);
					 // 28 : เงินเดือนในปีงบประมาณ ช่วง 6 เดือนหลัง (1 เม.ย. - 30 ก.ย.)
					 $sql28 =" select PER_ID, SALARY, COM_SDATE from PER_SALARYHIS   where   COM_SDATE between convert(datetime,'04/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'09/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_28 = $db->query($sql28); 
             		 $rec28 = $db->db_fetch_array($query_28);
					 $search28_salary = number_format($rec28['SALARY'],0);
					 
					 $sql29 = " select    SALHIS_TYPE, SALHIS_UP  from PER_SALARYHIS  
                                WHERE    ACTIVE_STATUS = 1  and SALHIS_TYPE = 1  AND    COM_SDATE between convert(datetime,'10/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'03/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_29 = $db->query($sql29); 
             		 $rec29 = $db->db_fetch_array($query_29);
					 $search29_salary = number_format($rec29['SALHIS_UP'],5);
 
					 $sql30 ="select    SALHIS_TYPE, SALHIS_UP  from PER_SALARYHIS  
                                WHERE    ACTIVE_STATUS = 1  and SALHIS_TYPE = 1  AND      COM_SDATE between convert(datetime,'04/01/".($AGE_IS_gen-1)."') 
					            AND convert(datetime,'09/30/".$AGE_IS_gen."') 
                                AND PER_ID = '".$PER_ID."' AND SALARY > 0  ORDER BY COM_SDATE DESC  ";
					 $query_30 = $db->query($sql30); 
             		 $rec30 = $db->db_fetch_array($query_30);
					 $search30_salary = number_format($rec30['SALHIS_UP'],5);
					
					 
			     $list_csv[$start_no] = array('1'=>number_format($start_no), // ลำดับ
											  '2'=> $id_card,
											  '3'=> $gender,   
											  '4'=> $PREFIX_SHORTNAME_TH, // คำนำ   
											  '5'=> $firstname, // ชื่อ
											  '6'=> $lastname, // นามสกุล 
											  '7'=> $PER_DATE_BIRTH, // วันเกิด พ.ศ.
											  '8'=> $PER_DATE_ENTRANCE,     // วันบรรจุ พ.ศ.
											  '9'=>  $PER_DATE_RETIRE,  //  วันเกษียณ พ.ศ.
											  '10'=> $PER_DATE_LEVEL,   // เข้าสู่ระดับปัจจุบัน
											  '11'=> $search27_salary,   // ค่าจ้างในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.)  
											  '12'=> $search28_salary,   // ค่าจ้างในปีงบประมาณ ช่วง 6 เดือนหลัง (1 เม.ย. - 30 ก.ย.)   
											  '13'=> $search29_salary,   // ขั้นในปีงบประมาณ ช่วง 6 เดือนแรก (1 ต.ค.- 30 มี.ค.)   
											  '14'=> $search30_salary,   // ขั้นในปีงบประมาณ ช่วง 6 เดือนหลัง  (1 เม.ย. - 30 ก.ย.)     
											  '15'=> $pos_no,  // เลขที่ตำแหน่ง
											  '16'=> $LINE_NAME_TH, // ตำแหน่งตามระบบใหม่    
											  '17'=> $current_level_name,    // ระดับ
											  '18'=> $type_name,    // กลุ่มงาน
											  '19'=> $do_org_shortname,   // สังกัดปฏิบัติ
											  '20'=> $frame_org_name3    // สังกัดกรอบ
						 
											  );
		 
		 
 		$html  .= "<tr  style='height:0.7cm;'> ";
		    for($i=1;$i<=20;$i++){ 
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