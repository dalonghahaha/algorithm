<?php
$status = array(
	'parent' => -1,
	'8' => 8,
	'5' => 0,
	'3' => 0,
	'end' => false,
	'from' => -1,
	'to' => -1,
	'move' => -1,
);
$status_tree = array($status);
$begin_index = 0;
$finish = false;
while (!$finish) {
	build_status_tree($status_tree,$begin_index,$finish);
}

$solution = get_solution($status_tree);

echo count($solution)."个解决方案"."\r\n";

output_solution($solution,$status_tree);

function build_status_tree(&$status_tree,&$begin_index,&$finish){
	$begin = $begin_index;
	$end = count($status_tree);
	$begin_index = count($status_tree);
	for($i = $begin;$i < $end;$i++){
		if($status_tree[$i]['end']){
			continue;
		}
		move($status_tree,$i,'8','5');
		move($status_tree,$i,'8','3');
		move($status_tree,$i,'5','8');
		move($status_tree,$i,'5','3');
		move($status_tree,$i,'3','8');
		move($status_tree,$i,'3','5');
	}
	if(count($status_tree) == $end){
		$finish = true;
	}
}

function move(&$status_tree,$parent,$from_index,$to_index){
	$status=$status_tree[$parent];
	//来源桶为空
	if($status[$from_index] == 0){
		return false;
	}
	//目标桶满水
	if(intval($to_index) == $status[$to_index]){
		return false;
	}
	//目标桶水量
	$to_capacity = intval($to_index) - $status[$to_index];
	//来源桶水量
	$from_capacity = $status[$from_index];

	$new_status['parent'] = $parent;
	if($to_capacity >= $from_capacity) {
		foreach ($status as $key => $value) {
			if($key != $from_index && $key != $to_index && $key != 'parent' && $key != 'from' && $key != 'to'){
				$new_status[$key] = $status[$key];
			}
			if($key == $from_index){
				$new_status[$key] = 0;
			}
			if($key == $to_index){
				$new_status[$key] = $status[$to_index] + $from_capacity;
			}
		}
		$new_status['from'] = $from_index;
		$new_status['to'] = $to_index;
		$new_status['move'] = $from_capacity;		
	}else {
		foreach ($status as $key => $value) {
			if($key != $from_index && $key != $to_index && $key != 'parent'){
				$new_status[$key] = $status[$key];
			}
			if($key == $from_index){
				$new_status[$key] = $status[$from_index] - $to_capacity;
			}
			if($key == $to_index){
				$new_status[$key] = intval($to_index);
			}
		}
		$new_status['from'] = $from_index;
		$new_status['to'] = $to_index;
		$new_status['move'] = $to_capacity;	
	}
	//判断是否回路存在
	while ($parent != -1) {
		$check = $status_tree[$parent];
		if($check['8'] == $new_status['8'] && $check['5'] == $new_status['5'] && $check['3'] == $new_status['3']){
			return false;
		}
		$parent = $check['parent'];
	}
	if($new_status['8'] == 4 && $new_status['5'] == 4 && $new_status['3'] == 0){
		$new_status['end'] = true;
	} else {
		$new_status['end'] = false;
	}
	$status_tree[] = $new_status;
}

function get_solution($status_tree){
	$solution = array();
	foreach ($status_tree as $key => $value) {
		if($status_tree[$key]['end']){
			$path = array();
			$path[]=$key;
			$parent = $value['parent'];
			while($parent != -1){
				$path[]=$parent;
				$parent = $status_tree[$parent]['parent'];
			}
			$solution[] =array_reverse($path);
		}
	}
	return $solution;
}

function output_solution($solution,$status_tree) {
	foreach ($solution as $key => $value) {
		echo "——————————————————————"."\r\n";
		foreach($value as $status){
			$output = "[".$status_tree[$status]['8'].",".$status_tree[$status]['5'].",".$status_tree[$status]['3']."]";
			if($status_tree[$status]['from']!=-1){
				$output .= " from ".$status_tree[$status]['from'];
				$output .= " to ".$status_tree[$status]['to'];
				$output .= " move ".$status_tree[$status]['move'];
			}
			$output .= "\r\n";
			echo $output;
		}
	}
}