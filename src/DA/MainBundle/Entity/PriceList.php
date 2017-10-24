<?php

namespace DA\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class PriceList
 *
 * @ORM\Table(name="price_list")
 * @ORM\Entity()
 *
 */
class PriceList
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m1_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m1_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m2_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m2_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m3_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m3_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m4_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m4_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m5_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m5_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m6_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m6_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m7_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m7_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m8_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m8_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m9_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m9_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m10_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m10_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m11_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m11_2;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m12_1;

    /**
     * @var integer
     * @ORM\Column(type="integer",length=10,nullable=true)
     */
    protected $m12_2;

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
     * Set m11
     *
     * @param integer $m11
     *
     * @return PriceList
     */
    public function setM11($m11)
    {
        $this->m1_1 = $m11;

        return $this;
    }

    /**
     * Get m11
     *
     * @return integer
     */
    public function getM11()
    {
        return $this->m1_1;
    }

    /**
     * Set m12
     *
     * @param integer $m12
     *
     * @return PriceList
     */
    public function setM12($m12)
    {
        $this->m1_2 = $m12;

        return $this;
    }

    /**
     * Get m12
     *
     * @return integer
     */
    public function getM12()
    {
        return $this->m1_2;
    }

    /**
     * Set m21
     *
     * @param integer $m21
     *
     * @return PriceList
     */
    public function setM21($m21)
    {
        $this->m2_1 = $m21;

        return $this;
    }

    /**
     * Get m21
     *
     * @return integer
     */
    public function getM21()
    {
        return $this->m2_1;
    }

    /**
     * Set m22
     *
     * @param integer $m22
     *
     * @return PriceList
     */
    public function setM22($m22)
    {
        $this->m2_2 = $m22;

        return $this;
    }

    /**
     * Get m22
     *
     * @return integer
     */
    public function getM22()
    {
        return $this->m2_2;
    }

    /**
     * Set m31
     *
     * @param integer $m31
     *
     * @return PriceList
     */
    public function setM31($m31)
    {
        $this->m3_1 = $m31;

        return $this;
    }

    /**
     * Get m31
     *
     * @return integer
     */
    public function getM31()
    {
        return $this->m3_1;
    }

    /**
     * Set m32
     *
     * @param integer $m32
     *
     * @return PriceList
     */
    public function setM32($m32)
    {
        $this->m3_2 = $m32;

        return $this;
    }

    /**
     * Get m32
     *
     * @return integer
     */
    public function getM32()
    {
        return $this->m3_2;
    }

    /**
     * Set m41
     *
     * @param integer $m41
     *
     * @return PriceList
     */
    public function setM41($m41)
    {
        $this->m4_1 = $m41;

        return $this;
    }

    /**
     * Get m41
     *
     * @return integer
     */
    public function getM41()
    {
        return $this->m4_1;
    }

    /**
     * Set m42
     *
     * @param integer $m42
     *
     * @return PriceList
     */
    public function setM42($m42)
    {
        $this->m4_2 = $m42;

        return $this;
    }

    /**
     * Get m42
     *
     * @return integer
     */
    public function getM42()
    {
        return $this->m4_2;
    }

    /**
     * Set m51
     *
     * @param integer $m51
     *
     * @return PriceList
     */
    public function setM51($m51)
    {
        $this->m5_1 = $m51;

        return $this;
    }

    /**
     * Get m51
     *
     * @return integer
     */
    public function getM51()
    {
        return $this->m5_1;
    }

    /**
     * Set m52
     *
     * @param integer $m52
     *
     * @return PriceList
     */
    public function setM52($m52)
    {
        $this->m5_2 = $m52;

        return $this;
    }

    /**
     * Get m52
     *
     * @return integer
     */
    public function getM52()
    {
        return $this->m5_2;
    }

    /**
     * Set m61
     *
     * @param integer $m61
     *
     * @return PriceList
     */
    public function setM61($m61)
    {
        $this->m6_1 = $m61;

        return $this;
    }

    /**
     * Get m61
     *
     * @return integer
     */
    public function getM61()
    {
        return $this->m6_1;
    }

    /**
     * Set m62
     *
     * @param integer $m62
     *
     * @return PriceList
     */
    public function setM62($m62)
    {
        $this->m6_2 = $m62;

        return $this;
    }

    /**
     * Get m62
     *
     * @return integer
     */
    public function getM62()
    {
        return $this->m6_2;
    }

    /**
     * Set m71
     *
     * @param integer $m71
     *
     * @return PriceList
     */
    public function setM71($m71)
    {
        $this->m7_1 = $m71;

        return $this;
    }

    /**
     * Get m71
     *
     * @return integer
     */
    public function getM71()
    {
        return $this->m7_1;
    }

    /**
     * Set m72
     *
     * @param integer $m72
     *
     * @return PriceList
     */
    public function setM72($m72)
    {
        $this->m7_2 = $m72;

        return $this;
    }

    /**
     * Get m72
     *
     * @return integer
     */
    public function getM72()
    {
        return $this->m7_2;
    }

    /**
     * Set m81
     *
     * @param integer $m81
     *
     * @return PriceList
     */
    public function setM81($m81)
    {
        $this->m8_1 = $m81;

        return $this;
    }

    /**
     * Get m81
     *
     * @return integer
     */
    public function getM81()
    {
        return $this->m8_1;
    }

    /**
     * Set m82
     *
     * @param integer $m82
     *
     * @return PriceList
     */
    public function setM82($m82)
    {
        $this->m8_2 = $m82;

        return $this;
    }

    /**
     * Get m82
     *
     * @return integer
     */
    public function getM82()
    {
        return $this->m8_2;
    }

    /**
     * Set m91
     *
     * @param integer $m91
     *
     * @return PriceList
     */
    public function setM91($m91)
    {
        $this->m9_1 = $m91;

        return $this;
    }

    /**
     * Get m91
     *
     * @return integer
     */
    public function getM91()
    {
        return $this->m9_1;
    }

    /**
     * Set m92
     *
     * @param integer $m92
     *
     * @return PriceList
     */
    public function setM92($m92)
    {
        $this->m9_2 = $m92;

        return $this;
    }

    /**
     * Get m92
     *
     * @return integer
     */
    public function getM92()
    {
        return $this->m9_2;
    }

    /**
     * Set m101
     *
     * @param integer $m101
     *
     * @return PriceList
     */
    public function setM101($m101)
    {
        $this->m10_1 = $m101;

        return $this;
    }

    /**
     * Get m101
     *
     * @return integer
     */
    public function getM101()
    {
        return $this->m10_1;
    }

    /**
     * Set m102
     *
     * @param integer $m102
     *
     * @return PriceList
     */
    public function setM102($m102)
    {
        $this->m10_2 = $m102;

        return $this;
    }

    /**
     * Get m102
     *
     * @return integer
     */
    public function getM102()
    {
        return $this->m10_2;
    }

    /**
     * Set m111
     *
     * @param integer $m111
     *
     * @return PriceList
     */
    public function setM111($m111)
    {
        $this->m11_1 = $m111;

        return $this;
    }

    /**
     * Get m111
     *
     * @return integer
     */
    public function getM111()
    {
        return $this->m11_1;
    }

    /**
     * Set m112
     *
     * @param integer $m112
     *
     * @return PriceList
     */
    public function setM112($m112)
    {
        $this->m11_2 = $m112;

        return $this;
    }

    /**
     * Get m112
     *
     * @return integer
     */
    public function getM112()
    {
        return $this->m11_2;
    }

    /**
     * Set m121
     *
     * @param integer $m121
     *
     * @return PriceList
     */
    public function setM121($m121)
    {
        $this->m12_1 = $m121;

        return $this;
    }

    /**
     * Get m121
     *
     * @return integer
     */
    public function getM121()
    {
        return $this->m12_1;
    }

    /**
     * Set m122
     *
     * @param integer $m122
     *
     * @return PriceList
     */
    public function setM122($m122)
    {
        $this->m12_2 = $m122;

        return $this;
    }

    /**
     * Get m122
     *
     * @return integer
     */
    public function getM122()
    {
        return $this->m12_2;
    }
}
