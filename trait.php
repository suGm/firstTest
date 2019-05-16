<?php

namespace traitExample;

require '/usr/local/software/MFFC/vendor/autoload.php';

use willdurand\geocoder\Geocoder;

/**
 * php性状 是php 5.4.0导入的引入的概念
 * 例子 model-php中的商店和车子的列子，连个完全不相干的类都要用到导航地图的性状
 * 用性状是最优的方法
 */

trait Geocodable{

	protected $address;//类属性->地址

	protected $geocoder;//类属性->地理编码器对象

	protected $geocoderResult;//类属性->地理编码器处理后的结果对象

	/**
	 * [setGeocoder 注入Geocoder对象]
	 * @param \Geocoder\GeocoderInterface $geocoder [description]
	 */
	public function setGeocoder(\Geocoder\GeocoderInterface $geocoder){//导入地理编码器对象

		$this->geocoder = $geocoder;

	}

	/**
	 * [setAddress 设定地址]
	 * @param [type] $address [description]
	 */
	public function setAddress($address){

		$this->address = $address;

	}

	/**
	 * [getLatitude 获得纬度]
	 * @return [type] [description]
	 */
	public function getLatitude(){

		if(isset($this->geocoderResult) === false){
			$this->geocodeAddress();
		}

		return $this->geocoderResult->getLattitude();

	}

	/**
	 * [getLongitude 获得经度]
	 * @return [type] [description]
	 */
	public function getLongitude(){

		if(isset($this->geocoderResult) === false){
			$this->geocodeAddress();
		}

		return $this->geocoderResult->getLongitude();

	}

	/**
	 * [geocodeAddress 获取地理编码器结果]
	 * @return [type] [description]
	 */
	protected function geocodeAddress(){

		$this->geocoderResult = $this->geocoder->geocode($this->address);
		return true;

	}

}

//商店类
class RetailStore{

	use Geocodable;//导入性状 ps:命名空间、类、接口、函数和常量在类的定义体外导入，性状在类的定义体内导入

	//这里是类的实现方法

}

$geocoderAdapter = new \Geocoder\HttpAdapter\CurlHttpAdapter();
$geocoderProvider = new \Geocoder\Provider\GoogleMapsProvider($geocoderAdapter);
$geocoder = new \Geocoder\Geocoder($geocoderProvider);

$store = new RetailStore();
$store->setAddress('420 9th Avenue, New York, NY 10001 USA');
$store->setGeocoder($geocoder);

$latitude = $store->getLatitude();
$longitude = $store->getLongitude();

echo $latitude.':'.$longitude;
