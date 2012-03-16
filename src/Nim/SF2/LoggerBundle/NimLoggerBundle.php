<?php

namespace Nim\SF2\LoggerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NimLoggerBundle extends Bundle {

	public function build(ContainerBuilder $container) {
		parent::build($container);
		Nim\SF2\LoggerBundle\ErrorLogger::init($container->getParameter('graylog.host'));
	}

}
