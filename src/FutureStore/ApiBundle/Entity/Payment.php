<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/29/14
 * Time: 1:44 PM
 */
namespace FutureStore\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="future_store_payment")
 */
class Payment {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", length=11)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer", length=11)
	 */
	protected $user_id;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $has_payed;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $create_date;

	/**
	 * @ORM\ManyToOne(targetEntity="FutureStore\UserBundle\Entity\User", inversedBy="payments")
	 * @ORM\JoinColumn(referencedColumnName="id", name="user_id")
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="FutureStore\ApiBundle\Entity\PaymentArticle", mappedBy="payment")
	 */
	private $payment_articles;

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
     * Set user_id
     *
     * @param integer $userId
     * @return Payment
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set has_payed
     *
     * @param boolean $hasPayed
     * @return Payment
     */
    public function setHasPayed($hasPayed)
    {
        $this->has_payed = $hasPayed;

        return $this;
    }

    /**
     * Get has_payed
     *
     * @return boolean 
     */
    public function getHasPayed()
    {
        return $this->has_payed;
    }

    /**
     * Set create_date
     *
     * @param \DateTime $createDate
     * @return Payment
     */
    public function setCreateDate($createDate)
    {
        $this->create_date = $createDate;

        return $this;
    }

    /**
     * Get create_date
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * Set user
     *
     * @param \FutureStore\UserBundle\Entity\User $user
     * @return Payment
     */
    public function setUser(\FutureStore\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \FutureStore\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->payment_articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add payment_articles
     *
     * @param \FutureStore\ApiBundle\Entity\PaymentArticle $paymentArticles
     * @return Payment
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
