<?php
/**
 * Created by PhpStorm.
 * User: johan_000
 * Date: 1/23/14
 * Time: 6:00 PM
 */
namespace FutureStore\SiteBundle\Service;

use Doctrine\ORM\EntityManager;
use FutureStore\SiteBundle\Entity\ShoppingListProduct;
use FutureStore\SiteBundle\Interfaces\AjaxInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ProfileService implements AjaxInterface {

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

	public function addProductToList($data) {
		$list = $this->manager->getRepository('FutureStoreSiteBundle:ShoppingList')->find($data['listId']);
		$merge = false;
		foreach($list->getShoppingListProducts() as $listProduct) {
			if($listProduct->getProductId() == $data['productId']) {
				$merge = true;
			}
		}
		$merge ? $this->mergeShoppingListProduct($data) : $this->createShoppingListProduct($data);
	}

	public function removeProductFromList($data) {
		$listProduct = $this->manager->getRepository('FutureStoreSiteBundle:ShoppingListProduct')->findOneBy(array('shopping_list_id' => $data['listId'], 'product_id' => $data['productId']));
		if($this->context->getToken()->getUser()->getId() != $listProduct->getShoppingList()->getUser()->getId()) throw new \Exception('Access denied');
		$this->manager->remove($listProduct);
		$this->manager->flush();
	}

	public function changeQuantityInList($data) {
		$listProduct = $this->manager->getRepository('FutureStoreSiteBundle:ShoppingListProduct')->findOneBy(array('shopping_list_id' => $data['listId'], 'product_id' => $data['productId']));
		if($this->context->getToken()->getUser()->getId() != $listProduct->getShoppingList()->getUser()->getId()) throw new \Exception('Access denied');
		$listProduct->setAmount($data['quantity']);
		$this->manager->flush();
	}

	public function getName() {
		return 'Profile';
	}

	protected function createShoppingListProduct($data) {
		$listProduct = new ShoppingListProduct();
		$listProduct->setAmount($data['quantity']);
		$listProduct->setProduct($this->manager->getRepository('FutureStoreSiteBundle:Product')->find($data['productId']));
		$listProduct->setShoppingList($this->manager->getRepository('FutureStoreSiteBundle:ShoppingList')->find($data['listId']));

		$this->manager->persist($listProduct);
		$this->manager->flush();
	}

	protected function mergeShoppingListProduct($data) {
		$listProduct = $this->manager->getRepository('FutureStoreSiteBundle:ShoppingListProduct')->findOneBy(array('product_id' => $data['productId'], 'shopping_list_id' => $data['listId']));
		$listProduct->setAmount($listProduct->getAmount() + $data['quantity']);

		$this->manager->persist($listProduct);
		$this->manager->flush();
	}
}