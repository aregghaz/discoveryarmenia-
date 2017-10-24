<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty as VirtualProperty;


/**
 * Class Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\LocationTranslations")
 */
class Location implements Translatable
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
     * @var int
     * @Groups({"location"})
     * @ORM\Column(type="float",length=20,nullable=true)
     */
    protected $latitude;

    /**
     * @var int
     * @Groups({"location"})
     * @ORM\Column(type="float",length=20,nullable=true)
     */
    protected $longitude;

    /**
     * @var string
     * @Groups({"filter"})
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="Accommodation", mappedBy="location", cascade={"persist"})
     */
    protected $accommodation;

    /**
     * @ORM\OneToMany(targetEntity="Hotel", mappedBy="location", cascade={"persist"})
     */
    protected $hotel;

    /**
     * @ORM\OneToMany(targetEntity="Excursion", mappedBy="location", cascade={"persist"})
     */
    protected $excursion;

    /**
     * @ORM\ManyToMany(targetEntity="Tour", inversedBy="location")
     */
    protected $tour;
    
    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\LocationTranslations", mappedBy="object", cascade={"persist", "remove"})
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
     * @return Location
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
     * @return Location
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
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Location
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
     * Set category
     *
     * @param string $category
     *
     * @return Location
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
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\LocationTranslations $translation
     *
     * @return Location
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\LocationTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\LocationTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\LocationTranslations $translation)
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
     * Add accommodation
     *
     * @param \DA\MainBundle\Entity\Accommodation $accommodation
     *
     * @return Location
     */
    public function addAccommodation(\DA\MainBundle\Entity\Accommodation $accommodation)
    {
        $this->accommodation[] = $accommodation;

        return $this;
    }

    /**
     * Remove accommodation
     *
     * @param \DA\MainBundle\Entity\Accommodation $accommodation
     */
    public function removeAccommodation(\DA\MainBundle\Entity\Accommodation $accommodation)
    {
        $this->accommodation->removeElement($accommodation);
    }

    /**
     * Get accommodation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccommodation()
    {
        return $this->accommodation;
    }

    /**
     * Add hotel
     *
     * @param \DA\MainBundle\Entity\Hotel $hotel
     *
     * @return Location
     */
    public function addHotel(\DA\MainBundle\Entity\Hotel $hotel)
    {
        $this->hotel[] = $hotel;

        return $this;
    }

    /**
     * Remove hotel
     *
     * @param \DA\MainBundle\Entity\Hotel $hotel
     */
    public function removeHotel(\DA\MainBundle\Entity\Hotel $hotel)
    {
        $this->hotel->removeElement($hotel);
    }

    /**
     * Get hotel
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Add excursion
     *
     * @param \DA\MainBundle\Entity\Excursion $excursion
     *
     * @return Location
     */
    public function addExcursion(\DA\MainBundle\Entity\Excursion $excursion)
    {
        $this->excursion[] = $excursion;

        return $this;
    }

    /**
     * Remove excursion
     *
     * @param \DA\MainBundle\Entity\Excursion $excursion
     */
    public function removeExcursion(\DA\MainBundle\Entity\Excursion $excursion)
    {
        $this->excursion->removeElement($excursion);
    }

    /**
     * Get excursion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExcursion()
    {
        return $this->excursion;
    }

    /**
     * Add tour
     *
     * @param \DA\MainBundle\Entity\Tour $tour
     *
     * @return Location
     */
    public function addTour(\DA\MainBundle\Entity\Tour $tour)
    {
        $this->tour[] = $tour;

        return $this;
    }

    /**
     * Remove tour
     *
     * @param \DA\MainBundle\Entity\Tour $tour
     */
    public function removeTour(\DA\MainBundle\Entity\Tour $tour)
    {
        $this->tour->removeElement($tour);
    }

    /**
     * Get tour
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTour()
    {
        return $this->tour;
    }

    public function getClassName(){
        return 'Location';
    }
}
