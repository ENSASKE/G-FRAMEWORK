<?php
class baseModel extends SQLQuery {
    protected $_model;

    function __construct() {
        $this->connect(SERVIDOR,USUARIO,PASSWORD,BASEDATOS);
        $this->_limit = LIMITE_PAG;
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model);
        if (!isset($this->abstract)) {
            $this->_describe();
        }
    }

    function __destruct() {
    }
}
