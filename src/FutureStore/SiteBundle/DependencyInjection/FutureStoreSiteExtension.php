<?php
/**
 * Created by PhpStorm.
 * User: johan_000
 * Date: 1/23/14
 * Time: 5:25 PM
 */
namespace FutureStore\SiteBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class FutureStoreSiteExtension extends Extension {
	public function load(array $configs, ContainerBuilder $container) {
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$loader->load('services.xml');
	}

	public function getAlias() {
		return 'future_store_site';
	}
}