<?php

class mysqlObj {
	
	/*-< Singleton methods >-*/

	private static $__instance = null;
	
	public static function gi() {
		if(!self::$__instance) {
			self::$__instance = new self;
		}
		return self::$__instance;
	}
	
	
	/*-< Magic methods >-*/
	
	private function __contruct() {}
	private function __clone() {}
	
	
	/*-< Class methods >-*/
	
	private $__connection = null;
	
	private $__response = null;
	
	public function newConnection($host = 'localhost', $user = 'root', $password = '') {
		if(!$this->__connection) {
			$this->__connection = mysql_connect($host, $user, $password);
		}
		return $this;
	}
	
	public function setDatabase($databaseName) {
		mysql_select_db($databaseName,$this->__connection);
		return $this;
	}
	
	public function getData() {
		if($response = $this->__response) {
			$this->__response = null;
			return $response;
		}
		return false;
	}
	
	public function exec($query) {
		if($query && $response = mysql_query($query)) {
			$this->__response = $response;
			return true;
		}
		return false;
	}
	
	
	/*-< Public methods >-*/
	
	public static function multipleRows($query) {
		$self = self::gi();
		if($self->exec($query)) {
			return new dataResponse($self->getData());
		}
		return array();
	}

}