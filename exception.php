<?php

//php异常处理以及错误
//使用try {} catch {} 代码块

//异常是Exception类的对象，在遇到无法修复的状况时抛出(例如，远程api无响应，数据库查询失败，或者无法满足前置条件等异常状况)，出现问题时，异常用于主动出击，委托职责，异常还可用于放手，预测潜在的问题，减轻其影响
//Exception对象与其他php对象一样，使用new关键字实例化，该对象有两个主要的属性:一个是消息，一个是数字代码。消息用于描述出现的问题；数字代码是可选的，用于指定异常提供的上下文。
//实例化Exception对象可以向下面这样设定消息和可选的数字代码 例:
/**
 * $exception = new Exception('Danger, will Rob', 100);
 * //我们可以使用公开的getCode()和getMessage()获取Exception对象的这个两个属性
 * $code = $exception->getCode();
 * $message = $exception->getMessage();
 */





//抛出异常
//实例化异常类时可以把异常赋值给变量，但是一定要抛出异常。抛出异常后代码会立即停止执行，后续的php代码都不会运行，抛出异常使用的是throw关键字，关键字后面要抛出Exception实例
/**例:
 * throw new Exception('Sometion went worng');
 */

//我们必须要抛出Exception类(或其子类)的实例。PHP内置异常类和其子类如下
/**
 * Exception (http://php.net/manual/class/exception.php)
 * ErrorException (http://php.net/manual/class.errorexception.php)
 */

//php标准库(http://php.net/manual/book.sql.php)提供了下述额外的Exception子类，扩充PHP内置的异常类
/**
 * LogicException(http://php.net/manual/class.logicexception.php)
 *     BadFunctionCallException (http://php.net/manual/class.badfuncioncallexception.php)
 *     BadMethdCallException (http://php.net/manual/class.badmethdCallException.php)
 *     DomainException (http://php.net/manual/class.domainexception.php)
 *     InvalidArgumentException (http://php.net/manual/calss.invalidargumentexception.php)
 *     LengthException (http://php.net/manual/class.lengthexception.php)
 *     OutOfRangeException (http://php.net/manual/class.outofrangeexception.php)
 * RuntimeException (http://php.net/manual/calss.runtimeexception.php)
 *     OutOfBoundsException (http://php.net/manual/outofboundsexception.php)
 *     OverflowException (http://php.net/manual/class.overflowexception.php)
 *     RangeException (http://php.net/manual/class.rangeexception.php)
 *     UnderflowException (http://php.net/manual/class.underflowexception.php)
 *     UnexpectedValueException (http://php.net/manual/class.unexpectedvalueexception.php)
 */

//php中的异常是类，因此可以轻易扩展Exception类，使用定制的属性和方法创建自定义的异常子类，使用哪个异常子类由主观决定，不过选择或创建的异常子类要能最好的回答"为什么抛出异常"，这个问题，还要说明为什么这么选择





//捕获异常
//拦截并处理潜在异常的方式是，把可能抛出的异常的代码放在try/catch代码块中。
/**例如:在pdo连接数据失败时会抛出PDOException对象。catch块会捕获这个额异常，然后显示友好的错误信息
 * 
 */

// try {
//     $pdo = new PDO('mysql://host=worng_host;dbname=worng_name');
// } catch (PDOException $e) {
//     //获取异常的属性，以便输出信息
//     $code = $e->getCode();
//     $message = $e->getMessage();

//     //提示
//     echo 'someTing went wrong'.PHP_EOL;
//     echo $code;
//     echo $message;
// }

//同时可以通过多段catch块来拦截多种异常，如果要使用不同的方式处理抛出的不同异常类型，可以这么做。我们还可以使用一个finally块，在捕获任何类型的异常之后运行一段代码

// try {
//     throw new Exception('Not a PDO exception');
//     $pdo = new PDO('mysql://host=worng_host;dbname=worng_name');
// } catch (PDOException $e) {
//     //处理PDOException异常
//     echo 'Caught PDO exception';
// } catch (Exception $e) {
//     //处理所有其他类型的异常
//     echo 'Caucht generic exception  '.$e->getMessage();
// } finally {
// 	//最终代码始终都会运行这一块
// 	echo 'always do this';
// }
//如果没有适用的catch块，异常会向上冒泡，直到php脚本由于致命错误而终止运行





//异常处理程序
//Q:如何捕获每一个抛出的异常？不会漏掉一些异常吗？
//A:php允许我们注册一个全局异常处理程序，捕获所有未被捕获的异常，我们一定要设置一个全局异常处理程序。异常处理程序是最后的安全保障。如果没有成功捕获并处理异常，通过这个措施可以给PHP应用的用户显示合适的错误消息。可以使用异常处理程序在开发环境中显示调试信息，生产环境则显示对用户友好的消息

//异常处理程序是任何可调用的代码。可以使用匿名函数，也可以使用类的方法，不管使用什么，异常处理程序都必需接收一个类型为Exception的参数。异常处理程序使用set_exception_handler()函数注册
/**例如:
 * set_exception_handler(function ($e) {
 *     //处理并记录异常
 * });
 */
//建议:在异常处理程序中记录异常。这样，出问题时日志记录器能提醒你，而且还能保存异常细节，供以后查看
//在某些情况下，我们可能要使用自定义的异常处理程序来代替现有的异常处理程序。代码执行完毕后，php会建议你还原现有的异常处理程序，还原成前一个异常处理程序的方式是调用restore_exception_handler()函数

/**
 * set_exception_handler(function ($e) {
	    //处理并记录异常
    });

    //我们编写的其他代码...

    //还原成以前的异常处理程序
    restore_exception_handler();
 */





//错误
//错误和异常之间的差别很小，我们可以使用error_reporting()函数，或者在php.ini文件中使用error_reporting指定，告诉php哪些错误要忽略。这两种方式都使用E_*常量确定要报告和忽略哪些错误。
//php报告错误要遵循的4大原则:
/**
 * 1、一定要让php报告错误
 * 2、在开发环境中要显示错误
 * 3、在生产环境中不能显示错误
 * 4、任何环境中都要记录错误
 */

//在php.ini中设置如下
/**开发环境
 * ;显示错误
 * display_startup_errors = On
 * display_errors = On
 *
 * ;报告所有错误
 * error_reporting = -1
 *
 * ;记录错误
 * log_errors = On
 *
 * //生产环境
 * ;不显示错误
 * display_startup_errors = Off
 * display_errors = Off
 *
 * ;除了注意事项之外，报告所有其他错误
 * error_reporting = E_ALL & ~E_NOTICE
 *
 * ;记录错误
 * log_errors = On
 */





//错误处理程序
//可以生成一个全局的错误处理程序来拦截错误，在错误处理程序中可以再终止执行php脚本之前清理残局，使用优雅的方式处理错误。
//与异常处理程序一样，错误处理程序可以是任何即可调用的代码（例如函数和类）。我们要在错误处理程序中调用die()或exit()函数。如果在错误处理程序中不手动终止执行php脚本，php脚本会从错误的地方继续向下执行。注册全局错误处理程序的方式是使用set_error_handler()函数，我们要把一个可调用的参数传入这个方法。

/**例: 使用 set_error_handler() 函数
 * set_error_handler(function ($errno, $errstr, $errfile, $errline) {
 *     //处理错误
 * });
 * 可调用的错误处理程序接收五个参数
 *
 * $errno
 *     错误等级(对应于一个E_*常量)
 * $errstr
 *     错误消息
 * $errfile
 *     发生错误的文件名
 * $errline
 *     发生错误的行号
 * $errcontext
 *     一个数组，只想错误发生时可用的符号表。这个参数是可选的，做高级调试时才用得到。
 * 注意:PHP会把所有错误都交给错误处理程序处理，甚至包括错误报告设置中排除的错误。因此，我们要检查每个错误代码(第一个参数)，然后做适当处理，我们可以通过设置set_error_handler()函数的第二个参数来让错误处理程序只处理一部分错误类型。这个参数的值是使用E_*常量组合的位掩码(例E_ALL | E_STRICT)
 */
//也可以把php错误转换成ErrorException对象。ErrorException类时Exceotion类的子类，而且是PHP内置的类。因此可以吧PHP错误转换成一场，使用处理异常的现有流程处理错误。
//注意:并不是所有错误都能转换成异常！不能转换成异常的错误有:E_ERROR、E_PARSE、E_CORE_ERROR、R_CORE_WARNING、E_COMPILE_ERROR、E_COMPILE_WARNING和大多数E_STRICT错误。

//PHP错误转换只能转换满足php.ini文件中error_reporting指令设置的错误。例如:
/**
 * set_error_handler(function ($errno, $errstr, $errfile, $errline) {
 *     if (!(error_reporting() & $errno)) {
 *         // error_reporting指令没有设置这个错误，所以忽略
 *         return;
 *     }
 *     throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
 * });
 * //在我们编写的错误处理代码执行完毕之后，还原之前的错误处理程序是个好习惯，调用restore_error_handler()函数
 * restore_error_handler();
 */




//在生产环境中处理异常和错误
//PHP提供了error_log()函数，使用这个函数可以把错误消息写入系统或syslog，还可以通过电子邮件发送错误消息。不过我们可以用更好的组件 Monolog(https://github.com/Seldaek/monolog)。Monolog这个组件只专注于记录日志。使用Composer可以轻易地把这个组件集成到PHP应用中。
/**
 * 加入monolog包
 * {
 *     "require" : {
 *         "monolog/monolog" : "~1.11"
 *     }
 * }
 */

//在生产环境中使用monolog记录日志
//使用php自动加载器
/**
 * require '/usr/local/software/MFFC/vendor/autoload.php';
    //带入monolog的命名空间
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    //设置monolog提供的日志记录器
    $log = new Logger('my-app-name');
    $log->pushHandler(new StreamHandler(__DIR__.'/my.log',Logger::NOTICE));

    try {
        throw new Exception('Not a PDO exception');
        $pdo = new PDO('mysql://host=worng_host;dbname=worng_name');
    } catch (PDOException $e) {
        //处理PDOException异常
        $log->warn('Caught PDO exception');
    } catch (Exception $e) {
        //处理所有其他类型的异常
        $log->notice('Caucht generic exception  '.$e->getMessage());
    } finally {
        //最终代码始终都会运行这一块
        echo 'always do this';
    }
 */

//在记录日志的同时发送email提醒我
//使用 SwiftMailer 组件 发送邮件

require '/usr/local/software/MFFC/vendor/autoload.php';
//带入monolog的命名空间
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SwiftMailerHandler;

date_default_timezone_set('America/New_York');

//设置monolog提供的日志记录器
$log = new Logger('my-app-name');
$log->pushHandler(new StreamHandler(__DIR__.'/my.log',Logger::NOTICE));

//添加SwiftMailer处理程序，让它处理重要的错误
$transport = (new Swift_SmtpTransport('smtp.qq.com', 465, 'ssl'))//配置服务器传输对象，qq的必需使用ssl加密
             ->setUsername('2427979704@qq.com')//设置用户名
             ->setPassword('gilpqsabntivebai');//设置密码

$mailer = new Swift_Mailer($transport);

$message = (new Swift_Message())
           ->setSubject('WebSite Error~!')
           ->setFrom(array('2427979704@qq.com' => 'sgm1'))
           ->setTo(array('17855843369@163.com'))
           ->setBody('测试一下');

$log->critical('The Server is on fire!');

$result = $mailer->send($message);