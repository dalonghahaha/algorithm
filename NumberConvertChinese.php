<?php
$number = 2000105;
echo strval($number)."\r\n";
echo ConvertChinese($number);

/**
 * 13位以内整数转中文显示
 */
function ConvertChinese($number){
	if(strlen(strval($number)) > 13){
		return false;
	}
	$chnNumber = ['零','一','二','三','四','五','六','七','八','九'];
	$chnSection = ['','万','亿','万'];
	$chnUnit = ['','十','百','千'];
	$result = '';
	while($number>0){
		$Section[] = fmod($number,10000);
		$number = intval($number/10000);
	}
	for($i=count($Section)-1;$i>=0;$i--){
		//全0则跳出，直接继续
		if($Section[$i] == 0){
			continue;
		}
		$str_section = strval($Section[$i]);
		$section_result = '';
		//不足四位数字则先补0
		if(strlen($str_section) == 3){
			$str_section='0'.$str_section;
		}else if(strlen($str_section) == 2){
			$str_section='00'.$str_section;
		}else if(strlen($str_section) == 1){
			$str_section='000'.$str_section;
		}
		for($j=0;$j<strlen($str_section);$j++){
			//单位结果
			$index = intval(substr($str_section,$j,1));
			//是否需要补"零"判断
			if($index > 0){
				$unit_result = $chnNumber[$index].$chnUnit[(3-$j)];
				if($j>0 && intval(substr($str_section,$j-1,1)) == 0 && (strlen($section_result) > 0 || strlen($result) >0)){
					$unit_result = '零'.$unit_result;
				}
				$section_result.=$unit_result;
			}
		}
		$result.=$section_result.$chnSection[$i];
	}
	return $result;
}