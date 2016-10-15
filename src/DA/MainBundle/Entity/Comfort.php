<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Room
 *
 * @ORM\Table(name="comfort")
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\ComfortTranslations")
 */
class Comfort implements Translatable
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
     * @var $category
     * @ORM\Column(type="integer",length=2)
     */
    protected $category;

    /**
     * @ORM\ManyToMany(targetEntity="Room", inversedBy="comfort")
     * @ORM\JoinTable(name="room_cross")
     */
    protected $room;

    /**
     * @ORM\ManyToMany(targetEntity="Hotel", inversedBy="comfort")
     * @ORM\JoinTable(name="hotel_cross")
     */
    protected $hotel;

    /**
     * @ORM\ManyToMany(targetEntity="Accommodation", inversedBy="comfort")
     * @ORM\JoinTable(name="accommodation_cross")
     */
    protected $accommodation;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\ComfortTranslations", mappedBy="object", cascade={"persist", "remove"})
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
        $this->hotel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accommodation = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Comfort
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
     * Set title
     *
     * @param string $title
     *
     * @return Comfort
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
     * Add room
     *
     * @param \DA\MainBundle\Entity\Room $room
     *
     * @return Comfort
     */
    public function addRoom(\DA\MainBundle\Entity\Room $room)
    {
        $this->room[] = $room;

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
     * Add hotel
     *
     * @param \DA\MainBundle\Entity\Hotel $hotel
     *
     * @return Comfort
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
     * Add accommodation
     *
     * @param \DA\MainBundle\Entity\Accommodation $accommodation
     *
     * @return Comfort
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
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\ComfortTranslations $translation
     *
     * @return Comfort
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\ComfortTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\ComfortTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\ComfortTranslations $translation)
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
     * Set category
     *
     * @param integer $category
     *
     * @return Comfort
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return integer
     */
    public function getCategory()
    {
        return $this->category;
    }
}
