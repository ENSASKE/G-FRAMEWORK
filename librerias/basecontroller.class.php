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

        $this->_iniciarXajax();
    }

    function set($name,$value) {
        $this->_template->set($name,$value);
    }
    
    private function _iniciarXajax(){
        //INICIALIZACION XAJAX
        $this->xajax = new xajax();
        $this->objResponse = new xajaxResponse();
        
        //$this->xajax->register(XAJAX_CALLABLE_OBJECT, $this);//todos los metodos        
        $metodosObjeto = get_class_methods($this);
        foreach($metodosObjeto as $metodo){
            if(strpos(strtolower($metodo), 'ajax') !== false){
                $this->xajax->register(XAJAX_FUNCTION, array($metodo, $this, $metodo) );//solo metodos con palabra ajax
            }
        }
        
        //$this->xajax->register(XAJAX_FUNCTION, array('doReset', $this, 'doReset') );
        $this->xajax->processRequest();        
        $this->set('xajax', $this->xajax);
    }

    function __destruct() {
        if ($this->render) {
            $this->_template->render($this->sinHeader);
        }
    }
		
}