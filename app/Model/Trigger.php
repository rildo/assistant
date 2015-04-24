<?php
App::uses('AppModel', 'Model');
/**
 * Trigger Model
 *
 * @property Script $Script
 */
class Trigger extends AppModel {
	public $name = 'Trigger';

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
		)
	);
	
	/**
	 * hasMany relation
	 */
	public $hasMany = array(
		'ScriptLog' => array(
			'className' => 'ScriptLog',
		)
	);

	/**
	 * Validation rules
	 */
	public $validate = array(
		'email' => array(
			'email_format' => array(
				'rule' => 'email',
				'message' => 'Le format de l\'e-mail est incorrect.'
			),
			'email_maxlength' => array(
				'rule'    => array('maxLength', 255),
				'message' => 'L\'email ne doit pas dépasser 255 caractères.'
			),
			'email_minlength' => array(
				'rule'    => array('minLength', 10),
				'message' => 'L\'email doit faire au moins 10 caractères.'
			)
		),
		'minute' => array(
			'minute_maxlength' => array(
				'rule'    => array('maxLength', 100),
				'message' => 'Le champ "jours de la semaine" ne doit pas dépasser 100 caractères.'
			),
			'minute_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Le champ "minute" est obligatoire.'
			)
		),
		'hour' => array(
			'hour_maxlength' => array(
				'rule'    => array('maxLength', 100),
				'message' => 'Le champ "jours de la semaine" ne doit pas dépasser 100 caractères.'
			),
			'minute_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Le champ "heure" est obligatoire.'
			)
		),
		'day' => array(
			'day_maxlength' => array(
				'rule'    => array('maxLength', 100),
				'message' => 'Le champ "jours de la semaine" ne doit pas dépasser 100 caractères.'
			),
			'minute_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Le champ "jour" est obligatoire.'
			)
		),
		'month' => array(
			'month_maxlength' => array(
				'rule'    => array('maxLength', 100),
				'message' => 'Le champ "jours de la semaine" ne doit pas dépasser 100 caractères.'
			),
			'minute_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Le champ "mois" est obligatoire.'
			)
		),
		'weekday' => array(
			'weekday_maxlength' => array(
				'rule'    => array('maxLength', 100),
				'message' => 'Le champ "jours de la semaine" ne doit pas dépasser 100 caractères.'
			),
			'minute_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Le champ "jour de la semaine" est obligatoire.'
			)
		)
	);
}
