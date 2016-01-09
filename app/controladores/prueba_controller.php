<?php

class PruebaController extends baseController {
    
    /*public function beforeAction () {

    }

    public function afterAction() {

    }*/

    public function index() {
        //performAction('inicio', 'index');
        /*$this->Product->id = $id;
        $this->Product->showHasOne();
        $this->Product->showHMABTM();
        $product = $this->Product->search();
        $this->set('product',$product);
        $this->Category->where('parent_id',$categoryId);*/

        //$this->Prueba->id = 1;
        //$this->Prueba->search();
        $this->set('titulo','Página de Prueba');
        $this->Prueba->test();
        echo "HOLA";

    }

    public function pruebaAjax(){
        $this->render = false;
        $objResponse = new xajaxResponse();

        return $objResponse->alert(1234123);
    }
        
        
}