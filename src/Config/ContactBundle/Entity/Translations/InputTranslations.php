<?php

namespace Config\ContactBundle\Entity\Translations;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="input_translations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="input_trans_lookup_unique_idx", columns={
 *         "locale", "object_id", "field"
 *     })}
 * )
 */
class InputTranslations extends AbstractPersonalTranslation
{

    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string $locale
     *
     * @ORM\Column(type="string", length=8)
     */
    protected $locale;

    /**
     * @var string $field
     *
     * @ORM\Column(type="string", length=32)
     */
    protected $field;

    /**
     * @var text $content
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\ManyToOne(targetEntity="Config\ContactBundle\Entity\Input", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;

    /**
     * Get field
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }


    /**
     * Set content
     *
     * @param string $content
     * @return InputTranslations
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set object
     *
     * @param \Config\ContactBundle\Entity\Input $object
     * @return InputTranslations
     */
    public function setObject($object = null)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \Config\ContactBundle\Entity\Input
     */
    public function getObject()
    {
        return $this->object;
    }

}
