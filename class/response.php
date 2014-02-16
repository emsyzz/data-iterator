<?php

class dataResponse extends dataIteratorObj {

	protected $current;

	public function current() {
		return new dataObj($this->current);
	}

}