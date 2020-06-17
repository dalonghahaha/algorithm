<?php
$n=3;
$from = 'A';
$transfrom = 'B';
$to = 'C';

$path = array();

hanoi($n,$from,$transfrom,$to,$path);

output($path);

function hanoi($n,$from,$transfrom,$to,&$path){
	if($n == 1){
		move(1,$from,$to,$path);
	}else{
		hanoi($n-1,$from,$to,$transfrom,$path);
		move($n,$from,$to,$path);
		hanoi($n-1,$transfrom,$from,$to,$path);
	}
}

function move($n,$from,$to,&$path){
	$path[] = array(
		'No' => $n,
		'from' => $from,
		'to' => $to
	);
}

function output($path){
	echo "一共个".count($path)."步骤"."\r\n";
	foreach ($path as $key => $value) {
		echo "第".($key + 1)."步: 盘子".$value['No']." form".$value['from']." to ".$value['to']."\r\n";
	}
}