<?php

/**
 * CakePHP FilmHelper
 * @author thomas
 */
class FilmHelper extends AppHelper {

	public $helpers = array();

	public function getQualityFromWidth($width) {
		if ($width>=1080) {
			return "HD 1080p";
		} elseif ($width>=720) {
			return "HD 720p";
		}
		return "SD";
	}

}
