<?php

namespace Nim\SF2\LoggerBundle\Gelf;

require_once __DIR__ . '/GELF.php';

use Nim\SF2\LoggerBundle\Logger;
use Symfony\Component\DependencyInjection\Container;

class GELFLogger implements Logger {
	
	private $container;

	public function __construct(Container $container) {
		$this->container = $container;
	}

	public function log($message, $level, $file, $line, $trace) {
		if(ini_get('display_errors') == 'On') {
			echo "<b>{$level}: </b>{$error} ({$file}:{$line})";
		}
		GELF::init($this->container->getParameter('nim_logger.graylog_host'));
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
