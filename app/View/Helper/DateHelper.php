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

	public function dateDiff ($date1, $date2) {
		$frenchDate1 = strtotime($date1);
		$frenchDate2 = strtotime($date2);
		$diff = $frenchDate2 - $frenchDate1;

		if ($diff == 0) {
			return '<1 ms';
		} else {
			$modulus = $diff % (60*60*24);

			// Conversion en heures
			$converted_duration['hours']['abs'] = floor($diff / (60*60));
			$converted_duration['hours']['rel'] = floor($modulus / (60*60));
			$modulus = $modulus % (60*60);

			// Conversion en minutes
			$converted_duration['minutes']['abs'] = floor($diff / 60);
			$converted_duration['minutes']['rel'] = floor($modulus / 60);
			$modulus = $modulus % 60;

			// Conversion en secondes
			$converted_duration['seconds']['abs'] = $diff;
			$converted_duration['seconds']['rel'] = $modulus;

			return $converted_duration['hours']['abs'].'h'.$converted_duration['minutes']['rel'].'m'.$converted_duration['seconds']['rel'].'s';
		}
	}

}
