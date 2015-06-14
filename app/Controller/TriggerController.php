<?php
App::uses('AppController', 'Controller');
App::uses('CronManager', 'Lib');

/**
 * Insert description here
 *
 * @author rildo
 */
class TriggerController extends AppController {
	
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Session');

	/**
	 * Create a trigger for a script
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function add ($id = null) {
		App::import('model','Script');
		$script = new Script();
		if (!$script->exists($id)) {
			throw new NotFoundException(__('Script inconnu.'));
		}
		if ($this->request->is('post')) {
			$this->request->data['Trigger']['type'] = 'script';
			$this->request->data['Trigger']['script_id'] = $id;
			
			// Related script
			$options = array('conditions' => array('Script.' . $script->primaryKey => $id));
			$relatedScript = $script->find('first', $options);
			
			// CRON creation
			// CRON already exists
			if (!$this->Trigger->isUnique(array(
					'Trigger.minute' => $this->request->data['Trigger']['minute'],
					'Trigger.hour' => $this->request->data['Trigger']['hour'],
					'Trigger.day' => $this->request->data['Trigger']['day'],
					'Trigger.month' => $this->request->data['Trigger']['month'],
					'Trigger.weekday' => $this->request->data['Trigger']['weekday'],
					'Trigger.script_id' => $id), false)
			) {
				$this->Session->setFlash(__('Ce déclencheur existe déjà pour ce script.'),'notif', array('type' => 'danger'));
				// Redirect to the edit page
				return $this->redirect(array('controller' => 'Scripts', 'action' => 'edit', $id));
			// Save
			} elseif ($this->addTrigger($relatedScript) && $this->Trigger->save($this->request->data)) {
				$this->Session->setFlash(__('Le déclencheur a bien été ajouté.'),'notif', array('type' => 'success'));
				// Redirect to the edit page
				return $this->redirect(array('controller' => 'Scripts', 'action' => 'edit', $id));
			// Save failed
			} else {
				$this->Session->setFlash(__('Les modifications n\'ont pu être sauvegardées, veuillez réessayer.'),'notif', array('type' => 'danger'));
				// Redirect to the edit page
				return $this->redirect(array('controller' => 'Scripts', 'action' => 'edit', $id));
			}
		} else {
			$this->Session->setFlash(__('Une erreur est survenue lors de l\'ajout d\'un déclencheur.'),'notif', array('type' => 'danger'));
			return $this->redirect(array('controller' => 'Scripts', 'action' => 'edit', $id));
		}
	}
	
	/**
	 * Add CRON job into crontab
	 * @param array $data
	 * @param array $script
	 */
	private function addTrigger ($script = null) {
		try {
			$cron = $this->request->data['Trigger']['minute'].' '.
					$this->request->data['Trigger']['hour'].' '.
					$this->request->data['Trigger']['day'].' '.
					$this->request->data['Trigger']['month'].' '.
					$this->request->data['Trigger']['weekday'].' '.
					'php '.APP_DIR.'Console'.DS.'cake.php script launch ';
			$cronManager = new CronManager();
			$cronManager->append_cronjob($cron);
		} catch (Exception $e) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null) {
		$patterns = array('/\*/','/\//','/\"/');
		$replacement = array('\\*','\\/','\\"');
		
		$this->Trigger->id = $id;
		if (!$this->Trigger->exists()) {
			throw new NotFoundException(__('Trigger inconnu.'));
		}
		$options = array('conditions' => array('Trigger.' . $this->Trigger->primaryKey => $id));
		$trigger = $this->Trigger->find('first', $options);

		// manage CRON delete
		try {
			$cron = '/'.preg_replace($patterns, $replacement,
					$trigger['Trigger']['minute'].' '.
					$trigger['Trigger']['hour'].' '.
					$trigger['Trigger']['day'].' '.
					$trigger['Trigger']['month'].' '.
					$trigger['Trigger']['weekday'].' '.
					$trigger['Script']['prefix'].' '.$trigger['Script']['script_location'].' '.$trigger['Script']['suffix']).'/';
			
			$cronManager = new CronManager();
			$cronManager->remove_cronjob($cron);
		} catch (Exception $e) {
			$this->Session->setFlash(__('Une erreur est survenue, le déclencheur n\'a pas été supprimé.'),'notif', array('type' => 'danger'));
			return $this->redirect(array('controller' => 'scripts', 'action' => 'edit', $trigger['Script']['id']));
		}
		
		$this->request->allowMethod('post', 'delete');
		if ($this->Trigger->delete()) {
			$this->Session->setFlash(__('Le déclencheur a bien été supprimé.'),'notif', array('type' => 'success'));
			return $this->redirect(array('controller' => 'scripts', 'action' => 'edit', $trigger['Script']['id']));
		} else {
			$this->Session->setFlash(__('Une erreur est survenue, le déclencheur n\'a pas été supprimé.'),'notif', array('type' => 'danger'));
			return $this->redirect(array('controller' => 'scripts', 'action' => 'edit', $trigger['Script']['id']));
		}
		return $this->redirect(array('','action' => 'index'));
	}
	
}