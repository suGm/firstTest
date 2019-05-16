<?php

/*
    composer组件的应用 列1 扫描URL应用 用到 guzzlehttp/guzzle 和 league/csv
 */

//1、使用composer自动加载器
require '/usr/local/software/MFFC/vendor/autoload.php';

//2、实例Guzzle HTTP 客户端
$client = new \GuzzleHttp\Client();

//3、打开并迭代处理CSV
$csv = new \League\Csv\Reader($argv[1]);

foreach ($csv as $csvRow) {
    try {
        //4、发送HTTP OPTIONS请求
        $httpResponse = $client->option($csvRow[0]);

        //5、检查HTTP响应的状态码
        if ($httpResponse->getStatusCode() >= 400) {
            throw new \Exception();
        }
    } catch (\Exception $e) {
        //6、把死链发给标准输出
        echo $csvRow[0] . PHP_EOL;
    }
}
