<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class ArmeniaBlock
 *
 * @ORM\Table(name="armenia_block")
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\ArmeniaBlockTranslations")
 */
class ArmeniaBlock implements Translatable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @var integer $video
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Youtube", cascade={"persist"})
     */
    protected $video;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\ArmeniaBlockTranslations", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @var integer $armenia
     * @ORM\ManyToOne(targetEntity="Armenia",  inversedBy="block")
     * @ORM\JoinColumn(name="tour_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $armenia;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function __toString()
    {
        return ($this->title) ? $this->title : '';
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
     * Set title
     *
     * @param string $title
     *
     * @return ArmeniaBlock
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
     * @return ArmeniaBlock
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
     * Set image
     *
     * @param \Config\MediaBundle\Entity\Media $image
     *
     * @return ArmeniaBlock
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
     * Set video
     *
     * @param \Config\MediaBundle\Entity\Youtube $video
     *
     * @return ArmeniaBlock
     */
    public function setVideo(\Config\MediaBundle\Entity\Youtube $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return \Config\MediaBundle\Entity\Youtube
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\ArmeniaBlockTranslations $translation
     *
     * @return ArmeniaBlock
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\ArmeniaBlockTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\ArmeniaBlockTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\ArmeniaBlockTranslations $translation)
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
     * Set armenia
     *
     * @param \DA\MainBundle\Entity\ArmeniaBlock $armenia
     *
     * @return ArmeniaBlock
     */
    public function setArmenia(\DA\MainBundle\Entity\Armenia $armenia = null)
    {
        $this->armenia = $armenia;

        return $this;
    }

    /**
     * Get armenia
     *
     * @return \DA\MainBundle\Entity\Armenia
     */
    public function getArmenia()
    {
        return $this->armenia;
    }
}
