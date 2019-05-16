<?php

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
/**例如: 使用http流封装协议创建一个与Flickr API通信
 * 
 */
$json = file_get_contents('http://api.flickr.com/services/feeds/photos_public.gne?format=json');
echo $json;