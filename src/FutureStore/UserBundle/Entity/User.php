<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/21/14
 * Time: 5:02 PM
 */
namespace FutureStore\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="future_store_user")
 */
class User extends BaseUser {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", length=11)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $login_token;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $nfc_token;

	/**
	 * @ORM\OneToMany(targetEntity="FutureStore\SiteBundle\Entity\ShoppingList", mappedBy="user")
	 */
	protected $shopping_lists;

	/**
	 * @ORM\OneToMany(targetEntity="FutureStore\ApiBundle\Entity\Payment", mappedBy="user")
	 */
	protected $payments;

	/**
	 * @ORM\OneToMany(targetEntity="FutureStore\ApiBundle\Entity\PaymentArticle", mappedBy="user")
	 */
	protected $payment_articles;

	public function __construct() {
		parent::__construct();
	}

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add shopping_lists
     *
     * @param \FutureStore\SiteBundle\Entity\ShoppingList $shoppingLists
     * @return User
     */
    public function addShoppingList(\FutureStore\SiteBundle\Entity\ShoppingList $shoppingLists)
    {
        $this->shopping_lists[] = $shoppingLists;

        return $this;
    }

    /**
     * Remove shopping_lists
     *
     * @param \FutureStore\SiteBundle\Entity\ShoppingList $shoppingLists
     */
    public function removeShoppingList(\FutureStore\SiteBundle\Entity\ShoppingList $shoppingLists)
    {
        $this->shopping_lists->removeElement($shoppingLists);
    }

    /**
     * Get shopping_lists
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShoppingLists()
    {
        return $this->shopping_lists;
    }

    /**
     * Set login_token
     *
     * @param string $loginToken
     * @return User
     */
    public function setLoginToken($loginToken)
    {
        $this->login_token = $loginToken;

        return $this;
    }

    /**
     * Get login_token
     *
     * @return string 
     */
    public function getLoginToken()
    {
        return $this->login_token;
    }

    /**
     * Add payments
     *
     * @param \FutureStore\ApiBundle\Entity\Payment $payments
     * @return User
     */
    public function addPayment(\FutureStore\ApiBundle\Entity\Payment $payments)
    {
        $this->payments[] = $payments;

        return $this;
    }

    /**
     * Remove payments
     *
     * @param \FutureStore\ApiBundle\Entity\Payment $payments
     */
    public function removePayment(\FutureStore\ApiBundle\Entity\Payment $payments)
    {
        $this->payments->removeElement($payments);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * Set nfc_token
     *
     * @param string $nfcToken
     * @return User
     */
    public function setNfcToken($nfcToken)
    {
        $this->nfc_token = $nfcToken;

        return $this;
    }

    /**
     * Get nfc_token
     *
     * @return string 
     */
    public function getNfcToken()
    {
        return $this->nfc_token;
    }

    /**
     * Add payment_articles
     *
     * @param \FutureStore\ApiBundle\Entity\PaymentArticle $paymentArticles
     * @return User
     */
    public function addPaymentArticle(\FutureStore\ApiBundle\Entity\PaymentArticle $paymentArticles)
    {
        $this->payment_articles[] = $paymentArticles;

        return $this;
    }

    /**
     * Remove payment_articles
     *
     * @param \FutureStore\ApiBundle\Entity\PaymentArticle $paymentArticles
     */
    public function removePaymentArticle(\FutureStore\ApiBundle\Entity\PaymentArticle $paymentArticles)
    {
        $this->payment_articles->removeElement($paymentArticles);
    }

    /**
     * Get payment_articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPaymentArticles()
    {
        return $this->payment_articles;
    }
}
