<?php

class dataResponseIterator implements Iterator {

	protected $data;
	protected $current;
	
	public function __construct($data) {
		$this->data = $data;
	}
	
	public function getInstance($instanceName) {
		$class = strtolower($instanceName) . 'DataResponse';
		if(class_exists($class)) {
			return new $class($this->data);
		}
		return $this;
	}
	
	public function rewind() {
		$this->next();
	}
	
	public function valid() {
		return $this->current !== false;
	}
	
	public function key() {
		return $this->current['id'];
	}

	public function current() {
		return new dataObj($this->current);
	}
	
	public function next() {
		$this->current = mysql_fetch_assoc($this->data);
	}
	
	public function count() {
		if($this->data) {
			return mysql_num_rows($this->data);
		}
		return 0;
	}
	

}