<?php
/**
 * Created by PhpStorm.
 * User: johan_000
 * Date: 1/23/14
 * Time: 3:33 PM
 */
namespace FutureStore\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateShoppingListFormType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('naam', 'text', array('attr' => array('placeholder' => 'Vul hier de naam in')));
	}

	public function getName() {
		return 'create_shopping_list';
	}

}