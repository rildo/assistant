<?php

App::uses('AppHelper', 'View/Helper');

class DateHelper extends AppHelper {
	
	public function showFrenshDateTime ($date) {
		$frenchDate = strtotime($date);
		return strftime("%d/%m/%Y à %H:%M:%S", $frenchDate);
	}
	
	public function showFrenshDate ($date) {
		$frenchDate = strtotime($date);
		return strftime("%d/%m/%Y", $frenchDate);
	}

}