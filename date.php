<?php

//日期、时间
//不要自己去处理时间，使用PHP 5.2.0引入的DateTime、DateInterval、DateTimeZone

//1、设置默认时区
/*
    1.) 在php.ini 中设置date.timezone = 'America/New_York';
    2.) 在php文件中运行时使用date_default_timezone_set()函数
 */

//2、DateTime类

$dateTime_1 = new DateTime('2014-04-27 5:40 AM');//返回的是对象
$dateTime_2 = DateTime::createFromFormat('M j, Y H:i:s', 'Jan 2, 2014 23:04:12');//该静态方法使用的日期和时间格式与date()函数一样

var_dump($dateTime_1);
echo '<br />';
var_dump($dateTime_2);

//3、DateInterval类
/**
   DateInterval实例用于修改DateTime实例，例如：DateTime类提供了用于处理DtaeTime实例的add()和sub()方法，这两个方法的参数都是一个DateInterval实例，指定要添加（减去）到DateTime实例中的时间量。

   实例化DateInterval类的方式是使用构造方法。DateInterval类构造方法的参数是一个以字母 P 开头的字符串，后面跟着一个整数，最后是一个周期标志符，有效的周期标志符：
   Y（年）
   M（月）
   D（日）
   W（周）
   H（时）
   M（分）
   S（秒）
   间隔规约中即可有有日期也可以有时间，要在日期和时间两部分之间加上字母 T 。 如 间隔规约 P2D 表示两天，间隔规约 P2DT5H2M 表示 2天5小时2分钟
 */

//创建间隔为2周
$interval = new DateInterval('P2W');

//修改dateTime实例
$dateTime_1->add($interval);
echo '<br />';
echo $dateTime_1->format('Y-m-d H:i:s');

//还可以创建反向的DateInterval实例，通过这种方式，我们可以吧DatePeriod实例倒序向前推移

$dateStart = new \DateTime();
$dateInterval = \DateInterval::createFromDateString('-1 day');
$datePeriod = new \DatePeriod($dateStart, $dateInterval, 3);
echo '<br />';
foreach ($datePeriod as $date) {
	echo $date->format('Y-m-d').'<br />';
}

//4、DateTimeZone类
//创建DateTime实例时经常要使用DateTimeZone实例。DateTime类构造方法可选的第二个参数是一个DateTimeZone实例，传入这个参数后，DateTime实例的值，以及对这个值的修改都指定相对的时区，如果不传为默认时区

/**
 * $timezone = new DateTimeZone('America/New_York');
 * $datetime = new DateTime('2014-08-20',$timezone);
 * //如果DateTime以及实例化了 那么可以用 setTimezone() 方法修改实例的时区
 * $timezone = new DateTimeZone('America/New_York');
 * $datetime = new DateTime('2014-08-20',$timezone);
 * $datetime->setTimezone(new DateTimeZone('Asia/Hong_Kong'));
 * 最简便的方法是把时间存储为UTC时区，当要给用户展示的时候再转换成相应的时区
 */

//5、DatePeriod类
/**
 * 当我们需要迭代处理一段时间内反复出现的一系列日期和时间，重复再日程表中记事就是个好例子。DatePeriod类可以解决这种问题。该类接收三个必要参数：
 *    一个DateTime实例，表示迭代开始的时间和日期
 *    一个DateInterval实例，表示到下一个日期和时间的间隔
 *    一个整数，代表跌倒的总次数
 *DatePeriod实例时一个迭代器，每次迭代都会产出一个DateTime实例
 */

//例1
$start = new DateTime();
$interval = new DateInterval('P2W');
$period = new DatePeriod($start, $interval, 3);

foreach ($period as $nextDateTime) {
    echo $nextDateTime->format('Y-m-d H:i:s').'<br />';//迭代三次一共会打印出四次
}

//例2
$period = new DatePeriod($start, $interval, 3, DatePeriod::EXCLUDE_START_DATE);//使用该常量可以排除迭代时的起始日期和时间 迭代三次 一共会打印出三次


foreach ($period as $nextDateTime) {
    echo $nextDateTime->format('Y-m-d H:i:s').'<br />';//迭代三次一共会打印出四次
}

//ps:如果经常需要处理日期和时间，应该使用nesbot/carbon组件（布莱恩.内斯比特开发），该组件提供一个简单的接口，有很多处理日期和时间的有用方法