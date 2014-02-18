<?php

class testDataResponse extends dataResponseIterator {
	
	
	public function current() {
	
		$object = new dataObj($this->current);
		
		$object->addMethod('uppercaseTitle', function($obj) {
			return strtoupper($obj->title);
		});
		
		$object->addMethod('boldTitle', function($obj) {
			return '<b>'. $obj->title .'</b>';
		});
		
		$object->bindPropEvent('get', 'title', function($obj) {
			return $obj->title('uppercase') .' #'. $obj->id;
		});
		
		return $object;
		
	}
	
	
}