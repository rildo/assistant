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
	 * 	 1- Insert script or directory path
	 *   2- Select one or many scripts
	 *   3- Add them
	 *
	 *   /home/rildo/Documents/scripts/
	 *
	 * @return void
	 */
	public function add() {
		$step = 1;
		$scripts = array();
		$this->set('title_for_layout', 'Scripts - ajouter');
		if (!empty($this->request->data) && array_key_exists('scripts', $this->request->data) && array_key_exists('step', $this->request->data['scripts'])) {
			$step = $this->request->data['scripts']['step'];
		} else {
			$step = 1;
		}
		if ($this->request->is('post') & $step==1) {
			// check of the first step form
			// input is the scripts
			if (is_file($this->request->data['script'])) {
				$step = 3;
			// input is the directory
			} elseif (is_dir($this->request->data['script'])) {
				// Passage à l'étape de sélection des scripts à importer
				$step = 2;
				$globSearch = $this->request->data['script'].'/*.*';
				$globSearch = str_replace('//','/',$globSearch);
				$scripts = glob($globSearch);
			} else {
				$this->Session->setFlash(__('La valeur saisie ne correspond ni à un script, ni à un répertoire existant.'),'notif', array('type' => 'danger'));
			}
		} elseif($this->request->is('post') & $step==2) {
			foreach ($this->request->data('scripts') as $key => $value) {
				if (preg_match('#^(checked_scripts)#', $key)) {
					$scriptToAdd[] = $this->compose_script(base64_decode($value));
				}
			}
			$this->Script->create();
			if ($this->Script->saveMany($scriptToAdd)) {
				$this->Session->setFlash(__('Les scripts ont bien été ajoutés.'),'notif', array('type' => 'success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Les scripts n\'ont pas pu être ajoutés, veuillez réessayer unitairement.'),'notif', array('type' => 'danger'));
			}
		} else {
			$step = 1;
		}
		$this->set(compact('step'));
		$this->set(compact('scripts'));
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
			$this->Session->setFlash(__('Le script a bien été supprimé.'),'notif', array('type' => 'success'));
		} else {
			$this->Session->setFlash(__('Une erreur est survenue, le script n\'a pas été supprimé.'),'notif', array('type' => 'danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	private function compose_script ($script) {
		$infos = pathinfo($script);
		return  $script = array(
			'name' 				=> basename($script, '.'.$infos['extension']),
			'script_location' 	=> $script,
		);
	}
}
