<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/24/14
 * Time: 11:46 AM
 */
namespace FutureStore\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('username', 'text', array('attr' => array('placeholder' => 'Enter username')));
		$builder->add('password', 'password', array());
		$builder->add('password_confirmation', 'password', array());
		$builder->add('email', 'email', array('attr' => array('placeholder' => 'Enter email')));
	}

	public function getName() {
		return 'register_form';
	}

}