<?php
App::uses('AppModel', 'Model');
App::uses('Pbkdf2PasswordHasher', 'Controller/Component/Auth');

/**
 * User Model
 *
 * @property Group $user_as_one_group
 */
class User extends AppModel {
	public $name = 'User';

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';

	/**
	 * Validation rules
	 */
	public $validate = array(
		'name' => array(
			'name_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Un nom d\'utilisateur est requis.'
			),
			'ame_isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Ce nom d\'utilisateur est déjà utilisé.'
			),
			'name_minlength' => array(
				'rule'    => array('minLength', 5),
				'message' => 'Le nom d\'utilisateur doit faire au moins 3 caractères.'
			),
			'name_maxlength' => array(
				'rule'    => array('maxLength', 255),
				'message' => 'Le nom d\'utilisateur ne doit pas dépasser 255 caractères.'
			)
		),
		'password' => array(
			'password_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Un mot de passe est requis.'
			),
			'password_maxlength' => array(
				'rule'    => array('maxLength', 255),
				'message' => 'Le mot de passe ne doit pas dépasser 255 caractères.'
			),
			'password_minlength' => array(
				'rule'    => array('minLength', 10),
				'message' => 'Le mot de passe doit faire au moins 10 caractères.'
			)
		),
		'email' => array(
			'email_format' => array(
				'rule' => 'email',
				'message' => 'Le format de l\'e-mail est incorrect.'
			),
			'email_required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Un e-mail est requis.'
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
		'check' => array(
			'check_checkMatchPasswd' => array(
			 	'rule' => array('checkMatchPasswd'),
				'message' => 'Le mot de passe et sa vérification doivent être identiques.'
			)
		)
	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'UserAsOneGroup' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * 1- Hash the password
	 *
	 * @see Model::beforeSave()
	 */
	public function beforeSave($opts = array()) {
		if (!empty($this->data['User']['password'])) {
			$Pbkdf2PasswordHasher = new Pbkdf2PasswordHasher();
			$this->data['User']['password'] = $Pbkdf2PasswordHasher->hash($this->data['User']['password']);
		}
		if (!empty($this->data['User']['email'])) {
			$this->data['User']['email'] = strtolower($this->data['User']['email']);
		}
		return true;
	}
}
