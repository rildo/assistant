<?php
App::uses('AppModel', 'Model');
/**
 * Group Model
 *
 * @property Users $groupas_as_many_users
 */
class Source extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SourceAsOneType' => array(
			'className' => 'SourcesType',
			'foreignKey' => 'type_id',
		),
		'SourceAsOneUser' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

}
