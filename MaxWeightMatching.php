<?php
$weight_map=[
	[3,4,6,4,9],
	[6,4,5,3,8],
	[7,5,3,4,2],
	[6,3,2,2,5],
	[8,4,5,4,7]
];
$matching = array(
	'A' => array(),
	'B' => array(),
	'S' => array(),
	'T' => array(),
	'search' => array(),
	'edge'=> array(),
	'match'=>array(),
	'max_match'=>0
);
//初始化顶标
init_mark($matching,$weight_map);
//KM算法
$finish = false;
debug($matching);
while (!$finish) {
	$finish = kuhn_munkres($matching,$weight_map);
}
//计算最大权重和
$sum = 0;
foreach ($matching['match'] as $key => $value) {
	$sum=$sum+intval($weight_map[$key][$value]);
}
echo '最大权重:'.$sum."\r\n";

function init_mark(&$matching,$weight_map){
	foreach ($weight_map as $key => $weight) {
		$matching['A'][]=max($weight);
		$matching['B'][]=0;
	}
}

function kuhn_munkres(&$matching,$weight_map){
	//计算相等子图
	make_sub_graph($matching,$weight_map);
	//匈牙利算法求最大匹配
	hungary($matching);
	debug($matching);
	if($matching['max_match'] == count($matching['A'])){
	 	return true;
	}
	if(!adjust_mark($matching,$weight_map)){
		return true;
	}
	return false;
}

function make_sub_graph(&$matching,$weight_map){
	foreach ($matching['A'] as $key_x => $value_x) {
		foreach ($matching['B'] as $key_y => $value_y) {
			if($value_x + $value_y == $weight_map[$key_x][$key_y]){
				if(!isset($matching['edge'][$key_x]) || !in_array($key_y,$matching['edge'][$key_x])){
					$matching['edge'][$key_x][]=$key_y;
				}
			}
		}
	}
}

function adjust_mark(&$matching,$weight_map){
	foreach ($matching['S'] as $value_s) {
		foreach ($matching['B'] as $key_b => $value_b) {
			if(!in_array($key_b, $matching['T'])){
				//调整量
				$adjust = $matching['A'][$value_s] + $matching['B'][$key_b] - $weight_map[$value_s][$key_b];
				if( $adjust > 0){
					$array_adjust[] = $adjust;
				}
			}
		}
	}
	$d = min($array_adjust);
	if($d > 0) {
		foreach ($matching['S'] as $value_s) {
			$matching['A'][$value_s] -= $d;
		}
		foreach ($matching['T'] as $value_t) {
			$matching['B'][$value_t] += $d;
		}
		return true;
	} else {
		return false;
	}
}

function debug($matching){
	echo 'X顶标值：'.implode(',',$matching['A'])."\r\n";
	echo 'Y顶标值：'.implode(',',$matching['B'])."\r\n";
	echo '增广路径上的X：'.implode(',',$matching['S'])."\r\n";
	echo '增广路径上的Y：'.implode(',',$matching['T'])."\r\n";
	echo '最大匹配数：'.$matching['max_match']."\r\n";
	echo '——————————————————————————————————————'."\r\n";
}

function hungary(&$matching){
	reset_path($matching);
	foreach ($matching['A'] as $x => $value) {
		$matching['S'][] = $x;
		if(find_augment_path($matching,$x)){
			$matching['max_match']++;
		} else {
			$matching['search'] = array();
			break;
		}
		$matching['search'] = array();
	}
}

function find_augment_path(&$matching,$x){
	foreach ($matching['B'] as $y => $value) {
		if(in_array($y,$matching['edge'][$x]) && !in_array($y, $matching['search'])){
			$matching['search'][]=$y;
			$matching['T'][]=$y;
			if(!isset($matching['match'][$y]) || find_augment_path($matching,$matching['match'][$y])){
				$matching['match'][$y] = $x;
				return true;
			}
		}
	}
	return false;
}

function reset_path(&$matching){
	$matching['S'] = array();
	$matching['T'] = array();
	$matching['match'] = array();
	$matching['max_match'] = 0;
}

//以下为穷举法求最大值，用于验证结果
$arr = range(0, 4);
$results = array();
permutations('', $arr, $results);
$sum_result;
foreach ($results as $result) {
	$solution = explode(',', ltrim($result,","));
	$sum=0;
	foreach ($solution as $key => $value) {
		$sum += $weight_map[$key][$value];
	}
	$sum_result[]=$sum;
}

echo '穷举求最大权重:'.(max($sum_result))."\r\n";

function permutations($first = '', $arr, &$results = array()){
    $len = count($arr);
    if($len == 1) {
            $results[] = $first .",".$arr[0];
    } else {
        for($i=0; $i<$len; $i++) {
            $tmp = $arr[0];
            $arr[0] = $arr[$i];
            $arr[$i] = $tmp;
            permutations($first.",".$arr[0], array_slice($arr, 1), $results);
        }
    }
}