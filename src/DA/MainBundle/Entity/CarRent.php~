<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class CarRent
 *
 * @ORM\Table(name="car_rent")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\CarRentRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\CarRentTranslations")
 */
class CarRent implements Translatable
{
    
    static $catRentType = array(
        'sedan' => 'Sedan',
        '4x4' => '4x4',
    );
    
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $name
     * @ORM\Column(type="string", length=200,nullable=false)
     */
    protected $name;

    //protected $properties;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    protected $price_list = array(
        'day1_2' => 0,
        'day3_4' => 0,
        'day5_6' => 0,
        'day7_8' => 0,
        'day9_10' => 0,
        'day_more' => 0,
    );

    /**
     * @var $type
     * @ORM\Column(type="string",length=200,nullable=true)
     */
    protected $type;

    /**
     * @var $type
     * @ORM\Column(type="integer",length=2,nullable=true)
     */
    protected $door;

    /**
     * @var $transmission
     * @ORM\Column(type="string",length=200,nullable=true)
     */
    protected $transmission;

    /**
     * @var $motor
     * @ORM\Column(type="string",length=200,nullable=true)
     */
    protected $motor;

    /**
     * @var integer image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $image;

    public function __toString()
    {
        return ($this->name) ? $this->name : '';
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
     * Set name
     *
     * @param string $name
     *
     * @return CarRent
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
     * Set priceList
     *
     * @param array $priceList
     *
     * @return CarRent
     */
    public function setPriceList($priceList)
    {
        $this->price_list = $priceList;

        return $this;
    }

    /**
     * Get priceList
     *
     * @return array
     */
    public function getPriceList()
    {
        return $this->price_list;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return CarRent
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set door
     *
     * @param integer $door
     *
     * @return CarRent
     */
    public function setDoor($door)
    {
        $this->door = $door;

        return $this;
    }

    /**
     * Get door
     *
     * @return integer
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * Set transmission
     *
     * @param string $transmission
     *
     * @return CarRent
     */
    public function setTransmission($transmission)
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     *
     * @return string
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * Set motor
     *
     * @param string $motor
     *
     * @return CarRent
     */
    public function setMotor($motor)
    {
        $this->motor = $motor;

        return $this;
    }

    /**
     * Get motor
     *
     * @return string
     */
    public function getMotor()
    {
        return $this->motor;
    }

    /**
     * Set image
     *
     * @param \Config\MediaBundle\Entity\Media $image
     *
     * @return CarRent
     */
    public function setImage(\Config\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Config\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }
}
