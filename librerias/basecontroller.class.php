<?php

class baseController {
	
	protected $_controller;
	protected $_action;
	protected $_template;

	public $sinHeader;
	public $render;

	function __construct($controller, $action, $sinModelo = false) {
		
		$this->_controller = ucfirst($controller);
		$this->_action = $action;
		
		$model = ucfirst($controller);
		$this->sinHeader = 0;
		$this->render = 1;
		if(!$sinModelo){
			$this->$model = new $model();	
		}
		
		$this->_template = new Template($controller,$action);

	}

	function set($name,$value) {
		$this->_template->set($name,$value);
	}

	function __destruct() {
		if ($this->render) {
			$this->_template->render($this->sinHeader);
		}
	}
		
}