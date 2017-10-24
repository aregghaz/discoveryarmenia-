<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Seo
 *
 * @ORM\Table(name="seo")
 * @ORM\Entity()
 */
class Seo
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $title
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    protected $title;

    /**
     * @var $description
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;

    /**
     * @var $keywords
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    protected $keywords;
    
    // Social meta

    /**
     * @var $social_title
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    protected $social_title;

    /**
     * @var $social_description
     * @ORM\Column(type="text",nullable=true)
     */
    protected $social_description;

    /**
     * @var integer $social_image
     * @ORM\ManyToOne(targetEntity="Config\MediaBundle\Entity\Media", cascade={"persist"})
     */
    protected $social_image;

    /**
     * @var $image_size
     * @ORM\Column(type="integer",length=1,nullable=true)
     */
    protected $image_size;
    
    public function __toString()
    {
        return ($this->title) ? $this->title : '';
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
     * @return Seo
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
     * @return Seo
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
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Seo
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set socialTitle
     *
     * @param string $socialTitle
     *
     * @return Seo
     */
    public function setSocialTitle($socialTitle)
    {
        $this->social_title = $socialTitle;

        return $this;
    }

    /**
     * Get socialTitle
     *
     * @return string
     */
    public function getSocialTitle()
    {
        return $this->social_title;
    }

    /**
     * Set socialDescription
     *
     * @param string $socialDescription
     *
     * @return Seo
     */
    public function setSocialDescription($socialDescription)
    {
        $this->social_description = $socialDescription;

        return $this;
    }

    /**
     * Get socialDescription
     *
     * @return string
     */
    public function getSocialDescription()
    {
        return $this->social_description;
    }

    /**
     * Set imageSize
     *
     * @param integer $imageSize
     *
     * @return Seo
     */
    public function setImageSize($imageSize)
    {
        $this->image_size = $imageSize;

        return $this;
    }

    /**
     * Get imageSize
     *
     * @return integer
     */
    public function getImageSize()
    {
        return $this->image_size;
    }

    /**
     * Set socialImage
     *
     * @param \Config\MediaBundle\Entity\Media $socialImage
     *
     * @return Seo
     */
    public function setSocialImage(\Config\MediaBundle\Entity\Media $socialImage = null)
    {
        $this->social_image = $socialImage;

        return $this;
    }

    /**
     * Get socialImage
     *
     * @return \Config\MediaBundle\Entity\Media
     */
    public function getSocialImage()
    {
        return $this->social_image;
    }
}
