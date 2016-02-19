<?php
$status = array(
	'parent' => -1,
	'monks_left' => 3,
	'monsters_left' => 3,
	'monks_right' => 0,
	'monsters_right' => 0,
	'ship' => 'left',
	'end' => false,
);

$actions = array(
	'to_right'=>[
		array(
			'monks_left' => -1,
			'monsters_left' => 0,
			'monks_right' => 1,
			'monsters_right' => 0,
		),
		array(
			'monks_left' => -2,
			'monsters_left' => 0,
			'monks_right' => 2,
			'monsters_right' => 0,
		),
		array(
			'monks_left' => 0,
			'monsters_left' => -1,
			'monks_right' => 0,
			'monsters_right' => 1,
		),
		array(
			'monks_left' => 0,
			'monsters_left' => -2,
			'monks_right' => 0,
			'monsters_right' => 2,
		),
		array(
			'monks_left' => -1,
			'monsters_left' => -1,
			'monks_right' => 1,
			'monsters_right' => 1,
		)
	],
	'to_left'=>[
		array(
			'monks_left' => 1,
			'monsters_left' => 0,
			'monks_right' => -1,
			'monsters_right' => 0,
		),
		array(
			'monks_left' => 2,
			'monsters_left' => 0,
			'monks_right' => -2,
			'monsters_right' => 0,
		),
		array(
			'monks_left' => 0,
			'monsters_left' => 1,
			'monks_right' => 0,
			'monsters_right' => -1,
		),
		array(
			'monks_left' => 0,
			'monsters_left' => 2,
			'monks_right' => 0,
			'monsters_right' => -2,
		),
		array(
			'monks_left' => 1,
			'monsters_left' => 1,
			'monks_right' => -1,
			'monsters_right' => -1,
		)
	]
);

$status_tree = array($status);
$begin_index = 0;
$finish = false;
while (!$finish) {
	build_status_tree($status_tree,$actions,$begin_index,$finish);
}
$solution = get_solution($status_tree);

output_solution($solution,$status_tree);

function build_status_tree(&$status_tree,$actions,&$begin_index,&$finish){
	$begin = $begin_index;
	$end = count($status_tree);
	$begin_index = count($status_tree);
	for($i = $begin;$i < $end;$i++){
		if($status_tree[$i]['end']){
			continue;
		}
		move($status_tree,$i,$actions);
	}
	if(count($status_tree) == $end){
		$finish = true;
	}
}

function move(&$status_tree,$parent,$actions){
	$status=$status_tree[$parent];
	if($status['ship']=='left'){
		$action_list = $actions['to_right'];
		$direction = 'to_right';
	} else if($status['ship']=='right'){
		$action_list = $actions['to_left'];
		$direction = 'to_left';
	}
	foreach ($action_list as $action) {
		$new_status = array(
			'parent' => $parent,
			'monks_left' => $status['monks_left'] + $action['monks_left'],
			'monsters_left' => $status['monsters_left'] + $action['monsters_left'],
			'monks_right' => $status['monks_right'] + $action['monks_right'],
			'monsters_right' => $status['monsters_right'] + $action['monsters_right'],
			'ship' => $status['ship'] == 'left' ? 'right' : 'left',
			'direction' => $direction,
			'monks' => $direction == 'to_left' ? $action['monks_left'] : $action['monks_right'],
			'monsters' => $direction == 'to_left' ? $action['monsters_left'] : $action['monsters_right'],
		);
		$valid = true;
		//和尚和妖怪的数量不能小于0
		if(intval($new_status['monsters_left']) < 0 
			|| intval($new_status['monks_left']) < 0 
			|| intval($new_status['monsters_right']) < 0 
			|| intval($new_status['monks_right']) < 0){
			$valid = false;
		}
		//妖怪的数量不能大于和尚的数量
		if($valid && intval($new_status['monks_left']) >0 && intval($new_status['monsters_left']) > intval($new_status['monks_left'])){
			$valid = false;
		}
		if($valid && intval($new_status['monks_right']) >0 && intval($new_status['monsters_right']) > intval($new_status['monks_right'])){
			$valid = false;
		}
		//判断是否回路存在
		if($valid){
			$check_parent = $parent;
			while ($check_parent != -1) {
				$check = $status_tree[$check_parent];
				if($check['monks_left'] == $new_status['monks_left'] 
					&& $check['monsters_left'] == $new_status['monsters_left'] 
					&& $check['monks_right'] == $new_status['monks_right'] 
					&& $check['monsters_right'] == $new_status['monsters_right']
					&& $check['ship'] == $new_status['ship']){
					$valid = false;
					break;
				}
				$check_parent = $check['parent'];
			}
		}
		if($valid){
			if(intval($new_status['monks_right']) == 3 && intval($new_status['monsters_right']) == 3){
				$new_status['end'] = true;
			} else {
				$new_status['end'] = false;
			}
			$status_tree[] = $new_status;			
		}
	}
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
	echo count($solution)."个解决方案"."\r\n";
	foreach ($solution as $key => $value) {
		echo "——————————————————————"."\r\n";
		foreach($value as $status){
			$output = "["
						.$status_tree[$status]['monks_left']
						.",".$status_tree[$status]['monsters_left']
						.",".$status_tree[$status]['monks_right']
						.",".$status_tree[$status]['monsters_right']
						."]";
			if(isset($status_tree[$status]['direction'])){
				$output .= " ".$status_tree[$status]['direction']." take monks ".$status_tree[$status]['monks']." take monsters ".$status_tree[$status]['monsters'];
			}
			$output .= "\r\n";
			echo $output;
		}
	}
}