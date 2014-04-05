<?php

class testDataResponse extends dataResponseIterator {
	
	
	public function current() {
	
		$object = new dataObj($this->current);

        $object->bindPropEvent('get','title',function($obj){
            return $obj->title;
        });

        $object->bindPropEvent('get','tags',function($obj){
            return unserialize($obj->tags);
        });
        $object->bindPropEvent('set','tags',function($obj, $value){
            return $obj->tags = serialize($value);
        });
		
		$object->addMethod('uppercaseTitle', function($obj) {
			return strtoupper($obj->title);
		});
		
		$object->addMethod('boldTitle', function($obj) {
			return '<b>'. $obj->title .'</b>';
		});
		
		$object->bindPropEvent('call', 'title', function($obj) {
			return $obj->title('uppercase') .' #'. $obj->id;
		});
		
		return $object;
		
	}
	
	
}