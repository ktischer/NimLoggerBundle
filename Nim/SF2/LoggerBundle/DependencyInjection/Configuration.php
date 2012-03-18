<?php

namespace Nim\SF2\LoggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface {

	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('nim_logger');
		$rootNode->children()->scalarNode('graylog_host')->end()->end();
		return $treeBuilder;
	}
}
