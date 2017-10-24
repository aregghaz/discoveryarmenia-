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
 * Class Tour
 *
 * @ORM\Table(name="tour")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\TourRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\TourTranslations")
 */
class Tour implements Translatable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer $tour_name
     * @ORM\ManyToOne(targetEntity="TourName",  inversedBy="tour")
     * @ORM\JoinColumn(name="tour_name_id", referencedColumnName="id")
     */
    protected $tour_name;

    /**
     * @var $day_count
     * @ORM\Column(type="integer",length=2,nullable=true)
     */
    protected $day_count;

    /**
     * @var $night_count
     * @ORM\Column(type="integer",length=2,nullable=true)
     */
    protected $night_count;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $weekend = false;

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
    protected $info;

    /**
     * @var integer $price
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $price;

    /**
     * @ORM\ManyToMany(targetEntity="Location", inversedBy="tour")
     * @ORM\JoinTable(name="location_cross")
     * @Groups({"location"})
     */
    protected $location;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $best_tour = false;

    /**
     * @ORM\OneToMany(targetEntity="DayBlock", mappedBy="tour",cascade={"persist","remove"},orphanRemoval=true)
     */
    protected $day_block;

    /**
     * @var integer $image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $image;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\TourTranslations", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;
    
    /*public function __toString()
    {
        return ($this->tour_name) ? $this->tour_name : '';
    }*/

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
        $this->day_block = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set description
     *
     * @param string $description
     *
     * @return Tour
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
     * Set info
     *
     * @param string $info
     *
     * @return Tour
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Tour
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
     * Set tourName
     *
     * @param \DA\MainBundle\Entity\TourName $tourName
     *
     * @return Tour
     */
    public function setTourName(\DA\MainBundle\Entity\TourName $tourName = null)
    {
        $this->tour_name = $tourName;

        return $this;
    }

    /**
     * Get tourName
     *
     * @return \DA\MainBundle\Entity\TourName
     */
    public function getTourName()
    {
        return $this->tour_name;
    }

    /**
     * Add location
     *
     * @param \DA\MainBundle\Entity\Location $location
     *
     * @return Tour
     */
    public function addLocation(\DA\MainBundle\Entity\Location $location)
    {
        $this->location[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \DA\MainBundle\Entity\Location $location
     */
    public function removeLocation(\DA\MainBundle\Entity\Location $location)
    {
        $this->location->removeElement($location);
    }

    /**
     * Get location
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add dayBlock
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock
     *
     * @return Tour
     */
    public function addDayBlock(\DA\MainBundle\Entity\DayBlock $dayBlock)
    {
        $this->day_block[] = $dayBlock;
        $dayBlock->setTour($this);
        return $this;
    }

    /**
     * Remove dayBlock
     *
     * @param \DA\MainBundle\Entity\DayBlock $dayBlock
     */
    public function removeDayBlock(\DA\MainBundle\Entity\DayBlock $dayBlock)
    {
        $this->day_block->removeElement($dayBlock);
    }

    /**
     * Get dayBlock
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDayBlock()
    {
        return $this->day_block;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\TourTranslations $translation
     *
     * @return Tour
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\TourTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\TourTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\TourTranslations $translation)
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
     * @return Tour
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
     * Set dayCount
     *
     * @param integer $dayCount
     *
     * @return Tour
     */
    public function setDayCount($dayCount)
    {
        $this->day_count = $dayCount;

        return $this;
    }

    /**
     * Get dayCount
     *
     * @return integer
     */
    public function getDayCount()
    {
        return $this->day_count;
    }

    /**
     * Set weekend
     *
     * @param boolean $weekend
     *
     * @return Tour
     */
    public function setWeekend($weekend)
    {
        $this->weekend = $weekend;

        return $this;
    }

    /**
     * Get weekend
     *
     * @return boolean
     */
    public function getWeekend()
    {
        return $this->weekend;
    }

    /**
     * Set nightCount
     *
     * @param integer $nightCount
     *
     * @return Tour
     */
    public function setNightCount($nightCount)
    {
        $this->night_count = $nightCount;

        return $this;
    }

    /**
     * Get nightCount
     *
     * @return integer
     */
    public function getNightCount()
    {
        return $this->night_count;
    }

    /**
     * Set bestTour
     *
     * @param boolean $bestTour
     *
     * @return Tour
     */
    public function setBestTour($bestTour)
    {
        $this->best_tour = $bestTour;

        return $this;
    }

    /**
     * Get bestTour
     *
     * @return boolean
     */
    public function getBestTour()
    {
        return $this->best_tour;
    }
}
