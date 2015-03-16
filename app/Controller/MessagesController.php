<?php

App::uses('AppController', 'Controller');

/**
 * CakePHP MessagesController
 * @author thomas
 */
class MessagesController extends AppController {

	public function index() {
		$lists = $this->Message->find("all", array("conditions" => array("user_id" => $this->Auth->user("id"))));
		
		$this->set(compact("lists"));
	}

	public function read($id=null) {
		if (!empty($id)) {
			if ($id=="all") {
				$this->Message->updateAll(array("read" => 1), array("user_id" => $this->Auth->user("id")));
			}
			else {
				$this->Message->updateAll(array("read" => 1), array("Message.id" => $id));
			}
		}	
		$this->autoRender = false;
		$this->redirect(array("controller" => "messages", "action" => "index"));
	}
	
	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$this->request->allowMethod('post', 'delete');
		if ($id=="all") {
			$this->Message->deleteAll(array("user_id" => $this->Auth->user("id")));
		}
		else {
			$this->Message->id = $id;
			if (!$this->Message->exists()) {
				throw new NotFoundException(__('Invalid message'));
			}
			if ($this->Message->delete()) {
				$this->Session->setFlash(__('Le message a été supprimé.'));
			} else {
				$this->Session->setFlash(__('Le message n\'a pas été supprimé. Merci de reessayer ultérieurement.'));
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

	
}

