<?php

class PruebaController extends baseController {
	
	public function beforeAction () {

	}
	
	public function afterAction() {

	}

	public function index() {
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



	

}