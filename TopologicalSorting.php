<?php
$project = array(
	'P1' =>array(
		'time' => 8,
		'condition' => null,
		'start_time' => -1
	),
	'P2' =>array(
		'time' => 5,
		'condition' => null,
		'start_time' => -1
	),
	'P3' =>array(
		'time' => 6,
		'condition' => ['P1','P2'],
		'start_time' => -1,
	),
	'P4' =>array(
		'time' => 4,
		'condition' => ['P3'],
		'start_time' => -1
	),
	'P5' =>array(
		'time' => 7,
		'condition' => ['P2'],
		'start_time' => -1
	),
	'P6' =>array(
		'time' => 7,
		'condition' => ['P4','P5'],
		'start_time' => -1
	),
	'P7' =>array(
		'time' => 4,
		'condition' => ['P1'],
		'start_time' => -1
	),
	'P8' =>array(
		'time' => 3,
		'condition' => ['P7'],
		'start_time' => -1
	),
	'P9' =>array(
		'time' => 4,
		'condition' => ['P4','P8'],
		'start_time' => -1
	)
);

$topological = array();
//计算最早开始时间
make_start_time($project);
//拓扑排序
topological_soring($project,$topological);

print_r($topological);

function make_start_time(&$project){
	foreach ($project as $stage => $info) {
		if($info['condition'] == null){
			$project[$stage]['start_time'] = 0;
		} else {
			$result = array();
			$condition_over = true;
			foreach ($info['condition'] as $condition) {
				if($project[$condition]['start_time'] != -1 ){
					$result[]=$project[$condition]['time'] + $project[$condition]['start_time'];
				} else {
					$condition_over = false;
					break;
				}
			}
			if($condition_over){
				$project[$stage]['start_time'] = max($result);
			}
		}
	}
	$finish = true;
	foreach ($project as $info) {
		if($info['start_time'] == -1){
			$finish = false;
		}
	}
	if(!$finish){
		make_start_time($project);
	} else {
		return;
	}
}

function topological_soring(&$project,&$topological){
	$node_delete = null;
	$min_start_time = PHP_INT_MAX;
	foreach ($project as $stage => $info) {
		if(empty($project[$stage]['condition'])){
			if($project[$stage]['start_time'] < $min_start_time){
				$node_delete = $stage;
				$min_start_time = $project[$stage]['start_time'];
			}
		}
	}
	unset($project[$node_delete]);
	$topological[]=$node_delete;
	foreach ($project as $stage => $info) {
		if(!empty($project[$stage]['condition']) && in_array($node_delete, $project[$stage]['condition'])){
			$key = array_search($node_delete,$project[$stage]['condition']);
			unset($project[$stage]['condition'][$key]);
		}
	}
	if(!empty($project)){
		topological_soring($project,$topological);
	}
}


