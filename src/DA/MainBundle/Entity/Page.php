<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\PageRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\PageTranslations")
 */
class Page implements Translatable
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
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $banner_title;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $banner_description;


    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer $banner_image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $banner_image;

    /**
     * @var integer $slider
     * @ORM\ManyToOne(targetEntity="DA\MainBundle\Entity\Slider", cascade={"persist"})
     */
    protected $slider;

    /**
     * @ORM\OneToMany(targetEntity="CustomField", mappedBy="object",cascade={"persist","remove"},orphanRemoval=true)
     */
    protected $custom_field;
    
    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\PageTranslations", mappedBy="object", cascade={"persist", "remove"})
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
     * @return Page
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
     * @return Page
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
     * @return Page
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
     * Set bannerTitle
     *
     * @param string $bannerTitle
     *
     * @return Page
     */
    public function setBannerTitle($bannerTitle)
    {
        $this->banner_title = $bannerTitle;

        return $this;
    }

    /**
     * Get bannerTitle
     *
     * @return string
     */
    public function getBannerTitle()
    {
        return $this->banner_title;
    }

    /**
     * Set bannerDescription
     *
     * @param string $bannerDescription
     *
     * @return Page
     */
    public function setBannerDescription($bannerDescription)
    {
        $this->banner_description = $bannerDescription;

        return $this;
    }

    /**
     * Get bannerDescription
     *
     * @return string
     */
    public function getBannerDescription()
    {
        return $this->banner_description;
    }

    /**
     * Set bannerImage
     *
     * @param \Config\MediaBundle\Entity\Media $bannerImage
     *
     * @return Page
     */
    public function setBannerImage(\Config\MediaBundle\Entity\Media $bannerImage = null)
    {
        $this->banner_image = $bannerImage;

        return $this;
    }

    /**
     * Get bannerImage
     *
     * @return \Config\MediaBundle\Entity\Media
     */
    public function getBannerImage()
    {
        return $this->banner_image;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\PageTranslations $translation
     *
     * @return Page
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\PageTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\PageTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\PageTranslations $translation)
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
     * Add customField
     *
     * @param \DA\MainBundle\Entity\CustomField $customField
     *
     * @return Page
     */
    public function addCustomField(\DA\MainBundle\Entity\CustomField $customField)
    {
        $this->custom_field[] = $customField;
        $customField->setObject($this);
        return $this;
    }

    /**
     * Remove customField
     *
     * @param \DA\MainBundle\Entity\CustomField $customField
     */
    public function removeCustomField(\DA\MainBundle\Entity\CustomField $customField)
    {
        $this->custom_field->removeElement($customField);
    }

    /**
     * Get customField
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomField()
    {
        return $this->custom_field;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Page
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
     * Set slider
     *
     * @param \DA\MainBundle\Entity\Slider $slider
     *
     * @return Page
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
}
