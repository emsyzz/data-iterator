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
		if($this->__response) {
			return $this->__response;
		}
		return false;
	}
	
	public function exec($query) {
		if($query) {
			$this->__response = mysql_query($query);
		}
		return $this;
	}
	
	
	/*-< Public methods >-*/
	
	public static function multipleRows($query) {
		if($self = self::gi()->exec($query)->getData()) {
			$iterator = new dataResponse($self);
			return $iterator;
		}
		return array();
	}

}