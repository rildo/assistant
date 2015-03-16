<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 */
class Message extends AppModel {
	public $order = "date DESC";
}
