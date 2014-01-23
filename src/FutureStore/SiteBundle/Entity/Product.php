<?php
/**
 * Created by PhpStorm.
 * User: johan_000
 * Date: 1/23/14
 * Time: 3:05 PM
 */
namespace FutureStore\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="future_store_product")
 */
class Product {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", length=11)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="decimal", precision=11, scale=2)
	 */
	protected $price;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $barcode;

	/**
	 * @ORM\OneToMany(targetEntity="FutureStore\SiteBundle\Entity\ShoppingListProduct", mappedBy="product")
	 */
	private $shopping_list_products;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shopping_list_products = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set barcode
     *
     * @param string $barcode
     * @return Product
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string 
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Add shopping_list_products
     *
     * @param \FutureStore\SiteBundle\Entity\ShoppingListProduct $shoppingListProducts
     * @return Product
     */
    public function addShoppingListProduct(\FutureStore\SiteBundle\Entity\ShoppingListProduct $shoppingListProducts)
    {
        $this->shopping_list_products[] = $shoppingListProducts;

        return $this;
    }

    /**
     * Remove shopping_list_products
     *
     * @param \FutureStore\SiteBundle\Entity\ShoppingListProduct $shoppingListProducts
     */
    public function removeShoppingListProduct(\FutureStore\SiteBundle\Entity\ShoppingListProduct $shoppingListProducts)
    {
        $this->shopping_list_products->removeElement($shoppingListProducts);
    }

    /**
     * Get shopping_list_products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getShoppingListProducts()
    {
        return $this->shopping_list_products;
    }
}
