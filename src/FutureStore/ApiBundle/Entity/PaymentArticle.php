<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 1/29/14
 * Time: 2:43 PM
 */
namespace FutureStore\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="future_store_payment_article")
 */
class PaymentArticle {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", length=11)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer", length=11)
	 */
	protected $product_id;

	/**
	 * @ORM\Column(type="integer", length=11)
	 */
	protected $payment_id;

	/**
	 * @ORM\Column(type="integer", length=11)
	 */
	protected $quantity;

	/**
	 * @ORM\ManyToOne(targetEntity="FutureStore\SiteBundle\Entity\Product", inversedBy="payment_articles")
	 * @ORM\JoinColumn(referencedColumnName="id", name="product_id")
	 */
	private $product;

	/**
	 * @ORM\ManyToOne(targetEntity="FutureStore\ApiBundle\Entity\Payment", inversedBy="payment_articles")
	 * @ORM\JoinColumn(referencedColumnName="id", name="payment_id")
	 */
	private $payment;

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
     * Set product_id
     *
     * @param integer $productId
     * @return PaymentArticle
     */
    public function setProductId($productId)
    {
        $this->product_id = $productId;

        return $this;
    }

    /**
     * Get product_id
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set payment_id
     *
     * @param integer $paymentId
     * @return PaymentArticle
     */
    public function setPaymentId($paymentId)
    {
        $this->payment_id = $paymentId;

        return $this;
    }

    /**
     * Get payment_id
     *
     * @return integer 
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return PaymentArticle
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set product
     *
     * @param \FutureStore\SiteBundle\Entity\Product $product
     * @return PaymentArticle
     */
    public function setProduct(\FutureStore\SiteBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \FutureStore\SiteBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set payment
     *
     * @param \FutureStore\ApiBundle\Entity\Payment $payment
     * @return PaymentArticle
     */
    public function setPayment(\FutureStore\ApiBundle\Entity\Payment $payment = null)
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Get payment
     *
     * @return \FutureStore\ApiBundle\Entity\Payment 
     */
    public function getPayment()
    {
        return $this->payment;
    }
}
