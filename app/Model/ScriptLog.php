<?php
App::uses('AppModel', 'Model');
/**
 * ScriptLog Model
 *
 * @property Script $Script
 */
class ScriptLog extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Script' => array(
			'className' => 'Script',
			'foreignKey' => 'script_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Trigger' => array(
			'className' => 'Trigger',
			'foreignKey' => 'trigger_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
