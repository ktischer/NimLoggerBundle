<?php

namespace Nim\SF2\LoggerBundle;

interface Logger {
	const NOTICE = 1;
	const WARNING = 2;
	const ERROR = 4;

	/**
	 * Log to wherever.
	 *
	 * @param string $message full error message
	 * @param int $level use the Logger::NOTICE/WARNING/ERROR constants.
	 * @param string $file full path to file
	 * @param int $line line number
	 * @param string $trace stack trace
	 */
	public function log($message, $level, $file, $line, $trace);
}
