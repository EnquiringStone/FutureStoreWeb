<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:53 PM
 */
namespace FutureStore\ApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder,
	Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
	Symfony\Component\HttpKernel\DependencyInjection\Extension,
	Symfony\Component\Config\FileLocator;

class FutureStoreApiExtension extends Extension {

	public function load(array $configs, ContainerBuilder $container) {
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$config = $this->processConfiguration(new Configuration(), $configs);
		$container->setParameter('api.route', $config['listen_to_route']);
		$loader->load('services.xml');
	}

	public function getAlias() {
		return 'future_store_api';
	}
}