<?php
/**
 * Created by PhpStorm.
 * User: johan_000
 * Date: 1/23/14
 * Time: 2:41 PM
 */
namespace FutureStore\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="future_store_shopping_list")
 */
class ShoppingList {

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
	 * @ORM\Column(type="string", length=255)
	 */
	protected $list_name;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created_at;

	/**
	 * @ORM\ManyToOne(targetEntity="FutureStore\UserBundle\Entity\User", inversedBy="shopping_lists")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity="FutureStore\SiteBundle\Entity\ShoppingListProduct", mappedBy="shopping_list")
	 */
	private $shopping_list_products;

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
     * @return ShoppingList
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
     * Set user
     *
     * @param \FutureStore\UserBundle\Entity\User $user
     * @return ShoppingList
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
     * Set list_name
     *
     * @param string $listName
     * @return ShoppingList
     */
    public function setListName($listName)
    {
        $this->list_name = $listName;

        return $this;
    }

    /**
     * Get list_name
     *
     * @return string 
     */
    public function getListName()
    {
        return $this->list_name;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return ShoppingList
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->shopping_list_products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add shopping_list_products
     *
     * @param \FutureStore\SiteBundle\Entity\ShoppingListProduct $shoppingListProducts
     * @return ShoppingList
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
