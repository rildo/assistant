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

	/**
	 * index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->set('title_for_layout', 'Administration - Sources');
		$this->Paginator->settings = $this->paginate;
		$this->Source->recursive = 0;
		$this->set('sources', $this->Paginator->paginate());
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
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		$this->set('title_for_layout', 'Administration - Ajouter une source');
		if ($this->request->is('post')) {
			$this->Source->create();
			if ($this->Source->save($this->request->data)) {
				$this->Session->setFlash(__("La source a été ajouté."),'notif');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La source n\'a pas été créé, veuillez vérifier la saisie.'),'notif', array('type' => 'danger'));
			}
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		$crypt = $this->Crypt->crypt("dqdqsdsqdqs");
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->request->data;
			if (!empty($data["Source"]["type_id"]) && isset($data["config".$data["Source"]["type_id"]])) {
				if (!empty($data["config".$data["Source"]["type_id"]]["pass"])) {
					$data["config".$data["Source"]["type_id"]]["pass"] = $this->Crypt->crypt($data["config".$data["Source"]["type_id"]]["pass"]); 
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
				if (isset($this->request->data[$keyConfig]["pass"])) {
					$this->request->data[$keyConfig]["pass"] = $this->Crypt->decrypt($this->request->data[$keyConfig]["pass"]);
				}
				$this->set("title", "Modifier la source : ".$this->request->data["Source"]["name"]);
			}
			$this->set("types", $this->Source->SourceAsOneType->find("list"));
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
	public function admin_delete($id = null) {
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
