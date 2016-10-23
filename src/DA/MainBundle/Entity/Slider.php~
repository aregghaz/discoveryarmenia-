<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity()
 */
class Slider implements Translatable
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
     * @ORM\OneToMany(targetEntity="Slide", mappedBy="slider",cascade={"persist","remove"},orphanRemoval=true)
     */
    protected $slide;

    public function __toString()
    {
        return ($this->name) ? $this->name : '';
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->slide = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Slider
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
     * Add slide
     *
     * @param \DA\MainBundle\Entity\Slide $slide
     *
     * @return Slider
     */
    public function addSlide(\DA\MainBundle\Entity\Slide $slide)
    {
        $this->slide[] = $slide;
        $slide->setSlider($this);
        return $this;
    }

    /**
     * Remove slide
     *
     * @param \DA\MainBundle\Entity\Slide $slide
     */
    public function removeSlide(\DA\MainBundle\Entity\Slide $slide)
    {
        $this->slide->removeElement($slide);
    }

    /**
     * Get slide
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSlide()
    {
        return $this->slide;
    }
}
