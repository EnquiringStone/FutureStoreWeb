<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:58 PM
 */
namespace FutureStore\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class UserService {

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $manager;

	/**
	 * @var \Symfony\Component\Security\Core\SecurityContext
	 */
	protected $context;

	public function __construct(EntityManager $manager, SecurityContext $context) {
		$this->manager = $manager;
		$this->context = $context;
	}
}