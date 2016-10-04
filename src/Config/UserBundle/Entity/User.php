<?php

namespace Config\UserBundle\Entity;


use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Config\UserBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $code;
    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastname();
    }

    /**
     * @param  string $facebookID
     * @return void
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookUid = $facebookID;
        $this->setUsername($facebookID);
        $this->salt = '';
    }



    private $facebookAccessToken;


    /**
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }


    /**
     * Set code
     *
     * @param string $code
     *
     * @return User
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
