<?php
App::uses('AppController', 'Controller');
/**
 * Scripts Controller
 *
 * @property Script $Script
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ScriptsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Script->recursive = 0;
		$this->set('scripts', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Script->exists($id)) {
			throw new NotFoundException(__('Invalid script'));
		}
		$options = array('conditions' => array('Script.' . $this->Script->primaryKey => $id));
		$this->set('script', $this->Script->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Script->create();
			if ($this->Script->save($this->request->data)) {
				$this->Session->setFlash(__('The script has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The script could not be saved. Please, try again.'));
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
		if (!$this->Script->exists($id)) {
			throw new NotFoundException(__('Invalid script'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Script->save($this->request->data)) {
				$this->Session->setFlash(__('The script has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The script could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Script.' . $this->Script->primaryKey => $id));
			$this->request->data = $this->Script->find('first', $options);
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
		$this->Script->id = $id;
		if (!$this->Script->exists()) {
			throw new NotFoundException(__('Invalid script'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Script->delete()) {
			$this->Session->setFlash(__('The script has been deleted.'));
		} else {
			$this->Session->setFlash(__('The script could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
