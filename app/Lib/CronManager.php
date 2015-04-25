<?php

/**
 * CRON manager class
 *
 * @author rildo
 */
class CronManager {
	
	private $path;
	private $handle;
	private $cronFile;
	
	function __construct() {
		$this->path  	= TMP;
		$this->handle	= 'crontab.txt';
		$this->cron_file= "{$this->path}{$this->handle}";
	}
	
	/**
	 * Executing Multiple Commands
	 */
	public function exec() {
		$result=NULL;
	    $argument_count = func_num_args();
	    try {
	        if ( ! $argument_count) throw new Exception("There is nothing to execute, no arguments specified.");
	        $arguments = func_get_args();
	        $command_string = ($argument_count > 1) ? implode(" && ", $arguments) : $arguments[0];
	        $result = @exec($command_string);
	        if ( ! $result) throw new Exception("Unable to execute the specified commands: <br />{$command_string}");
	    } catch (Exception $e) {
// 	        debug ($e->getMessage());
	    }
	    return $this;
	}
	
	/**
	 * Writing the CronTab to a File
	 * @param string $path
	 * @param string $handle
	 * @return CronManager
	 */
	public function write_to_file($path=NULL, $handle=NULL) {
		if ( ! $this->crontab_file_exists()) {
			$this->handle = (is_null($handle)) ? $this->handle : $handle;
			$this->path   = (is_null($path))   ? $this->path   : $path;
			$this->cron_file = "{$this->path}{$this->handle}";
			//{$this->cron_file} && crontab -l > {$this->cron_file} && [ -f {$this->cron_file} ] || > {$this->cron_file}
			$init_cron = "crontab -l > {$this->cron_file}";
			$this->exec($init_cron);
		}
		return $this;
	}
	
	/**
	 * Removing the Temporary Cron File
	 * @return CronManager
	 */
	public function remove_file() {
		if ($this->crontab_file_exists()) $this->exec("rm {$this->cron_file}");
		return $this;
	}
	
	/**
	 * Creating New Cron Jobs
	 * @return CronManager
	 */
	public function append_cronjob($cron_jobs=NULL) {
	    if (is_null($cron_jobs))  throw new Exception( "Nothing to append!  Please specify a cron job or an array of cron jobs.");
	    $append_cronfile = "echo '";
	    $append_cronfile .= (is_array($cron_jobs)) ? implode("\n", $cron_jobs) : $cron_jobs;
	    $append_cronfile .= "'  >> {$this->cron_file}";
	    $install_cron = "crontab {$this->cron_file}";
	    $this->write_to_file()->exec($append_cronfile, $install_cron)->remove_file();
	    return $this;
	}
	
	/**
	 * Removing Existing Cron Jobs
	 * @return CronManager
	 */
	public function remove_cronjob($cron_jobs=NULL) {
		if (is_null($cron_jobs))  throw new Exception( "Nothing to remove!  Please specify a cron job or an array of cron jobs.");
		$this->write_to_file();
		$cron_array = file($this->cron_file, FILE_IGNORE_NEW_LINES);
		if (empty($cron_array)) throw new Exception( "Nothing to remove!  The cronTab is already empty.");
		$original_count = count($cron_array);
		if (is_array($cron_jobs)) {
			foreach ($cron_jobs as $cron_regex) $cron_array = preg_grep($cron_regex, $cron_array, PREG_GREP_INVERT);
		} else {
			$cron_array = preg_grep($cron_jobs, $cron_array, PREG_GREP_INVERT);
		}
		return ($original_count === count($cron_array)) ? $this->remove_file() : $this->remove_crontab()->append_cronjob($cron_array);
	}
	
	/**
	 * Removing the Entire Crontab
	 * @return CronManager
	 */
	public function remove_crontab() {
		$this->exec("crontab -r")->remove_file();
		return $this;
	}
	
	// Helpful Methods
	
	/**
	 * This method will return the result of PHP's file_exists() method, true or false, depending on whether or not the temporary cron file exists.
	 * @return boolean
	 */
	private function crontab_file_exists() {
		return file_exists($this->cron_file);
	}
	
}