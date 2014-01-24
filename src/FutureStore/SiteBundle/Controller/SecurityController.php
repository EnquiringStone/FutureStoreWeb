<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:33 PM
 */
namespace FutureStore\SiteBundle\Controller;

use FutureStore\SiteBundle\Form\Type\LoginFormType;
use FutureStore\SiteBundle\Form\Type\RegisterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller {
	public function loginAction(Request $request) {
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
			$request->getSession()->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

		return $this->render('FutureStoreSiteBundle:Security:login.html.twig', array(
			'error' => $error, 'login_form' => $this->createForm(new LoginFormType())->createView()
		));
	}

	public function registerAction(Request $request) {
		$form = $this->createForm(new RegisterFormType());
		if($request->getMethod() == 'POST') {
			$form->handleRequest($request);
			$data = $form->getData();

			$userManager = $this->get('fos_user.user_manager');
			$user = $userManager->createUser();
			$user->setUsername($data['username']);
			$user->setPlainPassword($data['password']);
			$user->setEmail($data['email']);
			$user->setEnabled(true);
			$userManager->updateUser($user);
			$this->getDoctrine()->getManager()->flush();
			return $this->redirect($this->generateUrl('FutureStoreSiteBundle_profile_index'));
		}
		return $this->render('FutureStoreSiteBundle:Security:register.html.twig', array(
			'register_form' => $form->createView()
		));
	}
}