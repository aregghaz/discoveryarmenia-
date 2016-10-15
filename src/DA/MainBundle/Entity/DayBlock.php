<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class DayBlock
 *
 * @ORM\Table(name="day_block")
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\DayBlockTranslations")
 */
class DayBlock implements Translatable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    protected $name = '';

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string $location
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $location;

    /**
     * @var integer $hotel_3star
     * @ORM\ManyToOne(targetEntity="Hotel",  inversedBy="day_block3")
     * @ORM\JoinColumn(name="hotel_3_id", referencedColumnName="id")
     */
    protected $hotel_3star;

    /**
     * @var integer $hotel_4star
     * @ORM\ManyToOne(targetEntity="Hotel",  inversedBy="day_block4")
     * @ORM\JoinColumn(name="hotel_4_id", referencedColumnName="id")
     */
    protected $hotel_4star;

    /**
     * @var integer $hotel_5star
     * @ORM\ManyToOne(targetEntity="Hotel",  inversedBy="day_block5")
     * @ORM\JoinColumn(name="hotel_5_id", referencedColumnName="id")
     */
    protected $hotel_5star;

    /**
     * @var integer $gallery
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Gallery", cascade={"persist"})
     */
    protected $gallery;

    /**
     * @var integer $tour
     * @ORM\ManyToOne(targetEntity="Tour",  inversedBy="day_block")
     * @ORM\JoinColumn(name="tour_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $tour;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\DayBlockTranslations", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function __toString()
    {
        return ($this->name) ? $this->name : '';
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return DayBlock
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
     * Set title
     *
     * @param string $title
     *
     * @return DayBlock
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return DayBlock
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set hotel3star
     *
     * @param \DA\MainBundle\Entity\Hotel $hotel3star
     *
     * @return DayBlock
     */
    public function setHotel3star(\DA\MainBundle\Entity\Hotel $hotel3star = null)
    {
        $this->hotel_3star = $hotel3star;

        return $this;
    }

    /**
     * Get hotel3star
     *
     * @return \DA\MainBundle\Entity\Hotel
     */
    public function getHotel3star()
    {
        return $this->hotel_3star;
    }

    /**
     * Set hotel4star
     *
     * @param \DA\MainBundle\Entity\Hotel $hotel4star
     *
     * @return DayBlock
     */
    public function setHotel4star(\DA\MainBundle\Entity\Hotel $hotel4star = null)
    {
        $this->hotel_4star = $hotel4star;

        return $this;
    }

    /**
     * Get hotel4star
     *
     * @return \DA\MainBundle\Entity\Hotel
     */
    public function getHotel4star()
    {
        return $this->hotel_4star;
    }

    /**
     * Set hotel5star
     *
     * @param \DA\MainBundle\Entity\Hotel $hotel5star
     *
     * @return DayBlock
     */
    public function setHotel5star(\DA\MainBundle\Entity\Hotel $hotel5star = null)
    {
        $this->hotel_5star = $hotel5star;

        return $this;
    }

    /**
     * Get hotel5star
     *
     * @return \DA\MainBundle\Entity\Hotel
     */
    public function getHotel5star()
    {
        return $this->hotel_5star;
    }

    /**
     * Set gallery
     *
     * @param \Config\MediaBundle\Entity\Gallery $gallery
     *
     * @return DayBlock
     */
    public function setGallery(\Config\MediaBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Config\MediaBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\DayBlockTranslations $translation
     *
     * @return DayBlock
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\DayBlockTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\DayBlockTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\DayBlockTranslations $translation)
    {
        $this->translations->removeElement($translation);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Set tour
     *
     * @param \DA\MainBundle\Entity\Tour $tour
     *
     * @return DayBlock
     */
    public function setTour(\DA\MainBundle\Entity\Tour $tour = null)
    {
        $this->tour = $tour;

        return $this;
    }

    /**
     * Get tour
     *
     * @return \DA\MainBundle\Entity\Tour
     */
    public function getTour()
    {
        return $this->tour;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return DayBlock
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }
}
