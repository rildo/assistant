<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	
	public $components = array(
		"DebugKit.Toolbar", 
		'Session',
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'fields' => array(
						'username' => 'name',
						'password' => 'password'
					),
					'passwordHasher' => 'Pbkdf2'
				)
			),
			'authorize' => array('Controller')
        )
	);
	
	public $uses = array("Message");
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set("userName", $this->Auth->user("name"));
		$this->set("userGroup", $this->Auth->user("group_id"));
		
		// Gestion des notifications
		$nbNonLu = $this->Message->find("count", array("conditions" => array("read" => 0,"user_id" => $this->Auth->user("id"))));
		$dernierMessage = $this->Message->find("all", array("conditions" => array("user_id" => $this->Auth->user("id")), "limit" => 5));
		$this->set(compact("nbNonLu", "dernierMessage"));
	}
	
	
	public function isAuthorized($user) {
		if ($this->request->param("prefix")!="admin") {
			return true;
		}
		if (isset($user['group_id']) && $user['group_id'] == 1) {
			return true;
		}

		// Refus par défaut
		return false;
	}
}
