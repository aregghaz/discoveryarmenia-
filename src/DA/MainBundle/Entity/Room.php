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
 * Class Room
 *
 * @ORM\Table(name="room")
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\RoomTranslations")
 */
class Room implements Translatable
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
    protected $type;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToMany(targetEntity="Comfort", inversedBy="room")
     */
    protected $comfort;

    /**
     * @var $visitors_number
     * @ORM\Column(type="integer",length=2)
     */
    protected $visitors_number;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $conditions;

    /**
     * @var array
     * @Groups({"filter"})
     * @ORM\Column(type="array", nullable=true)
     */
    public $price = array(
        'm1-1'   => 0,
        'm1-2'   => 0,
        'm2-1'   => 0,
        'm2-2'   => 0,
        'm3-1'   => 0,
        'm3-2'   => 0,
        'm4-1'   => 0,
        'm4-2'   => 0,
        'm5-1'   => 0,
        'm5-2'   => 0,
        'm6-1'   => 0,
        'm6-2'   => 0,
        'm7-1'   => 0,
        'm7-2'   => 0,
        'm8-1'   => 0,
        'm8-2'   => 0,
        'm9-1'   => 0,
        'm9-2'   => 0,
        'm10-1'  => 0,
        'm10-2'  => 0,
        'm11-1'  => 0,
        'm11-2'  => 0,
        'm12-1'  => 0,
        'm12-2'  => 0,
    );

    /**
     * @ORM\ManyToOne(targetEntity="Hotel",  inversedBy="room")
     * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
     */
    protected $hotel;
    
    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\RoomTranslations", mappedBy="object", cascade={"persist", "remove"})
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
        return ($this->type) ? $this->type : '';
    }
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set type
     *
     * @param string $type
     *
     * @return Room
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
     * Set description
     *
     * @param string $description
     *
     * @return Room
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
     * Set visitorsNumber
     *
     * @param integer $visitorsNumber
     *
     * @return Room
     */
    public function setVisitorsNumber($visitorsNumber)
    {
        $this->visitors_number = $visitorsNumber;

        return $this;
    }

    /**
     * Get visitorsNumber
     *
     * @return integer
     */
    public function getVisitorsNumber()
    {
        return $this->visitors_number;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return Room
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Add comfort
     *
     * @param \DA\MainBundle\Entity\Comfort $comfort
     *
     * @return Room
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
     * Set hotel
     *
     * @param \DA\MainBundle\Entity\Hotel $hotel
     *
     * @return Room
     */
    public function setHotel(\DA\MainBundle\Entity\Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \DA\MainBundle\Entity\Hotel
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\RoomTranslations $translation
     *
     * @return Room
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\RoomTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\RoomTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\RoomTranslations $translation)
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
     * Set price
     *
     * @param array $price
     *
     * @return Room
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return array
     */
    public function getPrice()
    {
        return $this->price;
    }
}
