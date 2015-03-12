<?php
App::uses('AppController', 'Controller');
/**
 * Sources Controller
 *
 * @property Sources $Source
 * @property PaginatorComponent $Paginator
 */
class SourcesController extends AppController {
	
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator',"Crypt");

	/**
	 * Paginator settings
	 * @var unknown
	 */
	public $paginate = array(
		'limit' => 10,
		'order' => array(
			'Source.name' => 'asc'
		)
	);
	
	private $produits = array(
		1 => "Xbmc"
	);

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->set('title_for_layout', 'Administration - Sources');
		$this->Source->recursive = 0;
		$this->set('sources', $this->paginate(array(
			"user_id" => $this->Auth->user("id")
		)));
	}

	/***
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->set('title_for_layout', 'Administration - Sources');
		if (!$this->Source->exists($id)) {
			throw new NotFoundException(__('Source inconnu'));
		}
		$options = array('conditions' => array('Source.' . $this->Source->primaryKey => $id));
		$this->set('source', $this->Source->find('first', $options));
	}
	
	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->request->data;
			$data["Source"]["user_id"] = $this->Auth->user("id");
			if (!empty($data["Source"]["type_id"]) && isset($data["config".$data["Source"]["type_id"]])) {
				if (!empty($data["config".$data["Source"]["type_id"]]["password"])) {
					$data["config".$data["Source"]["type_id"]]["password"] = $this->Crypt->crypt($data["config".$data["Source"]["type_id"]]["password"]); 
				}
				$data["Source"]["config"] = serialize($data["config".$data["Source"]["type_id"]]);
			}
			if ($this->Source->save($data)) {
				if ($this->request->is('post')) {
					$this->Session->setFlash(__("La source a été ajouté."),'notif');
				}
				else {
					$this->Session->setFlash(__("Les modifications sont sauvegardées."),'notif');
				}
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La source n\'a pas été enregistré, veuillez vérifier la saisie.'),'notif', array('type' => 'danger'));
			}
		} else {
			if ($id==null) {
				$this->set("title", "Ajout d'une source");
			}
			else {
				$options = array('conditions' => array('Source.' . $this->Source->primaryKey => $id));
				$this->request->data = $this->Source->find('first', $options);
				$keyConfig = "config".$this->request->data["Source"]["type_id"];
				$this->request->data[$keyConfig] = unserialize($this->request->data["Source"]["config"]);
				if (isset($this->request->data[$keyConfig]["password"])) {
					$this->request->data[$keyConfig]["password"] = $this->Crypt->decrypt($this->request->data[$keyConfig]["password"]);
				}
				$this->set("title", "Modifier la source : ".$this->request->data["Source"]["name"]);
			}
			$this->set("types", $this->Source->SourceAsOneType->find("list"));
			$this->set("produits", $this->produits);
			$this->set('title_for_layout', 'Administration - '.$this->viewVars["title"]);
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->Source->id = $id;
		if (!$this->Source->exists()) {
			throw new NotFoundException(__('Soruce inconnu'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Source->delete()) {
			$this->Session->setFlash(__("La source a été supprimé."),'notif');
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__("Impossible de supprimer la source. Veuillez réessayer."),'notif', array('type' => 'danger'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
