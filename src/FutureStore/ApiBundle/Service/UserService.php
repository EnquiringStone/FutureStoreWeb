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
use FutureStore\ApiBundle\Entity\Payment;
use FutureStore\ApiBundle\Entity\PaymentArticle;
use FutureStore\ApiBundle\Interfaces\ApiInterface;
use FutureStore\SiteBundle\Entity\Product;
use FutureStore\SiteBundle\Entity\ShoppingListProduct;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

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

	public function getProductByCode($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('login_token' => $data['login_token']))) {
			$product = $this->manager->getRepository('FutureStoreSiteBundle:Product')->findOneBy(array('barcode' => $data['barcode']));
			if(empty($product)) throw new \Exception('Product not found');
			return array('name' => $product->getName(), 'price' => $product->getPrice());
		}
		throw new \Exception('Access denied');
	}

	public function getShoppingLists($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('login_token' => $data['login_token']))) {
			$lists = array();
			foreach($user->getShoppingLists() as $shoppingList) {
				foreach($shoppingList->getShoppingListProducts() as $product) {
					$lists[$shoppingList->getId()][] = array(
						'list_name' => $shoppingList->getListName(),
						'product_name' => $product->getProduct()->getName(),
						'product_price'	=> $product->getProduct()->getPrice(),
						'quantity' => $product->getAmount(),
						'product_id' => $product->getProduct()->getId()
					);
				}
			}
			if(empty($lists)) throw new \Exception('Geen lijst gevonden voor gebruiker '.$user->getUsername());
			return array('shopping_lists' => $lists);
		}
		throw new \Exception('Access denied');
	}

	public function addProduct($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('login_token' => $data['login_token']))) {
			$product = new Product();
			$product->setBarcode($data['barcode']);
			$product->setName($data['product_name']);
			$product->setPrice(doubleval($data['product_price']));
			$this->manager->persist($product);
			$this->manager->flush();
			return;
		}
	}

	public function addProductToList($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('login_token' => $data['login_token']))) {
			$product = $this->manager->getRepository('FutureStoreSiteBundle:Product')->findOneBy(array('barcode' => $data['barcode']));
			if(empty($product)) throw new \Exception('Het product bestaat niet');
			$list = $this->manager->getRepository('FutureStoreSiteBundle"ShoppingList')->find($data['list_id']);
			if(empty($list)) throw new \Exception('De lijst bestaat niet');
			if($list->getUser()->getId() != $user->getId()) throw new \Exception('Access denied');
			$listProduct = new ShoppingListProduct();
			$listProduct->setProduct($product);
			$listProduct->setShoppingList($list);
			$listProduct->setAmount(1);
			$this->manager->persist($listProduct);
			$this->manager->flush();
			return;
		}
	}

	public function addAmount($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('login_token' => $data['login_token']))) {
			$listProduct = $this->manager->getRepository('FutureStoreSiteBundle:ShoppingListProduct')->findOneBy(array('shopping_list_id' => $data['list_id'], 'product_id' => $data['product_id']));
			if(empty($listProduct)) throw new \Exception('Het product is niet gevonden in de lijst');
			if($listProduct->getShoppingList()->getUser()->getId() != $user->getId()) throw new \Exception('Access denied');
			$listProduct->setAmount($listProduct->getAmount() + intval($data['amount']));
			$this->manager->flush();
			return array('current_amount' => $listProduct->getAmount());
		}
	}

	public function bindNFCToUser($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('username' => $data['username']))) {
			$user->setNfcToken($data['nfc_id']);
			$this->manager->flush();
			return;
		}
		throw new \Exception('Gebruiker bestaat niet');
	}

	public function payTheBills($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('login_token' => $data['login_token']))) {
			$payment = new Payment();
			$payment->setCreateDate(new \DateTime());
			$payment->setHasPayed(false);
			$payment->setUser($user);
			$this->manager->persist($payment);

			foreach(explode(',',$data['inventory']) as $item) {
				$articleData = explode('=', $item);
				$article = new PaymentArticle();
				$product = $this->manager->getRepository('FutureStoreSiteBundle:Product')->findOneBy(array('barcode' => $articleData[0]));
				$article->setProduct($product);
				$article->setPayment($payment);
				$article->setQuantity(intval($articleData[1]));
				$this->manager->persist($article);
			}
			$this->manager->flush();
			return;
		}
	}

	public function getPayment($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('nfc_token' => $data['nfc_id']))) {
			$payments = $this->manager->getRepository('FutureStoreApiBundle:Payment')->findBy(array('user_id' => $user->getId(), 'has_payed' => 0));
			$lastPayment = null;
			foreach($payments as $payment) {
				if($lastPayment == null || $lastPayment->getCreateDate() < $payment->getCreateDate()) {
					$lastPayment = $payment;
				}
			}
			if($lastPayment == null) throw new \Exception('Geen betaling gevonden');
			$price = 0;
			foreach($lastPayment->getPaymentArticles() as $article) {
				$price += ($article->getProduct()->getPrice() * $article->getQuantity());
			}
			return array('price' => $price, 'payment_id' => $lastPayment->getId());
		}
	}

	public function finishPayment($data) {
		if($user = $this->manager->getRepository('FutureStoreUserBundle:User')->findOneBy(array('nfc_token' => $data['nfc_id']))) {
			$payment = $this->manager->getRepository('FutureStoreApiBundle:Payment')->find($data['payment_id']);
			if(empty($payment)) throw new \Exception('Betaling niet gevonden');
			$payment->setHasPayed(true);
			$this->manager->flush();
			return;
		}
	}

	public function getName() {
		return 'user';
	}

	/**
	 * @param $user
	 * @param $password
	 * @return bool
	 */
	protected function validatePassword($user, $password) {
		$encoder = $this->encoderFactory->getEncoder($user);
		return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
	}
}