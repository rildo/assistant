<?php
App::uses('AppController', 'Controller');
/**
 * Groups Controller
 *
 * @property Group $Group
 * @property PaginatorComponent $Paginator
 */
class GroupsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');

	/**
	 * Paginator settings
	 * @var unknown
	 */
	public $paginate = array(
		'limit' => 10,
		'order' => array(
			'Group.name' => 'asc'
		)
	);

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->set('title_for_layout', 'Administration - groupes');
		$this->Paginator->settings = $this->paginate;
		$this->Group->recursive = 0;
		$this->set('groups', $this->Paginator->paginate());
	}

	/***
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		$this->set('title_for_layout', 'Administration - groupe');
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Groupe inconnu'));
		}
		$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
		$this->set('group', $this->Group->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		$this->set('title_for_layout', 'Administration - ajouter un groupe');
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__("Le groupe a été ajouté."),'notif');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Le groupe n\'a pas été créé, veuillez vérifier la saisie.'),'notif', array('type' => 'danger'));
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
	public function edit($id = null) {
		$this->set('title_for_layout', 'Administration - modifier un groupe');
		if (!$this->Group->exists($id)) {
			throw new NotFoundException(__('Groupe inconnu'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Group->save($this->request->data)) {
				$this->Session->setFlash(__("Les modifications sont sauvegardées."),'notif');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Le groupe n\'a pas été modifié, veuillez vérifier la saisie.'),'notif', array('type' => 'danger'));
			}
		} else {
			$options = array('conditions' => array('Group.' . $this->Group->primaryKey => $id));
			$this->request->data = $this->Group->find('first', $options);
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
		$this->Group->id = $id;
		if (!$this->Group->exists()) {
			throw new NotFoundException(__('Groupe inconnu'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Group->delete()) {
			$this->Session->setFlash(__("Le groupe a été supprimé."),'notif');
			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__("Impossible de supprimer le groupe. Veuillez réessayer."),'notif', array('type' => 'danger'));
			$this->redirect(array('action' => 'index'));
		}
	}
}
