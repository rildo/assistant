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
	 * Method to add scripts
	 *
	 * Steps :
	 * 	 1-
	 *
	 * @return void
	 */
	public function add() {
		$this->set('title_for_layout', 'Scripts - ajouter');
		$step = 1;
		if ($this->request->is('post') & $step==1) {
			// check of the first step form
			// input is the scripts
			if (is_file($this->request->data['script'])) {
				$this->set('step', 3);
			// input is the directory
			} elseif (is_dir($this->request->data['script'])) {
				// Passage à l'étape de sélection des scripts à importer
				$this->set('step', 2);
				$scripts = glob($this->request->data['script'].'/*.*');
				$this->set(compact('scripts'));
			} else {
				$this->Session->setFlash(__('La valeur saisie ne correspond ni à un script, ni à un répertoire existant.'),'notif', array('type' => 'danger'));
			}
// 			$this->Script->create();
// 			if ($this->Script->save($this->request->data)) {
// 				$this->Session->setFlash(__('The script has been saved.'));
// 				return $this->redirect(array('action' => 'index'));
// 			} else {
// 				$this->Session->setFlash(__('The script could not be saved. Please, try again.'));
// 			}
		} else {
			$this->set('step', 1);
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
