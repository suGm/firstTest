<?php

/**
 * 接口创建与实现
 */

/**
 * 创建文本接口
 */
interface Documentable{

	public function getId();
	public function getContent();

}

/**
 * 创建文本类
 */
class DocumentStore{

	protected $data = [];

	public function addDocument(Documentable $document){

		$key = $document->getId();
		$value = $document->getContent();
		$this->data[$key]  = $value;

	}

	public function getDocuments(){

		return $this->data;

	}

}

/**
 * 远程获取html类
 */
class HtmlDocument implements Documentable{

	protected $url;

	public function __construct($url){

		$this->url = $url;

	}

	public function getId(){

		return $this->url;

	}

	public function getContent(){

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$this->url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 3);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch,CURLOPT_MAXREDIRS, 3);
		$html = curl_exec($ch);
		curl_close($ch);

		return $html;

	}

}

/**
 * 读取流资源类
 */
class StreamDocument implements Documentable{

	protected $resource;
	protected $buffer;

	public function __construct($resource,$buffer = 4096){

		$this->resource = $resource;
		$this->buffer = $buffer;

	}

	public function getId(){

		return  'resource-'.(int)$this->resource;

	}

	public function getContent(){

		$streamContent = '';
		rewind($this->resource);
		while(feof($this->resource) === false){
			$streamContent .= fread($this->resource, $this->buffer);
		}

		return $streamContent;

	}

}


/**
 * 获取终端命令执行结果
 */

class CommandOutputDocument implements Documentable{

	protected $command;

	public function __construct($command){

		$this->command = $command;

	}

	public function getId(){

		return $this->command;

	}

	public function getContent(){

		return shell_exec($this->command);

	}

}

$documentStore = new DocumentStore();

//添加html文档
$htmlDoc = new HtmlDocument('https://www.baidu.com');
$documentStore->addDocument($htmlDoc);

//添加流文档
$streamDoc = new StreamDocument(fopen('./stream.txt','rb'));
$documentStore->addDocument($streamDoc);

//添加终端执行命令
$cmdDoc = new CommandOutputDocument('cat /etc/hosts');
$documentStore->addDocument($cmdDoc);

var_dump($documentStore->getDocuments());

