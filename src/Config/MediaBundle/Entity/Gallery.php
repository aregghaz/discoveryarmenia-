<?php

namespace Config\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Gallery
 * @package Config\Media\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="gallery")
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="Config\MediaBundle\Entity\Translations\GalleryTranslations")
 */
class Gallery implements  Translatable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    protected $name;

    /**
     * @var string $title
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string $description
     * @Gedmo\Translatable
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $enabled = true;

    /**
     * @var $media
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="gallery",  cascade={"persist"})
     * @ORM\JoinTable(name="gallery_has_media")
     */
    protected $media;

    /**
     * @ORM\OneToMany(targetEntity="Config\MediaBundle\Entity\Translations\GalleryTranslations", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return ($this->name) ? $this->name : '';
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
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return Gallery
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
     * @return Gallery
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Gallery
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Add medium
     *
     * @param \Config\MediaBundle\Entity\Media $medium
     *
     * @return Gallery
     */
    public function addMedia(\Config\MediaBundle\Entity\Media $medium)
    {
        $this->media[] = $medium;

        return $this;
    }

    /**
     * Remove medium
     *
     * @param \Config\MediaBundle\Entity\Media $medium
     */
    public function removeMedia(\Config\MediaBundle\Entity\Media $medium)
    {
        $this->media->removeElement($medium);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Add translation
     *
     * @param \Config\MediaBundle\Entity\Translations\GalleryTranslations $translation
     *
     * @return Gallery
     */
    public function addTranslation(\Config\MediaBundle\Entity\Translations\GalleryTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \Config\MediaBundle\Entity\Translations\GalleryTranslations $translation
     */
    public function removeTranslation(\Config\MediaBundle\Entity\Translations\GalleryTranslations $translation)
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
}
