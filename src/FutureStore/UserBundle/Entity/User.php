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
	 * @ORM\OneToMany(targetEntity="FutureStore\SiteBundle\Entity\ShoppingList", mappedBy="user")
	 */
	protected $shopping_lists;

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
}
