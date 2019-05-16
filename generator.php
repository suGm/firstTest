<?php
	
	/*
		在PHP 5.5.0 中引入的概念
		PHP生成器 关键字yield 产出模式为 每次产出一个值后，生成器内部状态都会停顿，向生成器请求下一个值的时候，内部状态才会恢复，所以生成器的内部状态会 一直在停顿和恢复之间切换，知道抵达函数体末尾或者renturn空
		应用场景 如果要使用特定的方式计算大量数据，对性能要求比较高，这时候用生成器(迭代大型数据或数列时)
		比如 一个应用场景为：要迭代一个大小为4GB的CSV文件，而虚拟服务器内存只有1GB，因此不能把整个文件都加载带内存中一口气拿出来，不过我们可以使用yield一部分一部分的拿出来，所以我们用 yield 生成器来完成
		生成器可以减少内存
		生成器只产出值，不返回值
	 */
	//例1
	function myGenerator(){

		yield 'value1';
		yield 'value2';
		yield 'value3';
		yield 'value4';

	}

	foreach(myGenerator() as $value){
		echo $value.PHP_EOL;
	}

	//例2 产出一个范围的数值
	
	//2.1 错误方式 这个所要预期的结果是输出1-1000000的值，这样会产生一个内存来存储这1000000的值，浪费内存，用生成器则不会产生1000000的存储内存
	
	// function makeRange_1($length){

	// 	$dataset = [];
	// 	for($i = 0 ; $i < $length ; $i++ ){
	// 		$dataset[] = $i;
	// 	}

	// 	return $dataset;

	// }

	// $customRange = makeRange_1(1000000);

	// foreach($customRange as $i){
	// 	echo $i,PHP_EOL;
	// }

	//2.2正确做法
	function makeRange_2($length){

		for($i = 0 ; $i < $length ; $i++){
			yield $i;
		}

	}

	foreach(makeRange_2(10000000) as $i){//直接输出1-1000000的数字而不生成数组来存储内存
		echo $i,PHP_EOL;
	}


