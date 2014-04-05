<?php

class dataObj extends stdClass {

	/** Protected properties *************************************************/

    /** Object property values
     * @var array */
    protected $__data = array();
    /** Object user methods
     * @var Closure[] */
    protected $__func = array();
    /** Object event state
     * @var array */
    protected $__events = array();
	
	
	/** Magic methods **/

    /**
     * @param array $data
     * @param Closure[] $func
     * @param array $events
     */
    public function __construct(array $data, $func = array(), $events = array()) {
		$this->__data = $data;
		$this->__func = $func;
		$this->__events = $events;
	}

    /**
     * @param String $name
     * @param array $arg
     * @return mixed|null
     */
    public function __call($name, $arg) {
		if($this->__issetMethod($name)) {
			return $this->__callUserMethod($name, $arg);
		} elseif($this->__issetProperty($name)) {
			if(!empty($arg) && $this->__issetMethod($arg[0] . ucfirst($name))) {
				return $this->__callUserMethod($arg[0] . ucfirst($name), array());
			} else {
				if($this->__issetPropEvent('call',$name) && !$this->__isRecursivePropEvent('call',$name))
					return $this->__triggerPropEvent('call', $name);
				else
					return $this->__getPropValue($name);
			}
		}
		return null;
	}

    /**
     * @param String $name
     * @param mixed $value
     * @return mixed
     */
    public function __set($name, $value) {
		if($this->__issetPropEvent('set',$name) && !$this->__isRecursivePropEvent('set',$name)) {
			$value = $this->__triggerPropEvent('set', $name, array(1=>$value));
		}
		return $this->__data[$name] = $value;
	}

    /**
     * @param String $name
     * @return mixed|null
     */
    public function __get($name) {
		if($this->__issetProperty($name)) {
            if($this->__issetPropEvent('get',$name) && !$this->__isRecursivePropEvent('get',$name))
                return $this->__triggerPropEvent('get', $name);
            else
                return $this->__getPropValue($name);
		}
		return null;
	}
	
	
	/** Private methods ******************************************************/
	
	private function __callUserMethod($name, $arg) {
	
		if(isset($this->__func[$name])) {
		
			if(!$this->__isPropEvent($name)) {
				$arg = array($this) + $arg;
			}
			
			return call_user_func_array($this->__func[$name], $arg);
			
		}
		die('Method "'. $name .'" is not defined!');
		
	}
	
	private function __issetProperty($name) {
	
		return (bool) isset($this->__data[$name]);
		
	}
	
	private function __getPropValue($property) {
	
		if(isset($this->__data[$property])) {
		
			return $this->__data[$property];
			
		}
		
		return null;
	}
	
	private function __issetMethod($methodName) {
	
		return (bool) (method_exists($this, $methodName) || isset($this->__func[$methodName]));
		
	}
	
	private function __issetPropEvent($eventName, $property) {
	
		return (bool) $this->__issetMethod($this->__getPropEventName($eventName, $property));
		
	}
	
	private function __isPropEvent($name) {
	
		return (bool) isset($this->__events[$name]);
		
	}
	
	private function __isRecursivePropEvent($eventName, $property) {
		
		$eventMethodName = $this->__getPropEventName($eventName, $property);
		
		return (bool) isset($this->__events[$eventMethodName]) ? $this->__events[$eventMethodName] : true;
		
	}
	
	private function __getPropEventName($eventName, $property) {
	
		return '__propEvent'. ucfirst(strtolower($eventName)) . ucfirst(strtolower($property));
		
	}
	
	private function __triggerPropEvent($eventName, $property, $arg = array()) {
	
		$eventMethodName = $this->__getPropEventName($eventName, $property);
		
		if(property_exists($this, $property))
			die('Can not overwrite property "'. $property .'"!');
			
		$this->__events[$eventMethodName] = true;
			
		$that = new self($this->__data, $this->__func, $this->__events);
		
		$this->__events[$eventMethodName] = false;
		
		return $this->__callUserMethod($eventMethodName, array($that) + $arg);
		
	}
	
	
	/** Public methods *******************************************************/

	public function addMethod($methodName, $function) {
		if(!$this->__issetMethod($methodName) && is_callable($function)) {
			$this->__func[$methodName] = $function;
		}
	}
	
	public function bindPropEvent($eventName, $property, $function) {
		$eventMethodName = $this->__getPropEventName($eventName, $property);
		if(!$this->__issetMethod($eventMethodName)) {
			$this->__events[$eventMethodName] = false;
			$this->addMethod($eventMethodName, $function);
		}
	}
	
}