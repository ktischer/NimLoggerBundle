<?php

namespace Nim\SF2\LoggerBundle\Gelf;

use Nim\SF2\LoggerBundle\Logger;

require_once __DIR__ . '/GELFMessage.php';
require_once __DIR__ . '/GELFMessagePublisher.php';

class GELF {
	const EMERG = 0;
	const ALERT = 1;
	const CRITICAL = 2;
	const ERROR = 3;
	const WARN = 4;
	const NOTICE = 5;
	const INFO = 6;
	const DEBUG = 7;
	
	private static $publisher;

	/**
	 * Log to Graylog:
	 * @param array $extra key/values are included as additional fields, these can be searched in graylog
	 */
	public static function log($message, $file = '', $line = 0, $level = GELF::NOTICE, $extra = array()) {
		$gelf = new \GELFMessage();
		$gelf->setHost(@exec('hostname'));
		$gelf->setFullMessage($message);
		$shortSplit = strpos($message, "\n");
		$gelf->setShortMessage(substr($message, 0, $shortSplit > 0 ? $shortSplit : 50));
		$gelf->setFile($file);
		$gelf->setLine($line);
		$gelf->setLevel(self::gelfLevel($level));
		
		foreach($extra as $key => $value) {
			$gelf->setAdditional($key, (string) $value);
		}
		
		try {
			return @self::$publisher->publish($gelf);
		} catch(Exception $e) {
			return false;
		}
	}

	public static function init($gelfServer) {
		if(!self::$publisher) {
			self::$publisher = new \GELFMessagePublisher($gelfServer);
		}
	}

	private static function gelfLevel($level) {
		switch($level) {
			case Logger::NOTICE:
				return GELF::NOTICE;
			case Logger::WARNING:
				return GELF::WARN;
			case Logger::ERROR:
				return GELF::CRITICAL;
			default:
				return GELF::INFO;
		}
	}

}



