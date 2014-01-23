<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:43 PM
 */
namespace FutureStore\SiteBundle\Controller;

use FutureStore\SiteBundle\Entity\ShoppingList;
use FutureStore\SiteBundle\Form\Type\CreateShoppingListFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller {
	public function indexAction() {
		return $this->render('FutureStoreSiteBundle:Profile:index.html.twig');
	}

	public function createShoppingListAction() {
		return $this->render('FutureStoreSiteBundle:Profile:shopping.create.html.twig', array(
			'create_shopping_list_form' => $this->createForm(new CreateShoppingListFormType())->createView()
		));
	}

	public function addProductsAction(Request $request) {
		$list_id = null;
		$list = null;
		if($request->getMethod() == 'POST') {
			$form = $request->request->get('create_shopping_list');
			if(empty($form)) throw new \Exception('Naam mag niet leeg zijn');

			$list = new ShoppingList();
			$list->setCreatedAt(new \DateTime());
			$list->setListName($form['naam']);
			$list->setUser($this->getUser());

			$this->getDoctrine()->getManager()->persist($list);
			$this->getDoctrine()->getManager()->flush();
//			print_r($request->request->all()); exit;
			$list_id = $list->getId();
		} elseif($request->query->get('list_id') != null) {
			$list_id = $request->query->get('list_id');
			$list = $this->getDoctrine()->getRepository('FutureStoreSiteBundle:ShoppingList')->find($list_id);
		} else {
			throw new \Exception('Er is geen lijst meegegeven');
		}

		$products = $this->getDoctrine()->getRepository('FutureStoreSiteBundle:Product')->findAll();

		return $this->render('FutureStoreSiteBundle:Profile:add.product.html.twig', array(
			'products' => $products, 'list_id' => $list->getId(), 'list_name' => $list->getListName()
		));
	}

	public function showListsAction() {
		$lists = $this->getDoctrine()->getRepository('FutureStoreSiteBundle:ShoppingList')->findBy(array('user_id' => $this->getUser()->getId()));
		if(empty($lists)) $lists = null;
		return $this->render('FutureStoreSiteBundle:Profile:shopping.show.html.twig', array(
			'lists' => $lists
		));
	}

	public function showListProductsAction($list_id) {
		$listItems = $this->getDoctrine()->getRepository('FutureStoreSiteBundle:ShoppingListProduct')->findBy(array('shopping_list_id' => $list_id));
		$products = array();
		foreach($listItems as $item) {
			if($item->getShoppingList()->getUser()->getId() != $this->getUser()->getId()) throw new \Exception('Access denied');
			$products[$item->getAmount()] = $item->getProduct();
		}

		return $this->render('FutureStoreSiteBundle:Profile:shopping.products.html.twig', array(
			'products' => $products, 'list_name' => $this->getDoctrine()->getRepository('FutureStoreSiteBundle:ShoppingList')->find($list_id)->getListName(), 'list_id' => $list_id
		));
	}
}