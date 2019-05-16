<?php

//1、php流学习视频教程 Nomad PHP 网站中伊丽莎白史密斯的演讲（不是免费的英文版的,http://bit.ly/nomad-php）
//2、php文档(http://php.net/manual/en/book.stream.php)

//流在php 4.3.0引入，作用是 使用统一的方式来处理文件、网络和数据压缩等操作
//简而言之，流的作用是在出发地和目的地之间传输数据。出发地和目的地可以是文件、命令行进程、网络链接、ZIP或TAR压缩文件、临时内存、标准输入或输出，或者是通过PHP流封装协议（http://php.net/manual/wrappers.php）实现的任何其他资源
//读写文件就是使用流，如file_get_content()、fopen()、fgets()和fwrite()，就是提供了处理不同流资源(出发地和目的地)的统一接口
//可以把流理解为管道，相当于把水从一个地方引到另一个地方。在水从出发地流到目的地的过程中，我们可以过滤水，可以改变水质，可以添加水，可以排除水（数据）
/**
 * 
 */

//流封装协议
//流式数据的种类各异，每种类型需要独特的协议，以便读写数据。我们称这些协议为流封装协议（http://php.net/manual/wrappers.php）,我们可以读写文件系统，可以通过http,https或ssh（安全的shell）与远程web服务器通讯。还可以打开并读写ZIP、RAR和PHAR压缩文件，这些通讯方式都包含下述相同的过程:
// 1、开始通信
// 2、读取数据
// 3、写入数据
// 4、结束通信
// 每个流都有一个协议和一个目标。指定协议和目标的方法是使用流标识符，其格式如下所示，
// <scheme>://<target> 其中<scheme>是流封装协议，<target>是流的数据源。使用http流封装协议
/**例如: 使用http流封装协议创建一个与baidu通信
 * 
    $json = file_get_contents('http://www.baidu.com');//http不能省略 不然就不知道这个是什么协议了
    echo $json;
    注:http://www.baidu.com就是流封装的标识符，这里使用http协议使得流的目标看起来像是普通的url这是http协议这样规定的，其他流封装协议可能不是这样的
 */

//file://流封装协议
//我们平时使用的file_get_contents()、fopen()、fwrite()和fclose()函数读写文件系统前面没有协议是因为PHP默认协议是file:// 
/**例如 隐式使用file://流封装协议
 * $handle = fopen('/etc/hosts','rb');
 * while (feof($handle) !== true) {
 *     echo fgets($handle);
 * }
 * fclose($handle);
 * //显式使用file://流封装协议
   $handle = fopen('file:///etc/hosts','rb');
   while (feof($handle) !== true) {
       echo fgets($handle);
   }
   fclose($handle);
 */

//php://流封装协议
//该流的作用是与PHP脚本的标准输入、标准输出和标准错误文件描述符通信，可以使用PHP提供的文件系统函数打开、读取或写入下述四个流:
//    php://stdin
//        这是个只读php流，其中的数据来自标准输入，例如，php脚本可以使用这个流接收命令行传入脚本的信息
//    php://stdout
//        这个php流的作用是把数据写入当前的输出缓冲区。这个流只能写，无法读或寻址
//    php://memory
//        这个流的作用是从系统内存中读取数据，或把数据写入系统内存。这个php流的缺点是，可用内存是有限的。使用php://temp流会更加安全
//    php://temp
//        这个流的作用和上一个类似，不过，在没有内存时，php会把数据写入临时文件
/**
 * 
 */

//其他流封装协议
//php和php扩展还提供了很多其他的流协议，例如,与zip和tar严肃哦文件、ftp服务器、数据压缩库、亚马逊API等通讯的流封装协议，很多人认为fopen()、fgets()、fputs()、feof()和 fclose()只能处理文件系统中的文件，其实不然，这些函数能在所有支持流封装协议中使用
//关于php://流封装协议的更多信息 查看http://bit.ly/s-wrapper

//自定义流封装协议
//我们可以自己定义PHP流封装协议。PHP提供了一个示例streamWrapper类，演示如何编写自定义的流封装协议，更多参见:http://php.net/manual/class.streamwrapper.php , http://php.net/manual/stream.streamwrapper.example-1.php


//流上下文
//有些php流能接受一系列可选的参数，这些参数叫流上下文，用于制定流的行为，不同的流封装协议使用的上下文参数有所不同。流上下文使用 stream_context_create() 函数来创建 该函数返回的上下文对象可以传入大多是文件系统和流函数
/**例如:使用file_get_contents()函数发送http post请求
 * $requestBody = '{"username":"json"}';
 * $context = stream_context_create(array(
 *     'http' => array(
 *         'method' => 'POST',
 *         'header' => "Content-Type: application/json;charset=utf-8;\r\n" .
 *                     "Content-Length: " . mb_strlen($requestBody),
 *         'content' => $requesrtBody
 *     ),
 * ));
 * $response = file_get_contents('https://xxx', false, $context);
 * //流上下文是一个关联数组，最外层键是流封装协议的名称，流上下文数组中的值针对每个具体的流封装协议
 */


//流过滤器
//是指打开流之后，从流中读取数据并且过滤、转换、添加、删除流中传输的数据
/**
 * 例如:
 *    打开一个流处理Markdown文件，在把文件内如读入内存的过程中自动将其转换成HTML
 */
//php中有内置的几个流过滤器:string.rot13、string.toupper、string.tolower和string.strip_tags，这些过滤器没什么用，我们要使用自定义的过滤器
//1、如果想把过滤器加到现有的流上，要用stream_filter_append()函数
//2、使用php://filter流封装协议把过滤器添加到流上，不过这种方式需要先将PHP流打开
/**例:使用string.toupper过滤器将文件的内容转换成大写字母
   1、
 * $handle = fopen('stream.txt','rb');
   stream_filter_append($handle, 'string.toupper');
   while (feof($handle) !== true) {
       echo fgets($handle);
   }
   fclose($handle);
 * 2、
 * $handle = fopen('php://filter/read=string.toupper/resource=stream.txt','rb');
   while (feof($handle) !== true) {
       echo fgets($handle);
   }
   fclose($handle);
   //需要注意的是fopen()函数的第一个参数。这个参数的值php://是流封装协议的标识符，这个标识符的目标如下
       filter/read=<filter_name>/resource=<scheme>://<target>

   相对来说第二种方式比较繁琐，但是在某些PHP文件系统函数在调用后无法附加过滤器，如file()何fpassthru()。所以，使用这些函数时只能使用php://filter流封装协议附加流过滤器
 *
 * 例:使用ftp远程获取系统上的过去30天内某个域名的访问数据，日志文件名称为YYY-MM-DD.log.bz2
 * $dateStart = new \DateTime();//创建当天时间对象
   $dateInterval = \dateInterval::createFromDateString('-1 day');//创建反向实例，该时间操作为，当前时间回退前一天
   $datePeriod = new \DatePeriod($dateStart, $dateInterval, 30);//生成迭代实例，为当前时间反向倒序往前迭代30天
   foreach ($datePeriod as $date) {//循环获取时间实例
	   $file = 'sftp://USER:PASS@rsync.net/' . $date->format('Y-m-d') . '.log.bz2';//使用sft流封装协议打开位于rsync.net上的日志文件

	   if (file_exists($file)) {
           $handle = fopen($file,'rb');//打开文件
           stream_filter_append($handle, 'bzip2.decompress');//将bzip2.decompress流过滤器附加到日志文件流资源上，实时解压biz格式的目标文件
           while (feof($handle) !== true) {
               $line = fgets($handle);//读取文件
               if (strpos($line, 'www.baidu.com') !== false) {//检查各行日志是否有baidu的域名
                   fwrite(STDOUT, $line);//将这行日志写入标准输出
               }
           }
           fclose($handle);
	   }
   }
   注:还可以用shell_exec()或bzdecompress()函数，手动把日志文件解压缩到临时目录中，然后迭代解压缩后的文件
 */




//自定义流过滤器
//其实大多数情况下都要使用自定义的流过滤器，自定义的流过滤器是一个PHP类，扩展内置的php_user_filter类。这个类必需实现filter()、onCreate()和onClose()方法,而且必需使用strem_filter_register()函数注册自定义的流过滤器
//注:php流会把数据分成按次序排列的桶，一个桶中盛放的数据量是固定的(例如4096字节)。如果还是用管道比喻，那么就是把水放在一个个水桶中，顺着管道从出发地顺着管道漂流到目的地，在漂流过程中会经过流过滤器，流过滤器一次能接受并处理一个或多个桶。一定时间内过滤器接收到的桶叫做桶队列

//下面我们来创建一个php自定义流过滤器
//例:在把流中的数据读入内存时审查其中的脏字
/**
 * 1、创建一个PHP类，让他扩展php_user_filter类
 * 2、这个类必需实现filter()方法，这个方法是个筛子，用于过滤流经的桶，这个方法的参数是上游飘来的桶队列
 * 3、处理过队列中的每个桶对象后，再把桶排成一排向下游的目的地飘去
 */
//{{{
class DirtyWordsFilter extends php_user_filter
{   
	/**
	 * [filter description]
	 * @author sgm
	 * @DateTime 2019-05-08T08:23:56+0800
	 * @param    [resource]              $in        [流来的桶队列]
	 * @param    [resource]              $out       [流走的桶队列]
	 * @param    [int]                   &$consumed [处理的字节数]
	 * @param    [bool]                  $closing   [是流中的最后一个桶队列吗？]
	 * @return   [type]                              [description]
	 */
    public function filter($in, $out, &$consumed, $closing)
    {
        $words =array('fuck','grease','a');
        $wordData = array();
        foreach ($words as $word) {
            $replacement = array_fill(0, mb_strlen($word), '*');//array_fill 返回的是一个数组
            $wordData[$word] = implode('', $replacement);
        }
        $bad = array_keys($wordData);
        $good = array_values($wordData);

        //迭代流来的桶队列中的每个桶
        while ($bucket = stream_bucket_make_writeable($in)) {
            //审查桶数据中的脏字
            $bucket->data = str_replace($bad, $good, $bucket->data);

            //增加已处理的数据量
            $consumed += $bucket->datalen;

            //把桶放入流向下游的队列中
            stream_bucket_append($out,$bucket);
        }
        return PSFS_PASS_ON;
    }
}

//filter()方法作用是接收、处理再转运桶中的流数据。在filter()方法中，我们迭代桶队列$in中的桶，把脏字替换成审查后的值。这个方法的返回值是PSFS_PASS_ON常量，表示操作成功，这个方法接收四个参数
/**
 * 1、$in
 *     上流飘来的一个队列，有一个或多个桶，桶中是从出发地飘来的数据
 * 2、$out
 *     由一个桶或多个桶组成的队列，流向下游的流目的地
 * 3、&$consumed
 *     自定义的过滤器处理的流数据总字节数
 * 4、$closing
 *     filter()方法接收的是最后一个桶队列吗
 */
//}}}

//然后我们需要用stream_filter_register()函数来注册这个自定义的过滤器(DirtWordsFilter)
//例:
stream_filter_register('dirty_words_filter', 'DirtyWordsFilter');//第一个参数用于识别过滤器名，第二个参数是这个自定义过滤器的类名

$handle = fopen('stream.txt','rb');
stream_filter_append($handle,'dirty_words_filter');
while (feof($handle) !== true) {
    echo fgets($handle);
}
fclose($handle);





