<?php

class dataIteratorObj implements Iterator {
	
	private $orgin;
	private $data;
	protected $key = 0;
	protected $current;

	public function __construct($data) {
		$this->orgin = $data;
	}
	
	public function rewind() {
		$this->data = $this->orgin;
		$this->next();
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