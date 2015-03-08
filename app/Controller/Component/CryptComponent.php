<?php
/**
 * CakePHP CryptComponent
 * @author spikto
 */
class CryptComponent extends Component {
	private $iv = null;
	
	public function crypt($string) {
		return base64_encode($this->getIV().mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->getKey(), $string, MCRYPT_MODE_CBC, $this->getIV()));
	}
	public function decrypt($string) {
		$string = base64_decode($string);
		$iv = substr($string, 0, $this->getSize());
		$string2 = substr($string, $this->getSize());
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->getKey(), $string2, MCRYPT_MODE_CBC, $iv));
	}
	
	private function getIV() {
		if ($this->iv==null) {
			$this->iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
		}
		return $this->iv;
	}
	
	private function getKey() {
		return substr(Configure::read("Security.salt"), 0, 32);
	}
	
	private function getSize() {
		return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	}
	
}
