<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');
	
	/**
	 * Paginator settings
	 */
	public $paginate = array(
		'limit' => 10,
		'order' => array(
			'lower(User.name)' => 'asc'
		)
	);

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->set('title','Administration - Users');
		$this->Paginator->settings = $this->paginate;
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		$this->set('title_for_layout', 'Administration - ajouter un utilisateur');
		if ($this->request->is('post')) {
			$this->User->create();
			$this->request->data['User']['password'] = $this->passwordGenerator(10);
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('L\'utilisateur a bien été sauvegardé.<br />Le mot de passe de l\'utilisateur est : <b>'.$this->request->data['User']['password'].'</b>'),'notif');
				return $this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('L\'utilisateur n\'a pas été sauvegardé, veuillez réessayer.'), 'notif', array('type' => 'danger'));
			}
		}
		$userAsOneGroups = $this->User->UserAsOneGroup->find('list');
		$this->set(compact('userAsOneGroups'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'),'notif');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'notif');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$userAsOneGroups = $this->User->UserAsOneGroup->find('list');
		$this->set(compact('userAsOneGroups'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Utilisateur inconnu'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('L\'utilisateur a été supprimé.'), 'notif');
		} else {
			$this->Session->setFlash(__('L\'utilisateur n\'a pas été supprimé, veuillez réessayer.'), 'notif', array('type' => 'danger'));
		}
		return $this->redirect($this->referer());
	}
	
	
	/**
	 * login method
	 *
	 * @return void
	 */
	public function login() {
		$this->layout="login";
		$this->set('title','Connexion');
	}

	/**
	 * Generate a random password
	 *
	 * @param number $length
	 * @return string
	 */
	private function passwordGenerator ($length = 8) {
		$password = "";
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
		$maxlength = strlen($possible);
		if ($length > $maxlength) {
			$length = $maxlength;
		}
		$i = 0;
		while ($i < $length) {
			$char = substr($possible, mt_rand(0, $maxlength-1), 1);
			if (!strstr($password, $char)) {
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}
}
