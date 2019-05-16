<?php

//PHP PDO(PHP DATA OBJECT PHP数据对象)，由于原生PHP提供了该扩展来应对各种各样的数据库，所以sql语句需要自己编写，所以建议在使用PDO时编写符合ANSI/ISO标准的SQL语句，这样如果更换数据库系统，SQL语句就不会失效，如果要用某种数据库的特性的话，在更换数据库的时候要记得更新sql语句

//1、数据库连接和DSN，实例化PDO来连接数据库，PDO类的构造方法有一个字符串参数，用于指定DSN（Data Source Name 数据源名称），提供数据库连接的详细信息。DSN开头是数据库驱动器的名称（如：mysql或sqlite），后面跟着:符号，然后是剩下的内容，不同数据库使用DSN连接字符串有所不同，不过一般都包涵一下信息：
/**
 *    主机名或ip地址
 *    端口号
 *    数据库名
 *    字符集
 *各种数据库使用DNS格式参见http://php.net/manual/pdo.drivers.php
 */
//PDO的第二个参数和第三个参数分别是用户名和密码
//例:使用pdo来连接一个数据库
try {
	$pdo = new PDO(
        'mysql:host=127.0.0.1;dbname=sgm;port=3306;charset=utf8',
        'root',
        'abcdefg'
	);
} catch (PDOException $e) {
    //连接数据库失败
    echo 'Database connection failed';
}

//在上面的例子里，PDO构造方法的第一个参数是DSN。这个DSN以mysql:开头，因此PDO会使用PDO扩展中的MYSQL驱动器连接MYSQL数据库
//ps:如果连接失败，PDO构造方法会抛出PDOException异常，我们创建连接的时候要预期这种异常并且加以捕获
//这么作并不安全，我们需要把PDO里面的数据库凭证放到一个其他的文件家中，在需要使用的时候引入：例如
/**
 * 我们把conf.php放在文档根目录的上一级目录
 * conf.php:
 * <?php
 *$settings = [
 *    'host' => '127.0.0.1',
 *    'port' => '3306',
 *    'name' => 'root',
 *    'password' => 'abcdefg',
 *    'charset' => 'utf8'
 *];
 *在index.php文件中导入
 *<?php
 *include('../conf.php');
 *
 *$pdo = new PDO(
 *    sprintf(
 *        'mysql:host=%s;dbname=%s;port=%s;charset=%s', 
 *        $settings['host'],
 *        $settings['name'],
 *        $settings['port'],
 *        $settings['charset']
 *    ),
 *    $settings['name'],
 *    $settings['password']
 *);
 */

//数据库预处理
/**
 * 数据库查询语句
 *  $sql = 'SELECT * FROM test;';
    $res = $pdo->query($sql);
    $result = $res->fetchAll(PDO::FETCH_ASSOC);

    //在sql语句中使用用户输入时，一定要过滤，使用pdo的预处理语句perpare()方法，例：
        //错误例子，容易被sql注入
        $sql = sprintf('select * from test where id = %s','1 or 1 = 1');
	    $res = $pdo->query($sql);
	    $result = $res->fetchAll(PDO::FETCH_ASSOC);
	    var_dump($result);
	    //正确例子
        $sql = 'select id from test where name = :name';
        $statement = $pdo->prepare($sql);

        //处理name

        //绑定数据
        $statement->bindValue(':name','sgm or 1=1');//防止sql注入
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        var_dump($result);//查询无数据

        //在bindValue函数中 第三个参数指定绑定的数据是什么类型的数据，默认为字符串
        PDO::PARAM_BOOL 布尔
        PDO::PARAM_NULL 是否为NULL
        PDO::PARAM_INT 数值型
        PDO::PARAM_STR 默认 字符串

        //在绑定数据以后，执行execute，如果执行的是增删改，那么其实已经结束了，
        但是如果执行的是查询，我们可能还要获得查询数据，所以我们可以使用fetch()、fetchAll()、fetchColumn()和fetchObject()来获得结果集

        fetch() 如果获取结果集比较大，内存可能吃不消，可以用fetch来循环迭代结果集
            
            while (($result = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
	            echo $result['name'];
            }
        fetchAll() 直接获取所有的结果集

        //关于fetch参数

        PDO::FETCH_ASSOC
            让fetch()和fetchAll()方法返回一个关联数组，数组的键是数据库的列名
        PDO::FETCH_NUM
            让fetch()和fetchAll()方法返回一个键为数字的数组。数组的键是数据库列在查询结果中的索引
        PDO::FETCH_BOTHx
            让fetch()和fetchAll()方法返回一个既有键为列名又有键为数字的数组。等于1,2结合
        PDO::FETCH_oBJ
            让fetch()和fetchAll()方法返回对象，对象的属性是数据库的列名
 */

//数据库事务 , 注:并不是所有数据库都支持事务
//事务可以提升性能，他将一系列的sql语句当成单个逻辑单元（具有原子性）执行，也就是说要么全都成功，要么全都不成功，原子性能保证数据的一致性、安全性和持久性。能把多个查询排成队列一次性执行
/**
 * $pdo->beginTransaction();
 * //数据操作，增删改查
 * $pdo->commit(); || $pdo->rollback();
 */