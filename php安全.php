<?php

//不相信任何不受自己直接控制的数据源的数据
/*
    1、$_GET
    2、$_POST
    3、$_REQUEST
    4、$_COOKIE
    5、$argv
    6、php://stdin
    7、php://input
    8、file_get_contents()
    9、远程数据库
    10、远程API
    11、来自客户端的数据
 */

/*
实现PHP基本安全要依靠：1、过滤输入、验证数据、转义输出

    一、过滤输入
        1、过滤HTML，使用htmlentities函数，该函数可以把特殊字符（例如&，>，&#x2033）转换成相应的html实体，这个函数会专一指定字符串的html字符，以便在存储层安全渲染
        注：该函数不会验证html输入，而且也检测不出输入字符串的字符集，默认情况下不转义单引号。所以该函数正确的使用方式是 htmlentities($input,ENT_QUOTES,'UTF-8') 第一个参数为输入字符串，第二个参数为转义单引号的常量，第三个参数为输入字符串的字符集
        警告：最好不要使用正则表达式函数过滤html，正则表达式很复杂，可能导致html无效，而且出错的几率高
        2、sql查询，使用PDO预处理语句
        3、用户资料信息，如果有应用中有用户账户，可能就要处理电子邮件地址、电话号码和邮政编码等等资料信息，使用 filter_val()和filter_input() 函数 这两个函数的参数能使用不同的标志，过滤板不同类型的输入：电子邮件地址，URl编码字符串、证书、浮点数、HTML字符、URL和特定范围内的ASCII字符
            例如，过滤用户资料中的电子邮件地址。删除除字母、数字和!#$%&'*+-=?^_{|}~@.[]`之外的所有其他字符：
                $email = 'john@example.com';
                $emailSafe = filter_var($email,FILTER_SANITIZE_EMAIL);
                echo $emailSafe;
            例如，过滤用户的个人简介，删除小于ASCII 32 的字符，转义大于ASCII 127的字符
                $string = "xxxxx";
                $safeString = filter_var($string,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW|FILTER_FLAG_ENCPDE_HIGH);
    二、验证数据
        1、使用php自带函数filter_var()
        2、组件-aura/filter
        3、组件respect/validation
        4、组件symfony/validator
        注：输入的数据既要验证也要过滤以此来确保数据是安全的，而且符合预期的
    三、转义输出
        把输出渲染成网页或者API响应时，一定要转义输出。这也是一种防护措施，能防止恶意代码，还能防止应用的用户无意中执行恶意代码
        1、使用htmlentities()函数转义输出，第二个参数一定要用ENT_QUOTES，让这个函数转义单引号和双引号，而且要在第三个参数指定合适的字符集（UTF-8）
            例如：
                $html = '<p><script>alert("注入");</script></p>';
                echo htmlentities($html,ENT_QUOTES,'UTF-8');
        2、有些模板引擎会默认转义所有输出，例如twig/twig和smarty/smarty。除非明确告诉它不要转义
    四、关于密码
        1、绝对不能知道用户的密码，为了防止泄露，在数据库存储中不能存储纯文本或能解密的密码，一单泄露，用户对你的信任将会严重降低，所以知道的越少越好
        2、绝对不要约束用户的密码，比如说一定要某种特殊的格式，最大长度等
        3、绝对不能通过电子邮件发送用户的密码（纯文本），要修改密码一般直接使用URL令牌来修改
        4、使用bcrypt计算用户密码的哈希值（经审查是最安全的哈希算法），加密和哈希不是同一回事，加密是双向算法，哈希是单向算法（摘要算法）。bcrypt算法速度比较慢，但是安全性比较高，它会花费大量时间（秒级）来反复处理数据来生成特别安全的哈希值。在这个过程中处理数据的次数叫做工作因子。工作因子的值越高，破解密码哈希值所需要的时间就成指数增长。
        注：破解密码的哈希值目前一般使用 暴力枚举和字典（无法阻止） ，查表法 ，反向查表法 ，彩虹表
 */

//使用bcrypt算法创建密码哈希值，注册与登陆

namespace BCRYPT/Register;
//注册
try {
	//验证电子邮件地址
	$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	if (!$emial) {
        throw new Exception('Invalid email');
	}
    
    //验证密码
    $password = filter_input(INPUT_POST, 'password');
    if (!$password || mb_strlen($password) < 8) {
        throw new Exception("Password must contain 8+ characters");
    }

    //创建密码哈希值
    $passwordHash = password_hash(
        $password,
        PASSWORD_DETAIL,//告诉php使用bcrypt算法哈希密码
        ['cost' => 12]//工作因子默认为10 我们设置为12 计算哈希值一般需要0.1s-0.5s
    );
    if ($passwordHash === false) {//哈希失败
        throw new Exception('PASSWORD hash failed');
    }

    //创建用户账户
    $user = new User();
    $user->email = $email;
    $user->password_hash = $passwordHash;
    $user->save();

    //重定向到登录页面
    header('HTTP/1.1 302 Redirect');
    header('Location:/login.php');
} catch (Exception $e) {
    //报告错误
    header('HTTP/1.1 400 Bad request');
    echo $e->getMessage();
}

namespace BCRYPT/login;

session_start();
try {
    //从请求主体中获取电子邮件地址
    $email = filter_input(INPUT_POST, 'email');

    //从请求主题中获取密码
    $password = filter_input(INPUT_POST, 'password');

    //使用电子邮件地址查找账户
    $user = User::findByEmail($email);

    //验证密码和账户的密码哈希值是否匹配
    if (password_verify($password, $user->password_hash) === false) {
        throw new Exception("Invalid password");
    }

    //如果需要，重新计算密码的哈希值
    $currentHashAlgorithm = PASSWORD_DETAIL;
    $currentHashOptions = array('cost' => 15);
    $passwordNeedsRehash = password_needs_rehash($user->password_hash, $currentHashAlgorithm, $currentHashOptions);
    if ($passwordNeedsRehash === true) {
        $user->password_hash = password_hash($password, $currentHashAlgorithm, $currentHashOptions);
        $user->save();
    }

    //把登录状态保存在会话中
    $_SESSION['user_logged_in'] = 'yes';
    $_SESSION['user_email'] = $email;

    //重定向到个人资料页面
    header('HTTP/1.1 302 Redirect');
    header('Location:/user-profile.php');
} catch (Exception $e) {
    header('HTTP/1.1 401 Unauthrized');
    echo $e->getMessage();
}
//ps : 该例用到的hash算法函数需要php5.5.0以上，如果不能使用5.5.0以上的版本可以通过composer安装ircmaxell、password-compat组件（安东尼.费拉拉开发）可以直接使用这些函数，这个组件有一下四个方法
//1、password_hash()
//2、password_get_info()
//3、password_needs_rehash()
//4、password_verify()

//Q：115-122为什么要重新计算哈希值是否过期？

//A：假设应用创建于2年前，那时的bcrypt工作因子为10，而现在我们的工作因子为20，因为黑客更聪明了，机器也更快乐，同时很多用户账户的密码还是工作因子为10的时候生成的，所以我们要把他更新到工作因子为20的哈希值，使用password_needs_rehash()函数检查用户记录中现有的密码哈希值是否过期。