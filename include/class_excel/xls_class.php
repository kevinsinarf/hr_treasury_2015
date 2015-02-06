<?php
	class xlsControl{
		var $xls='';
		function xlsControl(){
			global $XLS;
			$this->xls = $XLS;
		}

		function importData($f_name){
			$this->xls->read_file($f_name);
			$All_Excel_Data = $this->xls->workbook->get_workbook_array();
			$Sheet_Num =  count($All_Excel_Data); 
			for($s=0;$s<$Sheet_Num;$s++){

				$Sheet_Name[$s] =   $All_Excel_Data[$s]["SHEET_NAME"];
				$Sheet_Data[$s]  =  $All_Excel_Data[$s]["SHEET_DATA"]; 
			}
			$DataArray =  $Sheet_Data;
			for($i=0;$i<count($Sheet_Num);$i++){
				$numrows = count($DataArray[$i]);
				for($a=0;$a<$numrows;$a++){
					
					foreach ($DataArray[$i][$a] as $key => $value) {
						$CELL[$key] = $value;
					}
					$arraydata[] =  $CELL;
				}
			}
			return $arraydata;
		}
	}
?>