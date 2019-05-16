<?php
	
	//PSR代码风格 PHP-FIG(PHP标准化组织) 规定
	//PSR-1：基本的代码风格 要编写符合社区的PHP代码，就要遵守PSR-1
	/*
		PSR-1代码要求：
			1、PHP标签
				必需吧PHP代码放在<?php ?>或者<?= ?>标签中。不得使用其他PHP标签语法
			2、编码
				所有PHP文件都必需使用UTF-8字符集编码，而且不能使用字节顺序标记
			3、目的
				一个PHP文件可以定义符号（类、性状、函数和常量），或者执行有副作用的操作（生成结果或处理数据），但是不能同时做这两件事情，目的要确定。
			4、自动加载
				PHP命名空间和类必需遵守PSR-4自动加载器标准。我们只需为PHP符号选择合适的名称，并把定义符号的文件放在预期的位置。
			5、类的名称
				PHP类的名称必须一直使用大驼峰式
			6、常量的名称(变量名称没做强制要求)
				PHP常量的名称必须全部使用大写字母，如果需要可以使用下划线把单次分开
			7、方法的名称
				PHP方法的名称必须一致使用小驼峰式。
	 */

	//PSR-2：严格的代码风格（推荐使用）
	/*
		PSR-2代码要求：
			1、贯彻PSR-1代码分隔
				PSR-1代码风格遵守
			2、缩进
			    使用四个空格缩进而不是制表符缩进，因为空格在不同的代码编辑器中渲染的效果基本一致
			3、文件和代码行
			    PHP文件必需使用UNiX风格的换行符（LF），最后要有一行空格，而且不能使用PHP关闭标签 ?> 。每行代码不能超过80个字符，最多不能超过120个字符，每行末尾不能有空格。
			4、关键字
			    PHP关键字都使用小写的方式，如true,false,null,use
			5、命名空间
			    每个命名空间语句申明后都必需跟着一个空行，类似地，使用use关键字导入命名空间或为命名空间创建别名时，在一系列use声明语句后要加一个空行。例如：
			        <?php
			            namespace My\Component;

			            use Symfony\Components\HttpFoundation\Request;
			            use Symfony\Components\HttpFoundation\Response;

			            Class App
			            {
                            //类的定义体
			            }
			6、类
			    类的启示括号要新起一行
			    Class App
			    {
                    //类的定义体
			    }
			7、方法
			    方法的定义体和括号位置和类定义体的括号位置一样：方法定义体的起始括号要在方法名之后新起一行；方法定义体的结束括号也要新起一行。要特别注意方法的参数，括号内起始圆括号后没有空格，结束圆括号前也没有空格，多个参数中间用逗号隔开，逗号后面有一个空格，变量赋默认值等号左右两边有空格
			    例如：
			        namespace Animals;

			        class StrawNeckedIbis
			        {
	                     public function flapWings($numberOfTimes = 3, $speed = 'fast')
	                     {
	                         //方法定义体
	                     }
			        }
			8、可见性
			    类中的所有属性和方法都要申明可见性。可见性由public、protected或private指定，如果把类的属性和方法设定为abstract或final，这两个关键字要放在 public、protected或private 关键字前，如果是静态申明 static 则要放在 public、protected或private 关键字之后 如：
			    namespace Animals;

			    classStrawNeckedIbis
			    {
	                //指定了可见性的静态属性
	                public static $numberOfBirds = 0;
	                final public $number;

	                //指定了可见性的方法
	                public function __construct()
	                {
	                    static::$numberOfBirds++;
	                }
			    }
			9、控制结构
			    所有控制结构关键字后面都要有一个空格。控制结构关键字包括：if、elseif、else、switch、case、while、do while、for、foreach、try和catch。如果控制结构关键字后面有一对圆括号，起始圆括号后面不能有空格，结束圆括号之前不能有空格，与类和方法定义体不同，控制结构关键字后面的起始括号应该和控制结构关键字写在同一行，控制结构关键字后面的结束括号必需单独写一行，如：

			    $gorilla = new \Animals\Gorilla;
			    $ibis = new \Animals\StrawNeckedIbis;

		 	    if ($gorilla->isAwake() === true) {
                    do {
	                    $gorilla->beatChest();
                    } while ($ibis->isAsleep() === true);

                    $ibis->flyAway();
			    }
	 */
	
	//PSR-3：日志记录器接口
	/*
         PSR-3日志记录器是一个接口，他规定了PHP日志记录器的实现方法，他服用了 RFC 5424 系统日志协议，规定要实现九个方法：
             namespace Psr\Log;

             interface LoggerInterface
             {
	             public function emergency($message, array $context = array());
	             public function alert($message, array $context = array());
	             public function critical($message, array $context = array());
	             public function error($message, array $context = array());
	             public function warning($message, array $context = array());
	             public function notice($message, array $context = array());
	             public function info($message, array $context = array());
	             public function debug($message, array $context = array());
	             public function log($message, array $context = array());
             }

             $context参数用于构造复杂的日志消息。消息文本中可以使用占位符例如{placeholder_name}。占位符由{占位符名称}组成，不能包含空格。并且$context是一个关联数组，键是占位符名称，对应的值用于替换消息文本中的占位符
        注：不需要自己写PSR-3标准的日志记录器，因为有一个已经十分优秀的符合标准的PSR-3的日志记录器，叫做 Monolog
	 */
	//PSR-4：自动加载器策略
	/*
	    PHP自动加载器，通过命名空间自动帮助加载文件
	    注意：也不需要自己编写PSR-4规范的自动加载器，因为Composer可以帮助自动生成符合规范的PSR-4自动记载器

	 */