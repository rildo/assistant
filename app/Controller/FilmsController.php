<?php

App::uses('AppController', 'Controller');

/**
 * CakePHP FilmsController
 * @author thomas
 */
class FilmsController extends AppController {

	/**
	 * Model
	 * 
	 * @var array
	 */
	public $uses = array("Source");
	
	/**
	 * Index Film
	 * 
	 * @return void
	 */
	public function index() {
		$source = $this->Source->find("first", array("conditions" => array("user_id" => $this->Auth->user("id"))));
		if (!empty($source)) {
			try {
				$this->loadModel("Film", $source["Source"]["id"]);
				$lists = $this->Film->find("all");
				$this->set(compact("lists"));
			}
			catch (Exception $e) {
				$this->loadModel("Message");
				$data = array(
					"name" => "Connexion à la source de film erroné",
					"message" => $e->getMessage(),
					"date" => date("Y-m-d H:i:s"),
					"user_id" => $this->Auth->user("id")
				);
				$this->Message->create($data);
				$this->Message->save($data);
			}
		}
	}

}
