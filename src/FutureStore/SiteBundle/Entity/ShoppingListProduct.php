<?php
/**
 * Created by PhpStorm.
 * User: johan_000
 * Date: 1/23/14
 * Time: 3:02 PM
 */
namespace FutureStore\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="future_store_shopping_list_product")
 */
class ShoppingListProduct {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", length=11)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="integer", length=11)
	 */
	protected $shopping_list_id;

	/**
	 * @ORM\Column(type="integer", length=11)
	 */
	protected $product_id;

	/**
	 * @ORM\Column(type="integer", length=11)
	 */
	protected $amount;

	/**
	 * @ORM\ManyToOne(targetEntity="FutureStore\SiteBundle\Entity\ShoppingList", inversedBy="shopping_list_products")
	 * @ORM\JoinColumn(name="shopping_list_id", referencedColumnName="id")
	 */
	private $shopping_list;

	/**
	 * @ORM\ManyToOne(targetEntity="FutureStore\SiteBundle\Entity\Product", inversedBy="shopping_list_products")
	 * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
	 */
	private $product;

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
     * Set shopping_list_id
     *
     * @param integer $shoppingListId
     * @return ShoppingListProduct
     */
    public function setShoppingListId($shoppingListId)
    {
        $this->shopping_list_id = $shoppingListId;

        return $this;
    }

    /**
     * Get shopping_list_id
     *
     * @return integer 
     */
    public function getShoppingListId()
    {
        return $this->shopping_list_id;
    }

    /**
     * Set product_id
     *
     * @param integer $productId
     * @return ShoppingListProduct
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
     * Set amount
     *
     * @param integer $amount
     * @return ShoppingListProduct
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set shopping_list
     *
     * @param \FutureStore\SiteBundle\Entity\ShoppingList $shoppingList
     * @return ShoppingListProduct
     */
    public function setShoppingList(\FutureStore\SiteBundle\Entity\ShoppingList $shoppingList = null)
    {
        $this->shopping_list = $shoppingList;

        return $this;
    }

    /**
     * Get shopping_list
     *
     * @return \FutureStore\SiteBundle\Entity\ShoppingList 
     */
    public function getShoppingList()
    {
        return $this->shopping_list;
    }

    /**
     * Set product
     *
     * @param \FutureStore\SiteBundle\Entity\Product $product
     * @return ShoppingListProduct
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
}
