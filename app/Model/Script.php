<?php
App::uses('AppModel', 'Model');
/**
 * Script Model
 *
 */
class Script extends AppModel {

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';
	
	/**
	 * hasMany relation
	 */
	public $hasMany = array(
		'Trigger' => array(
			'className' => 'Trigger',
		),
		'ScriptLog' => array(
			'className' => 'ScriptLog',
		)
	);

}
