<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:58 PM
 */
namespace FutureStore\ApiBundle\Service;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;
use FutureStore\ApiBundle\Interfaces\ApiInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\SecurityContext;

class UserService implements ApiInterface{

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $manager;

	protected $userManager;

	protected $encoderFactory;

	public function __construct(UserManager $userManager, EncoderFactory $encoderFactory, EntityManager $manager) {
		$this->manager = $manager;
		$this->userManager = $userManager;
		$this->encoderFactory = $encoderFactory;
	}

	public function login($data) {
		if($user = $this->userManager->findUserByUsername($data['username'])) {
			if($this->validatePassword($user, $data['password'])) {
				$token = md5(uniqid(rand(), true));
				$user->setLoginToken($token);
				$this->userManager->updateUser($user);
				$this->manager->flush();
				return array('login_token' => $token);
			}
			throw new \Exception('Het wachtwoord is incorrect');
		}
		throw new \Exception('De gebruiker bestaat niet');
	}

	public function getName() {
		return 'user';
	}

	/**
	 * @param User $user
	 * @param $password
	 * @return bool
	 */
	protected function validatePassword(User $user, $password) {
		$encoder = $this->encoderFactory->getEncoder($user);
		return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
	}
}