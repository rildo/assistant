<?php

/**
 * Cakephp console command for scripts management
 *
 * @author rildo
 */
class ScriptShell extends AppShell {
    public $uses = array('Trigger', 'ScriptLog');
    
	public function main() {
		$this->out('Please use one of these functions :');
		$this->out('--- launch(scriptId,triggerId) : launch the script related to the given id');
		$this->out('--- clean_crontab() : Clean the crontab in order to be synchronised with the database');
	}
	
	/**
	 * Script launcher. Use it only with triggers
	 */
	public function launch () {
		// Check the input
		if (empty($this->args) || !is_numeric($this->args[0])) {
			$this->out('Please give the script id by argument');
			exit(1);
		} else {
			$id = $this->args[0];
		}
		
		// Find the script
		$options = array('conditions' => array('Trigger.' . $this->Trigger->primaryKey => $id), 'recursive' => 1);
		$trigger = $this->Trigger->find('first', $options);
		
		if (empty($trigger)) {
			throw new Exception( "Unknown script.");
			exit(1);
		}
		
		// Set the command to execute
		$command = $trigger['Script']['prefix'].' '.$trigger['Script']['script_location'].' '.$trigger['Script']['suffix'];
		
		// Start execution
		$startDateTime = new DateTime();
		exec ($command, $output);
		$endDateTime = new DateTime();
		
		// Save the result into database
		$log = array(
			'script_id'			=> $trigger['Script']['id'],
			'trigger_id' 		=> $trigger['Trigger']['id'],
			'output' 			=> implode('\n',$output),
			'start_datetime'	=> $startDateTime->format('Y-m-d H:i:s'),
			'end_datetime' 		=> $endDateTime->format('Y-m-d H:i:s')
		);
		
		$this->ScriptLog->save($log);
	}
	
	/**
	 * Clean the crontab in order to be synchronised with the database
	 */
	public function clean_crontab () {
		$date = new DateTime();
		echo $this->out('[clean_crontab] start - '.$date->format('H:i:s d/m/Y'));
	}
}