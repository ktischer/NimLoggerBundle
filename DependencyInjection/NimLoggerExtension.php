<?php

namespace Nim\SF2\LoggerBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Bundle\WebProfilerBundle\EventListener\WebDebugToolbarListener;

class NimLoggerExtension extends Extension {

	public function load(array $configs, ContainerBuilder $container) {
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
		
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('nimlogger.xml');
		
		if(isset($config['graylog_host'])) {
			$container->setParameter('nim_logger.graylog_host', $config['graylog_host']);
		}
	}

	public function getXsdValidationBasePath() {
		return __DIR__ . '/../Resources/config/xsd';
	}

	public function getNamespace() {
		return 'http://lick-me.org/nim/sf2/loggerbundle';
	}
}
