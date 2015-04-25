<?php

App::uses('AppController', 'Controller');

/**
 * CakePHP FilmsController
 * @author thomas
 */
class FilmsController extends AppController {

	public $paginate = array("limit" => 15);
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
		$this->set("userMovieNew", $this->Auth->user("movie_new"));
		
		$source = $this->Source->find("first", array("conditions" => array("user_id" => $this->Auth->user("id"))));
		if (!empty($source)) {
			try {
				$id = $source["Source"]["id"];
				$pg = (!empty($this->request->params["named"]) ? $this->request->params["named"]["page"] : 1);
				$lists = Cache::read("film".$id."_".$pg);
				if (empty($lists)) {
					$this->loadModel("Film", $id);
					$lists = $this->paginate("Film");
					Cache::write("paging".$id."_".$pg, $this->request->params["paging"]);
					Cache::write("film".$id."_".$pg, $lists);
				}
				else {
					$this->request->params["paging"] = Cache::read("paging".$id."_".$pg);
				}
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
