<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Social
 *
 * @ORM\Table(name="social")
 * @ORM\Entity()
 */
class Social implements Translatable
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
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    protected $link;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $blank = true;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    protected $icon;

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
     * @return Social
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
     * Set link
     *
     * @param string $link
     *
     * @return Social
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set blank
     *
     * @param boolean $blank
     *
     * @return Social
     */
    public function setBlank($blank)
    {
        $this->blank = $blank;

        return $this;
    }

    /**
     * Get blank
     *
     * @return boolean
     */
    public function getBlank()
    {
        return $this->blank;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return Social
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
