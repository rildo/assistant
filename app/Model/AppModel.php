<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	
	public function __construct($id = false, $table = null, $ds = null) {
		
		if (preg_match("#Source([0-9]+)(.*)#", $id["class"], $result)) {
			$id=$result[1];
			// Récupération de la source
			$sourceModel = ClassRegistry::init("Source");
			$source = $sourceModel->findById($id);
			if (!empty($source)) {
				$config = unserialize($source["Source"]["config"]);
				$config["encoding"] = "utf8";
				switch ($source["Source"]["type_id"]) {
					case 1: $config["datasource"] = "Database/Mysql"; break;
					case 2: $config["datasource"] = "Database/Sqlite"; break;
					default:break;
				}
				$cryptComponent = new CryptComponent(new ComponentCollection);
				$config["password"] = $cryptComponent->decrypt($config["password"]);
				ConnectionManager::create($config["database"], $config);
				$this->useDbConfig = $config["database"];

				//$produit = $source["Source"]["produit_id"];
				

				// Assignation
				$table = strtolower($result[2]);
				$id=null;
			}
		}
		parent::__construct($id, $table, $ds);
		
	}
}
