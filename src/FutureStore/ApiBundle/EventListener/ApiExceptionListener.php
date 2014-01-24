<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/24/14
 * Time: 2:27 PM
 */
namespace FutureStore\ApiBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ApiExceptionListener {

	protected $route;

	public function __construct($route) {
		$this->route = $route;
	}

	public function onKernelException(GetResponseForExceptionEvent $event) {
		if($event->getRequest()->getPathInfo() == $this->route) {
			$response = new Response();
			$response->headers->set('Content-Type', 'application/json');
			$exception = $event->getException();
			$response->setContent(json_encode(array('message' => $exception->getMessage(), 'error' => true)));
			$event->setResponse($response);
		}
	}
}