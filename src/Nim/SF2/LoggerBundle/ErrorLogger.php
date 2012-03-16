<?php

namespace Nim\SF2\LoggerBundle;
use Nim\SF2\LoggerBundle\Logger;
use Nim\SF2\LoggerBundle\Gelf\GELFLogger;

class ErrorLogger {
	private static $loggerImpl;

	/**
	 * Override the default GELF implementation.
	 */
	public static function setLoggerImplementation(Logger $impl) {
		self::$loggerImpl = $impl;
	}

	/**
	 * Get ready to log!
	 * @param array $gelfServer optional ip address of the graylog2 server, only required when using the GELF implementation
	 */
	public static function init($gelfServer = '') {
		if(!self::$loggerImpl) {
			require_once 'gelf/GELFLogger.php';
			self::$loggerImpl = new GELFLogger($gelfServer);
		}
		
		set_error_handler(array('Nim\Logger\ErrorLogger', 'handleErrors'), (E_ALL | E_STRICT) ^ E_NOTICE);
		set_exception_handler(array('Nim\Logger\ErrorLogger', 'handleExceptions'));
		register_shutdown_function(array('Nim\Logger\ErrorLogger', 'shutdownErrorHandler'));
	}

	/**
	 * Global error handler. Either pass it on to our error/warning handlers or discard it altogeher.
	 */
	public static function handleErrors($type, $error, $file = '', $lineNumber = 0) {
		switch($type) {
			case E_USER_ERROR:
			case E_RECOVERABLE_ERROR:
				self::handleError(Logger::ERROR, $error, $file, $lineNumber);
				break;
			case E_WARNING:
			case E_USER_WARNING:
				self::handleWarning(Logger::WARNING, $error, $file, $lineNumber);
				break;
			case E_DEPRECATED:
				self::handleWarning(Logger::NOTICE, $error, $file, $lineNumber);
				break;
		}
	}

	/**
	 * Uncaught exception handler.
	 */
	public static function handleExceptions(Exception $exception) {
		self::handleError(Logger::ERROR, 'Uncaught Exception: ' . $exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTraceAsString());
	}

	/**
	 * Catching fatal errors is a bit tricky, in the sense that PHP doesn't technically support it.
	 * However, we can register this method as the (first!!!) shutdown handler and call the error handling
	 * code from it :-). Note that this should only handle errors that can't be dealt with in the "normal" flow.
	 */
	public static function shutdownErrorHandler() {
		if($error = error_get_last()) {
			switch($error['type']) {
				case E_ERROR:
				case E_PARSE:
				case E_CORE_ERROR:
				case E_CORE_WARNING:
				case E_COMPILE_ERROR:
					self::handleError(Logger::ERROR, $error['message'], $error['file'], $error['line'], null, true);
					break;
			}
		}
	}

	/**
	 * Error handler for fatal errors. These cause the script to terminate and the status to be set to ERROR.
	 */
	private static function handleError($level, $error, $file = '', $line = 0, $trace = null) {
		self::logError($level, $file, $line, $error, '');
		die();
	}

	/**
	 * Error handler for warnings. These are logged but do not otherwise influence the execution of the script.
	 */
	private static function handleWarning($level, $error, $file = '', $line = 0) {
		if(error_reporting() === 0) {
			return;
		}
		self::logError($level, $file, $line, $error, '');
	}

	private static function logError($level, $file, $line, $message, $trace) {
		@self::$loggerImpl->log($message, $level, $file, $line, $trace);
	}

}