<?php

/*
	在PHP 5.3.0中引入的概念
	闭包和匿名函数(理论上，闭包和匿名是不同的概念，但是PHP将闭包和匿名视为相同的概念)

 */

//例 简单闭包
//之所以能调用变量函数是因为该匿名函数在创建的时候创建了一个闭包对象，而闭包对象实现了php的__invoke魔术方法，所以只要变量名称后有()，PHP就会查找并调用__invoke方法
//__invoke魔术方法，当尝试以调用一个函数的方式来调用对象时会执行的方法
$closure = function($name){
	return sprintf('Hello %s',$name);
};

echo $closure('Josh');

class invoke{
	function __invoke($name){
		return sprintf('he is %s',$name);
	}
}

$cls = new invoke();
echo $cls('sgm');

//闭包常出现在函数里的回调 例

$newArr = array_map(function($number){
	return $number + 1;
},[1,2,3]);

var_dump($newArr);

//闭包并封装状态 使用use关键字 把变量添加到闭包上 注意 变量外要括号，可以掺入多个参数，形式为 use(param1,param2,...)

function enclosePerson($name){
	return function ($doCommond) use ($name){
		return sprintf('%s,%s',$name,$doCommond);
	};
}

$sgm = enclosePerson('sgm');//传入name 使用use 闭包会记录这个name值
echo $sgm('go to school');//调用方法的方式调用对象，执行__invoke方法  go to school 就是匿名函数的变量


//闭包的bindTo方法可以把闭包绑定到那个对象所属的类中，这样，闭包就可以访问绑定对象中受保护的和私有的成员，PHP框架常常使用bindTo()方法把路由URL映射到匿名回调函数上。框架把匿名函数回调绑定到应用对象上

echo PHP_EOL;

class App{

	protected $routes = array();
	protected $responseStatus = '200 OK';
	protected $responseContentType = 'text/html';
	protected $responseBody = 'Hello world';

	public function addRoute($routePath,$routeCallback){
		$this->route[$routePath] = $routeCallback->bindTo($this,__CLASS__);
	}

	public function dispatch($currentPath){
		foreach($this->routes as $routePath => $callback){
			if($routePath === $currentPath){
				$callback();
			}
		}

		header('HTTP/1.1' . $this->responseStatus);
		header('Content-type:' . $this->responseContentType);
		header('Content-length:' . mb_strlen($this->responseBody));

		echo $this->responseBody;
	}

}

$app = new App();
$app->addRoute('/data/josh.php',function(){
	$this->responseContentType = 'application/json;charset=utf8';
	$this->responseBody = '{"name":"Json"}';
});

$app->dispatch('/data/josh.php');

