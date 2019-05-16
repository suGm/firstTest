<?php
namespace Oreilly\ModernPHP\Url;

class Scanner
{
    /**
     * array 一个由URL组成的数组
     */
    protected $urls;

    /**
     * \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * 构造方法
     * @param array $urls 一个要扫描的URL数组
     */
    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     * 获取死链
     */
    public function getInvalidUrls()
    {
        $invalidUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch (\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
            	array_push($invalidUrls, [
            	    'url' => $url,
            	    'status' => $statusCode
            	]);
            }
        }

        return $invalidUrls;
    }

    /**
     * 获取指定URL的HTTP状态码
     * @param string $url远程URL
     * @return int HTTP状态码
     */
    protected function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->option($url);

        return $httpResponse->getStatusCode();
    }
}