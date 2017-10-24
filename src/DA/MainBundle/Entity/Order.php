<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Order
 *
 * @ORM\Table(name="order_list")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer $user_info
     * @ORM\ManyToOne(targetEntity="UserInfo",  inversedBy="order")
     * @ORM\JoinColumn(name="user_info_id", referencedColumnName="id",onDelete="cascade")
     */
    protected $user_info;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=2,nullable=true)
     */
    protected $order_status;

    /**
     * @var string
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $user_mail;

    /**
     * @var string
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $user_name;

    /**
     * @var string
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $user_last_name;

    /**
     * @var string
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $user_telephone;

    /**
     * @var string
     * @ORM\Column(type="string",length=100,nullable=true)
     */
    protected $user_organization;

    /**
     * @var array
     * @ORM\Column(type="array",nullable=true)
     */
    protected $order_list = array();

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

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
     * Set orderStatus
     *
     * @param integer $orderStatus
     *
     * @return Order
     */
    public function setOrderStatus($orderStatus)
    {
        $this->order_status = $orderStatus;

        return $this;
    }

    /**
     * Get orderStatus
     *
     * @return integer
     */
    public function getOrderStatus()
    {
        return $this->order_status;
    }

    /**
     * Set userMail
     *
     * @param string $userMail
     *
     * @return Order
     */
    public function setUserMail($userMail)
    {
        $this->user_mail = $userMail;

        return $this;
    }

    /**
     * Get userMail
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->user_mail;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return Order
     */
    public function setUserName($userName)
    {
        $this->user_name = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Set userLastName
     *
     * @param string $userLastName
     *
     * @return Order
     */
    public function setUserLastName($userLastName)
    {
        $this->user_last_name = $userLastName;

        return $this;
    }

    /**
     * Get userLastName
     *
     * @return string
     */
    public function getUserLastName()
    {
        return $this->user_last_name;
    }

    /**
     * Set userTelephone
     *
     * @param string $userTelephone
     *
     * @return Order
     */
    public function setUserTelephone($userTelephone)
    {
        $this->user_telephone = $userTelephone;

        return $this;
    }

    /**
     * Get userTelephone
     *
     * @return string
     */
    public function getUserTelephone()
    {
        return $this->user_telephone;
    }

    /**
     * Set userOrganization
     *
     * @param string $userOrganization
     *
     * @return Order
     */
    public function setUserOrganization($userOrganization)
    {
        $this->user_organization = $userOrganization;

        return $this;
    }

    /**
     * Get userOrganization
     *
     * @return string
     */
    public function getUserOrganization()
    {
        return $this->user_organization;
    }

    /**
     * Set orderList
     *
     * @param array $orderList
     *
     * @return Order
     */
    public function setOrderList($orderList)
    {
        $this->order_list = $orderList;

        return $this;
    }

    /**
     * Get orderList
     *
     * @return array
     */
    public function getOrderList()
    {
        return $this->order_list;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Order
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set userInfo
     *
     * @param \DA\MainBundle\Entity\UserInfo $userInfo
     *
     * @return Order
     */
    public function setUserInfo(\DA\MainBundle\Entity\UserInfo $userInfo = null)
    {
        $this->user_info = $userInfo;

        return $this;
    }

    /**
     * Get userInfo
     *
     * @return \DA\MainBundle\Entity\UserInfo
     */
    public function getUserInfo()
    {
        return $this->user_info;
    }
}
