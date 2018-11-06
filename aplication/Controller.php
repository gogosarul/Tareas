<?php

/** 
 * Jorge Luis Cruz Alcántara
 */


abstract class AppController
{


	protected $_view;

	public function __construct(){
		$this->_view = new View(new Request);
	}
	abstract function index();

	/** 
	 * Metodo que carga los moedlos en el controlador
	 * @param string $modelo  nombre del modelo
	 * @return object instancia de la clase
	 */


	protected function loadModel($modelo){
		$modelo = $modelo."Model";
		$rutaModelo = ROOT."models".DS.$modelo.".php";


		if (is_readable($rutaModelo)) {
		 	require_once($rutaModelo);
		 	$modelo = new $modelo;
		 	return $modelo;
		}else{
		 	throw new Exception("Error al cargar el modelo");
		}
	}

	/**
	 * Se encarga de redireccionar los modelos
	 * @param type|array $url array
	 * @return type
	 */

	public function redirect($url = array()){
		$path = "";
		if ($url["controller"]) {
			$path .= $url["controller"];
		}
		if ($url["action"]) {
			$path .="".$url["action"];
		}
		header("LOCATION: ".APP_URL.$path);
	}
}
