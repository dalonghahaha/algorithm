<?php
$boys=array('Peter','Allen','Jhon','Mike','Anthony','Austin','Hugo','Howard','Jimmy','Paul');
$girls=array('Mary','Alice','Cindy','Janet','Natasha','Peggy','Sarah','Zoey','Mandy','Judy');
$favorites=array();
//随机初始化喜好列表
foreach ($boys as $value) {
	make_favorite($value,$girls,$favorites);
}
//print_r($favorites);
$matching = array(
	'search'=>array(),
	'match'=>array(),
	'max_match'=>0
);

//匈牙利算法
hungary($matching,$boys,$girls,$favorites);

print_r($matching);

function make_favorite($boy,$girls,&$favorites){
	//风流指数
	$romantic = rand(1,5);
	//女孩总数
	$girls_total = count($girls);
	$favorite_girls = array();
	for ($i=0; $i < $romantic; $i++) { 
		$select = rand(0,$girls_total);
		while (in_array($select,$favorite_girls)) {
			$select = rand(0,$girls_total);
		}
		$favorite_girls[]=$select;
	}
	foreach ($girls as $key => $girl) {
		if(in_array($key,$favorite_girls)){
			$favorites[$boy][$girl] = true;
		}else {
			$favorites[$boy][$girl] = false;
		}
	}
}

function hungary(&$matching,$boys,$girls,$favorites){
	foreach ($boys as $boy) {
		if(find_augment_path($matching,$boy,$girls,$favorites)){
			$matching['max_match']++;
		}
		clear_on_path_sign($matching);
	}
}

function find_augment_path(&$matching,$boy,$girls,$favorites){
	foreach ($girls as $girl) {
		if($favorites[$boy][$girl] && !in_array($girl, $matching['search'])){
			$matching['search'][]=$girl;
			if(!isset($matching['match'][$girl]) || find_augment_path($matching,$matching['match'][$girl],$girls,$favorites)){
				$matching['match'][$girl] = $boy;
				return true;
			}
		}
	}
	return false;
}

function clear_on_path_sign(&$matching){
	$matching['search'] = array();
}