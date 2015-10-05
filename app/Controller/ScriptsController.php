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
    public $uses = array('Script','Trigger', 'ScriptLog');

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
		$this->Script->recursive = 1;
		$this->set('scripts', $this->Paginator->paginate());
	}

	private $choiceMinutes = array(
		'-- Valeurs prédéfinies --',
		':*' 		=> 'Toutes les minutes (*)',
		':*/5' 		=> 'Toutes les 5 minutes (*/5)',
		':*/10' 	=> 'Toutes les 10 minutes (*/10)',
		':*/15' 	=> 'Toutes les 15 minutes (*/15)',
		':*/30' 	=> 'Toutes les 30 minutes (*/30)',
		'-- Minutes --'
	);

	private $choiceHours = array(
		'-- Valeurs prédéfinies --',
		':*' 	=> 'Toutes les heures (*)',
		':*/3' 	=> 'Toutes les 3 heures (*/3)',
		':*/6' 	=> 'Toutes les 6 heures (*/6)',
		':*/12' 	=> 'Toutes les 12 minutes (*/12)',
		':0,12' 	=> 'Deux fois par jour (0,12)',
		'-- Minutes --'
	);

	private $choiceDays = array(
		'-- Valeurs prédéfinies --',
		':*' 	=> 'Tous jours (*)',
		':*/2' 	=> 'Tous les 2 jours (*/2)',
		':*/3' 	=> 'Tous les 3 jours (*/3)',
		'-- Jours --'
	);

	private $choiceMonths = array(
		'-- Valeurs prédéfinies --',
		':*' 		=> 'Tous mois (*)',
		':*/2' 		=> 'Tous les 2 mois (*/2)',
		':*/3' 		=> 'Chaque trimestre (*/3)',
		':1,7' 		=> 'Tous les 6 jours (1,7)',
		'-- Mois --',
		':1'		=> 'Janvier (1)',
		':2'		=> 'Février (2)',
		':3'		=> 'Mars (3)',
		':4'		=> 'Avril (4)',
		':5'		=> 'Mai (5)',
		':6'		=> 'Juin (6)',
		':7'		=> 'Juillet (7)',
		':8'		=> 'Août (8)',
		':9'		=> 'Septembre (9)',
		':10'		=> 'Octobre (10)',
		':11'		=> 'Novembre (11)',
		':12'		=> 'Décembre (12)'
	);

	private $choiceWeekday = array(
		'-- Valeurs prédéfinies --',
		':*'	=> 'Tous les jours de la semaine (*)',
		':1-5'	=> 'Jours ouvrés (1-5)',
		':6,0' 	=> 'Weekend (6,0)',
		'-- Jours --',
		':1' 	=> 'Lundi (1)',
		':2' 	=> 'Mardi (2)',
		':3' 	=> 'Mercredi (3)',
		':4' 	=> 'Jeudi (4)',
		':5' 	=> 'Vendredi (5)',
		':6' 	=> 'Samedi (6)',
		':0' 	=> 'Dimanche (0)'
	);

	private $commonSettings = array(
		'-- Valeurs prédéfinies --',
		'* * * * *' 		=> 'Toutes les minutes (* * * * *)',
		'*/5 * * * *' 		=> 'Toutes les 5 minutes (*/5 * * * *)',
		'0,30 * * * *' 		=> 'Deux fois par heure (0,30 * * * *)',
		'0 * * * *' 		=> 'Une fois par heure (0 * * * *)',
		'0 0,12 * * *' 		=> 'Deux fois par jour (0 0,12 * * *)',
		'0 0 * * 1-5' 		=> 'Les jours ouvrés (0 0 * * 1-5)',
		'0 0 * * *' 		=> 'Tous les jours à minuit (0 0 * * *)',
		'0 0 * * 0' 		=> 'Une fois par semaine (0 0 * * 0)',
		'0 0 1,15 * *' 		=> 'Le 1er et le 15 du mois (0 0 1,15 * *)',
		'0 0 1 * *' 		=> 'Une fois par mois (0 0 1 * *)',
		'0 0 1 1 *' 		=> 'Une fois par an (0 0 1 1 *)'
	);

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null) {
		if (!$this->Script->exists($id)) {
			throw new NotFoundException(__('Script inconnu.'));
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
			throw new NotFoundException(__('Script inconnu.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Script->save($this->request->data)) {
				$this->Session->setFlash(__('Les modifications ont bien été sauvegardées.'),'notif', array('type' => 'success'));
				$options = array('conditions' => array('Script.' . $this->Script->primaryKey => $id));
				$this->request->data = $this->Script->find('first', $options);
			} else {
				$this->Session->setFlash(__('Les modifications n\'ont pu être sauvegardées, veuillez réessayer.'),'notif', array('type' => 'danger'));
			}
		} else {
			$options = array('conditions' => array('Script.' . $this->Script->primaryKey => $id));
			$this->request->data = $this->Script->find('first', $options);
		}
		// Get related triggers (paginated)
		App::import('model','Trigger');
		$trigger = new Trigger();
		$triggerOptions = array('conditions' => array('Trigger.script_id' => $id, 'Trigger.type' => 'script'));
		$triggers = $trigger->find('all',$triggerOptions);

		// Get short launch history
		$options = array(
			'conditions' => array('ScriptLog.script_' . $this->Script->primaryKey => $id),
			'order' => array('ScriptLog.start_datetime DESC'),
			'limit'=> 20
		);
		$this->request->data['ScriptLog'] = $this->ScriptLog->find('all', $options);

		//Completion of common settings
		// Minutes
  		$choiceMinutes = $this->choiceMinutes;
  		for ($i=0;$i<60;$i++) {
  			$choiceMinutes[':'.$i] = ($i<10?'0'.$i:$i).' ('.$i.')';
  		}
		// hours
		$choiceHours = $this->choiceHours;
		for ($i=0;$i<24;$i++) {
			$choiceHours[':'.$i] = ($i<10?'0'.$i:$i).': ('.$i.')';
		}
		// Days
		$choiceDays = $this->choiceDays;
		for ($i=1;$i<32;$i++) {
			$choiceDays[':'.$i] = $i.' ('.$i.')';
		}
		// Set for the view
		$this->set(array(
			'scriptId'			=> $id,
			'commonSettings'	=> $this->commonSettings,
			'choiceMonths' 		=> $this->choiceMonths,
			'choiceWeekday' 	=> $this->choiceWeekday,
		));
		$this->set(compact('choiceMinutes', 'choiceHours', 'choiceDays','triggers'));
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
			throw new NotFoundException(__('Script inconnu.'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Script->delete()) {
			$this->Session->setFlash(__('Le script a bien été supprimé.'),'notif', array('type' => 'success'));
		} else {
			$this->Session->setFlash(__('Une erreur est survenue, le script n\'a pas été supprimé.'),'notif', array('type' => 'danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * launch method
	 *
	 * @return void
	 */
	public function launch () {
		$script_id = base64_decode($this->request->params['pass'][0]);
		$result = $this->script_launcher($script_id);
		if (empty($result)) {
			$this->Session->setFlash(__('Le script et été lancé avec succès.'),'notif', array('type' => 'success'));
		} else {
			$this->Session->setFlash(__('Le script n\'a pas pu être lancé : '.$result),'notif', array('type' => 'error'));
		}
		return $this->redirect($this->referer());
	}

	private function compose_script ($script) {
		$infos = pathinfo($script);
		return  $script = array(
			'name' 				=> basename($script, '.'.$infos['extension']),
			'script_location' 	=> $script,
		);
	}

	/**
	 * Launch scripts
	 *
	 * @param integer $id
	 * @return string
	 */
	private function script_launcher ($id) {
    $scriptLauncherDir = __DIR__.'/../Console/';

		// Find the script
		$options = array('conditions' => array('Script.' . $this->Script->primaryKey => $id), 'recursive' => 1);
		$script = $this->Script->find('first', $options);

		if (empty($script)) {
			return 'script inconnu.';
		}

		// Set the command to execute
		$command = $script['Script']['id'];

    // var_dump('cd '.$scriptLauncherDir.' && php '.$scriptLauncherDir.'cake.php script manual_launch '.$script['Script']['id'].' &> /dev/null &');die();

		// Start execution
		exec ('cd '.$scriptLauncherDir.' && php '.$scriptLauncherDir.'cake.php script manual_launch '.$script['Script']['id'].' &> /dev/null &', $output);
	}
}
