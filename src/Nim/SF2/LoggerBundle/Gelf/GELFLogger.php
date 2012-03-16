<?php

namespace Nim\SF2\LoggerBundle\Gelf;

require_once 'GELF.php';

use Nim\Logger\Logger;

class GELFLogger implements Logger {

	private $gelfServer;

	public function __construct($gelfServer) {
		$this->gelfServer = $gelfServer;
	}

	public function log($message, $level, $file, $line, $trace) {
		if (ini_get('display_errors') == 'On') {
			echo "<b>{$level}: </b>{$error} ({$file}:{$line})";
		}
		GELF::init($this->gelfServer);
		GELF::log($message . "\n$trace", $file, $line, $level, $this->getExtraParams());
	}

	private function getExtraParams() {
		return array('ErrorType' => 'PHP', 'URL' => @$this->getFullUrl(), 'Referrer' => @$_SERVER['HTTP_REFERER']);
	}

	private function getFullUrl() {
		if(isset($_SERVER['REQUEST_URI'])) {
			$protocol = 'http' . (empty($_SERVER['HTTPS']) ? '' : 's');
			$port = (@$_SERVER['SERVER_PORT'] == 80 || @$_SERVER['SERVER_PORT'] == 443) ? '' : ":{$_SERVER["SERVER_PORT"]}";
			return $protocol . "://" . @$_SERVER['SERVER_NAME'] . $port . @$_SERVER['REQUEST_URI'];
		}

		return @$_SERVER['SCRIPT_FILENAME'];
	}
}
