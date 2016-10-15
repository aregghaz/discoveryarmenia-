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
 * @ORM\Table(name="custom_field")
 * @ORM\Entity()
 * @Gedmo\TranslationEntity(class="DA\MainBundle\Entity\Translations\CustomFieldTranslations")
 */
class CustomField implements Translatable
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
     * @ORM\Column(name="text1",type="string", length=200, nullable=true)
     */
    protected $key;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="text2",type="string", length=200, nullable=true)
     */
    protected $value;

    /**
     * @var integer $object
     * @ORM\ManyToOne(targetEntity="Page",  inversedBy="custom_field")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $object;

    /**
     * @ORM\OneToMany(targetEntity="DA\MainBundle\Entity\Translations\CustomFieldTranslations", mappedBy="object", cascade={"persist", "remove"})
     */
    protected $translations;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;
    
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
     * Set key
     *
     * @param string $key
     *
     * @return CustomField
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return CustomField
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
     * Set object
     *
     * @param \DA\MainBundle\Entity\Page $object
     *
     * @return CustomField
     */
    public function setObject(\DA\MainBundle\Entity\Page $object = null)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \DA\MainBundle\Entity\Page
     */
    public function getObject()
    {
        return $this->object;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Add translation
     *
     * @param \DA\MainBundle\Entity\Translations\CustomFieldTranslations $translation
     *
     * @return CustomField
     */
    public function addTranslation(\DA\MainBundle\Entity\Translations\CustomFieldTranslations $translation)
    {
        $this->translations[] = $translation;
        $translation->setObject($this);
        return $this;
    }

    /**
     * Remove translation
     *
     * @param \DA\MainBundle\Entity\Translations\CustomFieldTranslations $translation
     */
    public function removeTranslation(\DA\MainBundle\Entity\Translations\CustomFieldTranslations $translation)
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
