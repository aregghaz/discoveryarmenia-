<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Slide
 *
 * @ORM\Table(name="slide")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\SlideRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\SlideTranslations")
 */
class Slide implements Translatable
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
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $url_title;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $url;

    /**
     * @var integer $image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $image;

    /**
     * @var integer $icon
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $icon;

    /**
     * @ORM\ManyToOne(targetEntity="Slider",  inversedBy="slide")
     * @ORM\JoinColumn(name="slider_id", referencedColumnName="id")
     */
    protected $slider;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=2,nullable=true)
     */
    protected $position = 1;
    
    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\SlideTranslations", mappedBy="object", cascade={"persist", "remove"})
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
     * @return Slide
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
     * @return Slide
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
     * @return Slide
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
     * Set urlTitle
     *
     * @param string $urlTitle
     *
     * @return Slide
     */
    public function setUrlTitle($urlTitle)
    {
        $this->url_title = $urlTitle;

        return $this;
    }

    /**
     * Get urlTitle
     *
     * @return string
     */
    public function getUrlTitle()
    {
        return $this->url_title;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Slide
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set image
     *
     * @param \Config\MediaBundle\Entity\Media $image
     *
     * @return Slide
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
     * Set icon
     *
     * @param \Config\MediaBundle\Entity\Media $icon
     *
     * @return Slide
     */
    public function setIcon(\Config\MediaBundle\Entity\Media $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return \Config\MediaBundle\Entity\Media
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set slider
     *
     * @param \DA\MainBundle\Entity\Slider $slider
     *
     * @return Slide
     */
    public function setSlider(\DA\MainBundle\Entity\Slider $slider = null)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return \DA\MainBundle\Entity\Slider
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\SlideTranslations $translation
     *
     * @return Slide
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\SlideTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\SlideTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\SlideTranslations $translation)
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
     * Set position
     *
     * @param integer $position
     *
     * @return Slide
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}
