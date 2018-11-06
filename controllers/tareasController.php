<?php

class tareasController extends AppController
{
	
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$tareas = $this->loadmodel("tarea");
		$this->_view->tareas = $tareas->getTareas();
		
		$this->_view->titulo = "Listado de tareas";
		$this->_view->renderizar("index");
	}

	/** 
	 * Metodo agregar datos a tarea
	 * @return $ths array
	 */

	public function agregar(){

		if ($_POST) {
			$tareas = $this->loadmodel("tarea");
			$this->_view->tareas = $tareas->guardar($_POST);
			$this->redirect(array("controller"=>"tareas"));
		}

		$categorias = $this->loadmodel("categoria");
		$this->_view->categorias = $categorias->listarTodo();

		$this->_view->titulo = "Agregar tarea";
		$this->_view->renderizar("agregar");
	}

	/** 
	 * Metodo editar
	 * @param type $id $_POST
	 * @return if
	 */

	public function editar($id=null){
		//print_r($id);
		//exit;
		if ($_POST) {
			$tareas = $this->loadmodel("tarea");
			
			
			if ($tareas->actualizar($_POST)) {
				$this->_view->flashMessage = "Datos guardados correctamente...";
				$this->redirect(array("controller"=>"tareas"));
			}else{
				$this->_view->flashMessage = "Error al guardar los datos...";

				$this->redirect(array("controller"=>"tareas", "action"=>"/editar/".$id));
			}
			
		}


		$tareas = $this->loadmodel("tarea");
		$this->_view->tarea = $tareas->buscarPorId($id);

		$categorias = $this->loadmodel("categoria");
		$this->_view->categorias = $categorias->listarTodo();

		$this->_view->titulo = "Editar tarea";
		$this->_view->renderizar("editar");
	}

	/** 
	 * Permte eliminar un producto
	 * @param type $id 
	 * @return tareas
	 */

	public function eliminar($id){
		$tarea = $this->loadmodel("tarea");
		$registro = $tarea->buscarPorId($id);

		if (!empty($registro)) {
			$tarea->eliminarPorId($id);
			$this->redirect(array("controller"=>"tareas"));
		}
	}

	public function cambiarEstado($id=null, $status=null){
		$tarea = $this->loadmodel("tarea");
		
		
		$tarea->status($id, $status);
		$this->redirect(array("controller"=>"tareas"));
	}
}