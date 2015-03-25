<?php

App::uses('AppModel', 'Model');
App::uses("CryptComponent", "Controller/Component");
/**
 * CakePHP Film
 * @author thomas
 */
class Film extends AppModel {
	
	private $movieMapping = array(
		//Xbmc
		1 => array(
			"nom" => "c00",
			"path" => "c22"
		)
	);
	
	public function __construct($id = false, $table = null, $ds = null) {
		
		// Récupération de la source
		$sourceModel = ClassRegistry::init("Source");
		$source = $sourceModel->findById($id["id"]);
		if (!empty($source)) {
			$config = unserialize($source["Source"]["config"]);
			$config["encoding"] = "utf8";
			switch ($source["Source"]["type_id"]) {
				case 1: $config["datasource"] = "Database/Mysql"; break;
				case 2: $config["datasource"] = "Database/Sqlite"; break;
				default:break;
			}
			$cryptComponent = new CryptComponent(new ComponentCollection);
			if (isset($config["password"])) {
				$config["password"] = $cryptComponent->decrypt($config["password"]);
				ConnectionManager::create($config["database"], $config);
				$this->useDbConfig = $config["database"];

				$produit = $source["Source"]["produit_id"];
				if ($produit==1) {
					$this->primaryKey = "idFile";
					$this->hasMany = array(
						"Stream" => array("className" => "Source".$id["id"]."Streamdetails", "foreignKey" => "idFile", "fields" => array("iVideoWidth"), "conditions" => array("iStreamType"=>0))
					);
					$this->hasOne = array(
						"File" => array("className" => "Source".$id["id"]."Files", "foreignKey" => "idFile", "fields" => array("dateAdded"))
					);
				}
				if (isset($this->movieMapping[$produit])) {
					$this->virtualFields = $this->movieMapping[$produit];
				}

				// Assignation
				$table = "movie";
				$id = false;
			}
		}
		
		parent::__construct($id, $table, $ds);
	}
}
