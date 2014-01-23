<?php
/**
 * Created by PhpStorm.
 * User: johan_000
 * Date: 1/23/14
 * Time: 5:31 PM
 */
namespace FutureStore\SiteBundle\EventListener;

use FutureStore\SiteBundle\Interfaces\AjaxInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class AjaxCallListener {

	/**
	 * @var array
	 */
	protected $services = array();

	public function __construct() {
		foreach(func_get_args() as $arg) {
			if($arg instanceof AjaxInterface) {
				$this->services[] = $arg;
			}
		}
	}

	/**
	 * @param GetResponseEvent $event
	 * @throws \Exception
	 */
	public function onKernelRequest(GetResponseEvent $event) {
		if($event->getRequest()->isXmlHttpRequest() && $event->getRequest()->headers->get('X-Request')) {
			try{
				if($serviceName = $event->getRequest()->headers->get('X-Request')) {
					if($service = $this->getService($serviceName)) {
						if($method = $event->getRequest()->headers->get('X-Request-Method')) {
							if(method_exists($service, $method)) {
								$data = call_user_func_array(array($service, $method), array($event->getRequest()->request->get('arguments')));
								$response = new Response();
								$response->headers->set('Content-type', 'application/json');
								$response->setContent(json_encode(array('status' => '200 OK', 'data' => $data)));
								return $event->setResponse($response);
							}
							throw new \Exception('de methode bestaat niet in de service ' . $service->getName());
						}
						throw new \Exception('de methode bestaat niet');
					}
				}
				throw new \Exception('De service bestaat niet');
			} catch(\Exception $e) {
				throw new \Exception($e->getMessage(), $e->getCode(), $e);
			}
		}
	}

	/**
	 * @param $serviceName
	 * @return mixed
	 * @throws \Exception
	 */
	protected function getService($serviceName) {
		foreach($this->services as $service) {
			if($serviceName == $service->getName()) return $service;
		}
		throw new \Exception('De service is niet toegevoegt');
	}
}