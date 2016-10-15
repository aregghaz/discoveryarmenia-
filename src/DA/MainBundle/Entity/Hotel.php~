<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Hotel
 *
 * @ORM\Table(name="hotels")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\HotelRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\HotelTranslations")
 */
class Hotel implements Translatable
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
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $short_description;

    /**
     * @var $star
     * @ORM\Column(type="integer",length=1,nullable=true)
     */
    protected $star;
    
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
     * @ORM\ManyToOne(targetEntity="Location",  inversedBy="hotel")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;

    /**
     * @ORM\OneToMany(targetEntity="Room", mappedBy="hotel",cascade={"persist","remove"},orphanRemoval=true)
     */
    protected $room;

    /**
     * @ORM\ManyToMany(targetEntity="Comfort", inversedBy="hotel")
     */
    protected $comfort;

    /**
     * @ORM\OneToMany(targetEntity="DayBlock", mappedBy="hotel_3star",cascade={"persist"})
     */
    protected $day_block3;

    /**
     * @ORM\OneToMany(targetEntity="DayBlock", mappedBy="hotel_4star",cascade={"persist"})
     */
    protected $day_block4;

    /**
     * @ORM\OneToMany(targetEntity="DayBlock", mappedBy="hotel_5star",cascade={"persist"})
     */
    protected $day_block5;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\HotelTranslations", mappedBy="object", cascade={"persist", "remove"})
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
        $this->room = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comfort = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Hotel
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
     * @return Hotel
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
     * @return Hotel
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
     * @return Hotel
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
     * Set shortDescription
     *
     * @param string $shortDescription
     *
     * @return Hotel
     */
    public function setShortDescription($shortDescription)
    {
        $this->short_description = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->short_description;
    }

    /**
     * Set image
     *
     * @param \Config\MediaBundle\Entity\Media $image
     *
     * @return Hotel
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
     * @return Hotel
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
     * @return Hotel
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
     * Add room
     *
     * @param \DA\MainBundle\Entity\Room $room
     *
     * @return Hotel
     */
    public function addRoom(\DA\MainBundle\Entity\Room $room)
    {
        $this->room[] = $room;
        $room->setHotel($this);
        return $this;
    }

    /**
     * Remove room
     *
     * @param \DA\MainBundle\Entity\Room $room
     */
    public function removeRoom(\DA\MainBundle\Entity\Room $room)
    {
        $this->room->removeElement($room);
    }

    /**
     * Get room
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Add comfort
     *
     * @param \DA\MainBundle\Entity\Comfort $comfort
     *
     * @return Hotel
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

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\HotelTranslations $translation
     *
     * @return Hotel
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\HotelTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\HotelTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\HotelTranslations $translation)
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
     * Set star
     *
     * @param integer $star
     *
     * @return Hotel
     */
    public function setStar($star)
    {
        $this->star = $star;

        return $this;
    }

    /**
     * Get star
     *
     * @return integer
     */
    public function getStar()
    {
        return $this->star;
    }

    /**
     * Add dayBlock3
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock3
     *
     * @return Hotel
     */
    public function addDayBlock3(\DA\MainBundle\Entity\DayBlock $dayBlock3)
    {
        $this->day_block3[] = $dayBlock3;

        return $this;
    }

    /**
     * Remove dayBlock3
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock3
     */
    public function removeDayBlock3(\DA\MainBundle\Entity\DayBlock $dayBlock3)
    {
        $this->day_block3->removeElement($dayBlock3);
    }

    /**
     * Get dayBlock3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDayBlock3()
    {
        return $this->day_block3;
    }

    /**
     * Add dayBlock4
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock4
     *
     * @return Hotel
     */
    public function addDayBlock4(\DA\MainBundle\Entity\DayBlock $dayBlock4)
    {
        $this->day_block4[] = $dayBlock4;

        return $this;
    }

    /**
     * Remove dayBlock4
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock4
     */
    public function removeDayBlock4(\DA\MainBundle\Entity\DayBlock $dayBlock4)
    {
        $this->day_block4->removeElement($dayBlock4);
    }

    /**
     * Get dayBlock4
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDayBlock4()
    {
        return $this->day_block4;
    }

    /**
     * Add dayBlock5
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock5
     *
     * @return Hotel
     */
    public function addDayBlock5(\DA\MainBundle\Entity\DayBlock $dayBlock5)
    {
        $this->day_block5[] = $dayBlock5;

        return $this;
    }

    /**
     * Remove dayBlock5
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock5
     */
    public function removeDayBlock5(\DA\MainBundle\Entity\DayBlock $dayBlock5)
    {
        $this->day_block5->removeElement($dayBlock5);
    }

    /**
     * Get dayBlock5
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDayBlock5()
    {
        return $this->day_block5;
    }
}
