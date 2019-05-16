<?php

interface User{
	
	function eat();
	function sleep();

}

class UserPeople{

	protected function run(){
		echo '跑啦';
	}

}

class Chinese extends UserPeople implements User{

	public function eat(){
		echo '吃啦';
	}

	public function sleep(){
		echo '睡啦';
	}

	public function run(){
		parent::run();
	}

}

$user = new Chinese();

$user->eat();
$user->run();