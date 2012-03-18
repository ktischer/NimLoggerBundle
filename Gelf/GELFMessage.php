<?php

/**
 * Taken from https://github.com/Graylog2/gelf-php
 *
 * Copyright (c) 2010-2012 Lennart Koopmann
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
class GELFMessage {
	/**
	 * @var string
	 */
	private $version = null;
	
	/**
	 * @var integer
	 */
	private $timestamp = null;
	
	/**
	 * @var string
	 */
	private $shortMessage = null;
	
	/**
	 * @var string
	 */
	private $fullMessage = null;
	
	/**
	 * @var string
	 */
	private $facility = null;
	
	/**
	 * @var string
	 */
	private $host = null;
	
	/**
	 * @var integer
	 */
	private $level = null;
	
	/**
	 * @var string
	 */
	private $file = null;
	
	/**
	 * @var integer
	 */
	private $line = null;
	
	/**
	 * @var array
	 */
	private $data = array();

	/**
	 * @param string $version
	 * @return GELFMessage
	 */
	public function setVersion($version) {
		$this->version = $version;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @param integer $timestamp
	 * @return GELFMessage
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
		return $this;
	}

	/**
	 * @return integer
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * @param string $shortMessage
	 * @return GELFMessage
	 */
	public function setShortMessage($shortMessage) {
		$this->shortMessage = $shortMessage;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getShortMessage() {
		return $this->shortMessage;
	}

	/**
	 * @param string $fullMessage
	 * @return GELFMessage
	 */
	public function setFullMessage($fullMessage) {
		$this->fullMessage = $fullMessage;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFullMessage() {
		return $this->fullMessage;
	}

	/**
	 * @param string $facility
	 * @return GELFMessage
	 */
	public function setFacility($facility) {
		$this->facility = $facility;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFacility() {
		return $this->facility;
	}

	/**
	 * @param string $host
	 * @return GELFMessage
	 */
	public function setHost($host) {
		$this->host = $host;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * @param integer $level
	 * @return GELFMessage
	 */
	public function setLevel($level) {
		$this->level = $level;
		return $this;
	}

	/**
	 * @return integer
	 */
	public function getLevel() {
		return $this->level;
	}

	/**
	 * @param string $file
	 * @return GELFMessage
	 */
	public function setFile($file) {
		$this->file = $file;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFile() {
		return $this->file;
	}

	/**
	 * @param integer $line
	 * @return GELFMessage
	 */
	public function setLine($line) {
		$this->line = $line;
		return $this;
	}

	/**
	 * @return integer
	 */
	public function getLine() {
		return $this->line;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @return GELFMessage
	 */
	public function setAdditional($key, $value) {
		$this->data["_" . trim($key)] = $value;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAdditional($key) {
		return isset($this->data["_" . trim($key)]) ? $this->data[$key] : null;
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$messageAsArray = array('version' => $this->getVersion(), 'timestamp' => $this->getTimestamp(), 'short_message' => $this->getShortMessage(), 'full_message' => $this->getFullMessage(), 
				'facility' => $this->getFacility(), 'host' => $this->getHost(), 'level' => $this->getLevel(), 'file' => $this->getFile(), 'line' => $this->getLine());
		
		foreach($this->data as $key => $value) {
			$messageAsArray[$key] = $value;
		}
		
		return $messageAsArray;
	}
}
