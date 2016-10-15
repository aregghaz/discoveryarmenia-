<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class UserInfo
 *
 * @ORM\Table(name="user_info")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\UserInfoRepository")
 */
class UserInfo
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string",length=30,nullable=true)
     */
    protected $user_ip;

    /**
     * @var string
     * @ORM\Column(type="string",length=30,nullable=true)
     */
    protected $user_cookie;

    /**
     * @var string
     * @ORM\Column(type="string",length=30,nullable=true)
     */
    protected $user_order_cookie;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user_info",cascade={"persist"})
     */
    protected $order;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->order = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set userIp
     *
     * @param string $userIp
     *
     * @return UserInfo
     */
    public function setUserIp($userIp)
    {
        $this->user_ip = $userIp;

        return $this;
    }

    /**
     * Get userIp
     *
     * @return string
     */
    public function getUserIp()
    {
        return $this->user_ip;
    }

    /**
     * Set userCookie
     *
     * @param string $userCookie
     *
     * @return UserInfo
     */
    public function setUserCookie($userCookie)
    {
        $this->user_cookie = $userCookie;

        return $this;
    }

    /**
     * Get userCookie
     *
     * @return string
     */
    public function getUserCookie()
    {
        return $this->user_cookie;
    }

    /**
     * Set userOrderCookie
     *
     * @param string $userOrderCookie
     *
     * @return UserInfo
     */
    public function setUserOrderCookie($userOrderCookie)
    {
        $this->user_order_cookie = $userOrderCookie;

        return $this;
    }

    /**
     * Get userOrderCookie
     *
     * @return string
     */
    public function getUserOrderCookie()
    {
        return $this->user_order_cookie;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return UserInfo
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
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return UserInfo
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add order
     *
     * @param \DA\MainBundle\Entity\Order $order
     *
     * @return UserInfo
     */
    public function addOrder(\DA\MainBundle\Entity\Order $order)
    {
        $this->order[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \DA\MainBundle\Entity\Order $order
     */
    public function removeOrder(\DA\MainBundle\Entity\Order $order)
    {
        $this->order->removeElement($order);
    }

    /**
     * Get order
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrder()
    {
        return $this->order;
    }
}
