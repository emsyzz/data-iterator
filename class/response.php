<?php

class dataResponse extends dataIteratorObj {

	protected $data;
	protected $current;

	public function current() {
		return new dataObj($this->current);
	}
	
	public function count() {
		if($this->data) {
			return mysql_num_rows($this->data);
		}
		return 0;
	}

}