<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Accommodation
 *
 * @ORM\Table(name="accommodation")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\AccommodationRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\AccommodationTranslations")
 */
class Accommodation implements Translatable
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
     * @var string slug
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=200, unique=true, nullable=false)
     */
    protected $slug;

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
     * @var $price_for_day
     * @ORM\Column(type="integer",length=10)
     */
    protected $price_for_day;

    /**
     * @var $price_for_month
     * @ORM\Column(type="integer",length=10)
     */
    protected $price_for_month;

    /**
     * @var $rooms
     * @ORM\Column(type="integer",length=2)
     */
    protected $rooms;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    protected $category;

    /**
     * @var integer $image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $image;
    
    /**
     * @var integer $banner_image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Gallery", cascade={"persist"})
     */
    protected $gallery;

    /**
     * @ORM\ManyToOne(targetEntity="Location",  inversedBy="accommodation")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;

    /**
     * @ORM\ManyToMany(targetEntity="Comfort", inversedBy="accommodation")
     */
    protected $comfort;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\AccommodationTranslations", mappedBy="object", cascade={"persist", "remove"})
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
     * @return Accommodation
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->title = $name;
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Accommodation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Accommodation
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
     * @return Accommodation
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
     * Set priceForDay
     *
     * @param integer $priceForDay
     *
     * @return Accommodation
     */
    public function setPriceForDay($priceForDay)
    {
        $this->price_for_day = $priceForDay;

        return $this;
    }

    /**
     * Get priceForDay
     *
     * @return integer
     */
    public function getPriceForDay()
    {
        return $this->price_for_day;
    }

    /**
     * Set priceForMonth
     *
     * @param integer $priceForMonth
     *
     * @return Accommodation
     */
    public function setPriceForMonth($priceForMonth)
    {
        $this->price_for_month = $priceForMonth;

        return $this;
    }

    /**
     * Get priceForMonth
     *
     * @return integer
     */
    public function getPriceForMonth()
    {
        return $this->price_for_month;
    }

    /**
     * Set rooms
     *
     * @param integer $rooms
     *
     * @return Accommodation
     */
    public function setRooms($rooms)
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * Get rooms
     *
     * @return integer
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Accommodation
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set gallery
     *
     * @param \Config\MediaBundle\Entity\Gallery $gallery
     *
     * @return Accommodation
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
     * Set location
     *
     * @param \DA\MainBundle\Entity\Location $location
     *
     * @return Accommodation
     */
    public function setLocation(\DA\MainBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \DA\MainBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\AccommodationTranslations $translation
     *
     * @return Accommodation
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\AccommodationTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\AccommodationTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\AccommodationTranslations $translation)
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
     * Set image
     *
     * @param \Config\MediaBundle\Entity\Media $image
     *
     * @return Accommodation
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

    /**
     * Add comfort
     *
     * @param \DA\MainBundle\Entity\Comfort $comfort
     *
     * @return Accommodation
     */
    public function addComfort(\DA\MainBundle\Entity\Comfort $comfort)
    {
        $this->comfort[] = $comfort;

        return $this;
    }

    /**
     * Remove comfort
     *
     * @param \DA\MainBundle\Entity\Comfort $comfort
     */
    public function removeComfort(\DA\MainBundle\Entity\Comfort $comfort)
    {
        $this->comfort->removeElement($comfort);
    }

    /**
     * Get comfort
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComfort()
    {
        return $this->comfort;
    }
}
