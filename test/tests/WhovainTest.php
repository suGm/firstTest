<?php

//该类扩展自PHPUnit_Framework_TestCase类

//单元测试的目的是验证公开接口的预期行为，因此，我们要测试Whovian类的三个公开方法。我们要编写一个单元测试，确认有没有吧__construct()方法的参数设为实例喜欢的一声，然后编写一个单元测试确认say()方法的返回值有没有提到实例喜欢的一声。最后，为respondTo()方法编写两个测试:一个测试确认输入值和喜欢的医生一样时，返回值是不是字符串"I agree！";另一个测试确认输入值和喜欢的医生不一样时，会不会抛出异常

//为什么检查最喜欢的医生时，使用assertAttributeEquals()方法，而不使用获取方法(例如getFavoriteDoctor())呢?
//因为我们一次只个隔离测试一个指定的方法。理想情况下测试不能依赖其他方法，我们要验证这个方法能不能把参数的值赋予对象的$favoriteDoctor属性。assertAttributeEquals()这个断言方法能检查对象的内容状态，而不用依赖某个为测试的获取方法

require dirname(__DIR__) . '/src/Whovian.php';

use PHPUnit\Framework\TestCase;//phpunit 6.0以后不用PHPUnit_Framework_TestCase了

class WhovianTest extends TestCase
{
    //这里是各个测试
    
    //测试1 __construct()方法
    public function testSetsDoctorWithConstructot()
    {
        $Whovian = new Whovian('Peter Capaldi');
        $this->assertAttributeEquals('Peter Capaldi', 'favoriteDoctor', $Whovian);
        //assertAttributeEquals()接收三个参数，第一个参数是期望值，第二个参数是属性名，第三个参数是要检查的对象。assertAttributeEquals()方法的精妙之处在与，可以使用PHP的反射功能检查并验证受保护的属性
    }

    //测试2 say()方法
    public function testSaysDoctorName()
    {
        $whovian = new Whovian('David Tennant');
        $this->assertEquals('The best doctor is David Tennant', $whovian->say());
    }

    //测试3 表示认同的respondTo()方法
    public function testRespondToInAgreement()
    {
        $whovian = new Whovian('David Tennant');
        $opinion = 'David Tennant is the best doctor,period';
        $this->assertEquals('I agree!', $whovian->respondTo($opinion));
    }

    //测试4 表示反对的respondTo()方法
    //如果这个测试抛出异常，测试就会通过；否则，测试失败。我们可以使用@expetedException注解测试这种情况
    public function testRespondToInDisagreement()
    {
        $whovian = new Whovian('David Tennat');

        $option = 'No Way. Matings Smith was awesome!';
        $whovian->respondTo($option);
    }
}