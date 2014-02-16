<?php

class dataIteratorObj implements Iterator {
	
	protected $data;
	protected $key = 0;
	protected $current;

	public function __construct($data) {
		$this->data = $data;
	}
	
	public function rewind() {
		$this->next();
		$this->key = 0;
	}
	
	public function key() {
		return $this->key;
	}
	
	public function current() {
		return $this->current;
	}
	
	public function next() {
		$this->current = mysql_fetch_assoc($this->data);
		$this->key++;
	}
	
	public function valid() {
		return $this->current !== false;
	}
 
}