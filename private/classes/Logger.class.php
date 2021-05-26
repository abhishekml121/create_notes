<?php
class Logger {
	// log file must exist and have permissions set that allow writing
	// Example in Unix: chmod 777 errors.log
	public const LOG_FILE_PATH = LOG_PATH;
	private const LOG_FILE = self::LOG_FILE_PATH .'/activity.log';
	private const ERROR_LOG_FILE = self::LOG_FILE_PATH .'/error.log';
	// An ultra-simple file logger
	// $level = ERROR,DEBUG,LOGIN
	private function activity_logger($level='', $msg='') {
	// Ensure all messages have a final line return
	$log_msg = $level . ": \t" . $msg . PHP_EOL;
	
	// FILE_APPEND adds content to the end of the file
	// LOCK_EX forbids writing to the file while in use by us
	file_put_contents(self::LOG_FILE, $log_msg, FILE_APPEND | LOCK_EX);
	}

	private function error_logger($level='', $msg='') {
		// Ensure all messages have a final line return
		$log_msg = $level . ": \t" .$msg . PHP_EOL;
		file_put_contents(self::ERROR_LOG_FILE, $log_msg, FILE_APPEND | LOCK_EX);
	}
	
	public function get_activity_logger($level='', $msg=''){
		$this->activity_logger($level,$msg);
	}

	public function get_error_logger($level='', $msg=''){
		$this->error_logger($level,$msg);
	}

// Other loggers you can try:
// https://github.com/apache/logging-log4php
// https://github.com/katzgrau/KLogger
// https://github.com/Seldaek/monolog
// https://github.com/jbroadway/analog

// Frameworks have their own logging:
// http://framework.zend.com/manual/1.12/en/zend.log.html
}
?>
