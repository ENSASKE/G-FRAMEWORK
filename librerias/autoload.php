<?php

/** Check if environment is development and display errors **/

function setReporting() {
	if (DEV_ENV == true) {
		error_reporting(E_ALL);
		ini_set('display_errors','On');
	} else {
		error_reporting(E_ALL);
		ini_set('display_errors','Off');
		ini_set('log_errors', 'On');
		ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
	}
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
	$value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
	return $value;
}

function removeMagicQuotes() {

	if ( get_magic_quotes_gpc() ) {
		$_GET    = stripSlashesDeep($_GET   );
		$_POST   = stripSlashesDeep($_POST  );
		$_COOKIE = stripSlashesDeep($_COOKIE);
	}
}

/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

/** Secondary Call Function **/

function performAction($controller,$action,$queryString = array(),$render = 0) {	
    $controllerName = ucfirst($controller).'Controller';
    $dispatch = new $controllerName($controller,$action);
    $dispatch->render = $render;
    
    return call_user_func_array(array($dispatch,$action),$queryString);
}

/** Routing **/

function routeURL($url) {
    global $routing;

    foreach ( $routing as $pattern => $result ) {
        if ( preg_match( $pattern, $url ) ) {
            return preg_replace( $pattern, $result, $url );
        }
    }
    
    return ($url);
}

/** Main Call Function **/

function despachar() {
	global $url;
	global $default;

	$queryString = array();

	if (!isset($url)) {
		$controller = $default['controller'];
		$action = $default['action'];
	} else {
		$url = routeURL($url);
		$urlArray = array();
		$urlArray = explode("/",$url);
                
                if(end($urlArray) == ''){
                    array_pop($urlArray);
                }
                
		$controller = $urlArray[0];
		array_shift($urlArray);
		if (isset($urlArray[0])) {
			$action = $urlArray[0];
			array_shift($urlArray);
		} else {
			$action = 'index'; // Default Action
		}
		$queryString = $urlArray;
	}
	
	$controllerName = ucfirst($controller).'Controller';
	
	if ((int)class_exists($controllerName) && (int)method_exists($controllerName, $action)) {
		$dispatch = new $controllerName($controller,$action);
		
		call_user_func_array(array($dispatch,"beforeAction"),$queryString);
		call_user_func_array(array($dispatch,$action),$queryString);
		call_user_func_array(array($dispatch,"afterAction"),$queryString);
	} else {
		$controllerName = ucfirst($default['controller']).'Controller';
		$dispatch = new $controllerName($default['controller'],$default['action'], true);
		//echo "No existe ese controlador o funcion";
	}
}


/** Autoload any classes that are required **/

function __autoload($className) {
    
    if($className == "xajax"){
        require_once(ROOT . DS . 'librerias' . DS . 'xajax' . DS . 'xajax_core' . DS . 'xajax.inc.php');
    }

    if(file_exists(ROOT . DS . 'librerias' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'librerias' . DS . strtolower($className) . '.class.php');
    }else if(file_exists(ROOT . DS . 'app' . DS . 'controladores' . DS . cargarControlador($className) . '.php')) {
        require_once(ROOT . DS . 'app' . DS . 'controladores' . DS . cargarControlador($className) . '.php');
    }else if(file_exists(ROOT . DS . 'app' . DS . 'modelos' . DS . cargarModelo($className) . '.php')) {
        require_once(ROOT . DS . 'app' . DS . 'modelos' . DS . cargarModelo($className) . '.php');
    }else{
            /* Error Generation Code Here */
    }

}

function cargarControlador($className){
    $className = str_replace("Controller","_controller",$className);
    return strtolower($className);
}

function cargarModelo($className){
    $className = $className."_model";
    return strtolower($className);
}

$cache = new Cache();

setReporting();
removeMagicQuotes();
unregisterGlobals();
despachar();
