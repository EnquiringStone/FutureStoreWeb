<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:36 PM
 */
namespace FutureStore\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('username', 'text', array('attr' => array('placeholder' => 'Enter username')));
		$builder->add('password', 'password', array());
		$builder->add('remember_me', 'checkbox', array('label' => 'Keep me logged in', 'required' => false));
	}

	public function getName() {
		return 'login_form';
	}

}