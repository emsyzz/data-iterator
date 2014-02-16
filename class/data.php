<?php

class dataObj extends stdClass {

	protected $__stack = array();
	
	public function __construct($data) {
		$this->__stack = $data;
	}
	
	public function __set($name, $value) {
		$this->__stack[$name] = $value;
	}
	
	public function __get($name) {
		if(isset($this->__stack[$name])) {
			return $this->__stack[$name];
		}
		return null;
	}

}