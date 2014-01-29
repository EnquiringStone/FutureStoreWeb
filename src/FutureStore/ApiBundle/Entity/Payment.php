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
	protected $create_data;

	/**
	 * @ORM\ManyToOne(targetEntity="FutureStore\UserBundle\Entity\User", inversedBy="payments")
	 * @ORM\JoinColumn(referencedColumnName="id", name="user_id")
	 */
	private $user;


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
     * Set create_data
     *
     * @param \DateTime $createData
     * @return Payment
     */
    public function setCreateData($createData)
    {
        $this->create_data = $createData;

        return $this;
    }

    /**
     * Get create_data
     *
     * @return \DateTime 
     */
    public function getCreateData()
    {
        return $this->create_data;
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
}
