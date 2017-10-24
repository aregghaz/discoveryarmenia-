<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Excursion
 *
 * @ORM\Table(name="excursion")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\ExcursionRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\ExcursionTranslations")
 */
class Excursion implements Translatable
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
     * @var integer $image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $image;

    /**
     * @var integer $gallery
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Gallery", cascade={"persist"})
     */
    protected $gallery;

    /**
     * @ORM\ManyToOne(targetEntity="Location",  inversedBy="excursion")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;

    /**
     * @ORM\ManyToOne(targetEntity="Location",  cascade={"persist"})
     */
    protected $current_location;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $guide = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $ticket = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $transport = false;

    /**
     * @var integer
     * @ORM\Column(type="string",length=4,nullable=true)
     */
    protected $duration;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $best_price = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $popular = false;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $price;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\ExcursionTranslations", mappedBy="object", cascade={"persist", "remove"})
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
     * @return Excursion
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
     * @return Excursion
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
     * @return Excursion
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
     * @return Excursion
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
     * Set guide
     *
     * @param boolean $guide
     *
     * @return Excursion
     */
    public function setGuide($guide)
    {
        $this->guide = $guide;

        return $this;
    }

    /**
     * Get guide
     *
     * @return boolean
     */
    public function getGuide()
    {
        return $this->guide;
    }

    /**
     * Set ticket
     *
     * @param boolean $ticket
     *
     * @return Excursion
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return boolean
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set transport
     *
     * @param boolean $transport
     *
     * @return Excursion
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Get transport
     *
     * @return boolean
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Excursion
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Excursion
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set image
     *
     * @param \Config\MediaBundle\Entity\Media $image
     *
     * @return Excursion
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
     * Set gallery
     *
     * @param \Config\MediaBundle\Entity\Gallery $gallery
     *
     * @return Excursion
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
     * @return Excursion
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
     * @param \DA\MainBundle\Entity\Translations\ExcursionTranslations $translation
     *
     * @return Excursion
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\ExcursionTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\ExcursionTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\ExcursionTranslations $translation)
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
     * Set currentLocation
     *
     * @param \DA\MainBundle\Entity\Location $currentLocation
     *
     * @return Excursion
     */
    public function setCurrentLocation(\DA\MainBundle\Entity\Location $currentLocation = null)
    {
        $this->current_location = $currentLocation;

        return $this;
    }

    /**
     * Get currentLocation
     *
     * @return \DA\MainBundle\Entity\Location
     */
    public function getCurrentLocation()
    {
        return $this->current_location;
    }

    /**
     * Set bestPrice
     *
     * @param boolean $bestPrice
     *
     * @return Excursion
     */
    public function setBestPrice($bestPrice)
    {
        $this->best_price = $bestPrice;

        return $this;
    }

    /**
     * Get bestPrice
     *
     * @return boolean
     */
    public function getBestPrice()
    {
        return $this->best_price;
    }

    /**
     * Set popular
     *
     * @param boolean $popular
     *
     * @return Excursion
     */
    public function setPopular($popular)
    {
        $this->popular = $popular;

        return $this;
    }

    /**
     * Get popular
     *
     * @return boolean
     */
    public function getPopular()
    {
        return $this->popular;
    }
}
