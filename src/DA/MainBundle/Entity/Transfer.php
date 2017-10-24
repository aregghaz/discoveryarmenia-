<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Transfer
 *
 * @ORM\Table(name="transfer")
 * @ORM\Entity(repositoryClass="DA\MainBundle\Entity\Repository\TransferRepository")
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\TransferTranslations")
 */
class Transfer implements Translatable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var $direction
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=200,nullable=true)
     */
    protected $direction;

    /**
     * @var array
     * @ORM\Column(type="array", nullable=true)
     */
    protected $types = array(
        'standart1_3' => 0,
        'standart4_8' => 0,
        'luxe1_3' => 0,
        'luxe1_7' => 0,
        'luxe1_18' => 0
    );

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\TransferTranslations", mappedBy="object", cascade={"persist", "remove"})
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
        return ($this->direction) ? $this->direction : '';
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
     * Set direction
     *
     * @param string $direction
     *
     * @return Transfer
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set types
     *
     * @param array $types
     *
     * @return Transfer
     */
    public function setTypes($types)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\TransferTranslations $translation
     *
     * @return Transfer
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\TransferTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\TransferTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\TransferTranslations $translation)
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
