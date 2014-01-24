<?php
/*
 * This file is part of the Notarishof package.
 *
 * (c) Nick Obermeijer <http://www.linkedin.com/pub/nick-obermeijer/18/277/687>
 *
 * For the full copyright and licence information, please view the licence
 * file that was distributed with this source code.
 */
namespace FutureStore\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder,
	Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

	/**
	 * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
	 */
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('future_store_api');
		$rootNode
			->children()
				->variableNode('listen_to_route')->isRequired()->end()
			->end();
		return $treeBuilder;
    }

}
