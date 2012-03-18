<?php

namespace Nim\SF2\LoggerBundle;

use Nim\SF2\LoggerBundle\DependencyInjection\NimLoggerExtension;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NimLoggerBundle extends Bundle {

	public function build(ContainerBuilder $container) {
		parent::build($container);
		ErrorLogger::init($container);
	}

}
