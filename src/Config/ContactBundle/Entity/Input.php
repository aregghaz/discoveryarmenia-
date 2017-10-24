<?php

namespace Config\ContactBundle\Entity;

use Config\MediaBundle\Lib\FileManager;
use Config\MediaBundle\Model\File;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

/**
 * Class Input
 * @package Config\Contact\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="input")
 * @ORM\Entity(repositoryClass="Config\ContactBundle\Entity\Repository\InputRepository")
 * @Gedmo\TranslationEntity(class="Config\ContactBundle\Entity\Translations\InputTranslations")
 */
class Input implements  Translatable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $type
     * @ORM\Column(type="string", length=150, nullable=false)
     * @Assert\NotBlank()
     */
    protected $type;

    /**
     * @var integer $form
     * @ORM\ManyToOne(targetEntity="Form",  inversedBy="input")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $form;

    /**
     * @var string $name
     * @ORM\Column(type="string", length=150, nullable=false)
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @var string $label
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Gedmo\Translatable
     */
    protected $label;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $disabled = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $multiple = false;

    /**
     * @var string $name
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Gedmo\Translatable
     */
    protected $placeholder;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $readonly = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $required = false;

    /**
     * @var string $name
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $value;

    /**
     * @var $order
     * @ORM\Column(name="position",type="integer",length=2)
     */
    protected $order = 1;

    /**
     * @ORM\OneToMany(targetEntity="Config\ContactBundle\Entity\Translations\InputTranslations", mappedBy="object", cascade={"persist", "remove"})
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
     * @return Input
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
     * Set label
     *
     * @param string $label
     *
     * @return Input
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set disabled
     *
     * @param boolean $disabled
     *
     * @return Input
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set multiple
     *
     * @param boolean $multiple
     *
     * @return Input
     */
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * Get multiple
     *
     * @return boolean
     */
    public function getMultiple()
    {
        return $this->multiple;
    }

    /**
     * Set placeholder
     *
     * @param string $placeholder
     *
     * @return Input
     */
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Get placeholder
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Set readonly
     *
     * @param boolean $readonly
     *
     * @return Input
     */
    public function setReadonly($readonly)
    {
        $this->readonly = $readonly;

        return $this;
    }

    /**
     * Get readonly
     *
     * @return boolean
     */
    public function getReadonly()
    {
        return $this->readonly;
    }

    /**
     * Set required
     *
     * @param boolean $required
     *
     * @return Input
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Input
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set type
     *
     * @param \Config\ContactBundle\Entity\InputTypes $type
     *
     * @return Input
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Config\ContactBundle\Entity\InputTypes
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add translation
     *
     * @param \Config\ContactBundle\Entity\Translations\InputTranslations $translation
     *
     * @return Input
     */
    public function addTranslation(\Config\ContactBundle\Entity\Translations\InputTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \Config\ContactBundle\Entity\Translations\InputTranslations $translation
     */
    public function removeTranslation(\Config\ContactBundle\Entity\Translations\InputTranslations $translation)
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
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set form
     *
     * @param \Config\ContactBundle\Entity\Form $form
     *
     * @return Input
     */
    public function setForm(\Config\ContactBundle\Entity\Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \Config\ContactBundle\Entity\Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Input
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }
}
