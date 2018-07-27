<?php
// src/AppBundle/Entity/Picture.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="picture",
 *     indexes={@ORM\Index(name="active", columns={"active"}), @ORM\Index(name="date_added", columns={"date_added"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Column(type="bigint", options={"unsigned":true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", options={"default":1})
     */
    protected $active;

    /**
     * @ORM\Column(type="string", length=50, options={"default":""})
     */
    protected $name;

    /**
     * @ORM\Column(name="`file`", type="string", length=25, options={"default":""})
     */
    protected $file;

    /**
     * @ORM\Column(type="smallint", options={"unsigned":true, "default":0})
     */
    protected $width;

    /**
     * @ORM\Column(type="smallint", options={"unsigned":true, "default":0})
     */
    protected $height;

    /**
     * @ORM\Column(type="string", length=30, options={"default":""})
     */
    protected $fileMini;

    /**
     * @ORM\Column(type="smallint", options={"unsigned":true, "default":0})
     */
    protected $widthMini;

    /**
     * @ORM\Column(type="smallint", options={"unsigned":true, "default":0})
     */
    protected $heightMini;

    /**
     * @ORM\Column(type="string", length=15, options={"default":""})
     */
    protected $ipAdded;

    /**
     * @ORM\Column(type="datetime", options={"default":"0000-00-00 00:00:00"})
     */
    protected $dateAdded;

    /**
     * @ORM\ManyToOne(targetEntity="Firm", inversedBy="pictures")
     * @ORM\JoinColumn(name="firm_id", referencedColumnName="id")
     */
    protected $firm;

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
     * Set active
     *
     * @param boolean $active
     *
     * @return Picture
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Picture
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
     * Set file
     *
     * @param string $file
     *
     * @return Picture
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return Picture
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Picture
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set fileMini
     *
     * @param string $fileMini
     *
     * @return Picture
     */
    public function setFileMini($fileMini)
    {
        $this->fileMini = $fileMini;

        return $this;
    }

    /**
     * Get fileMini
     *
     * @return string
     */
    public function getFileMini()
    {
        return $this->fileMini;
    }

    /**
     * Set widthMini
     *
     * @param integer $widthMini
     *
     * @return Picture
     */
    public function setWidthMini($widthMini)
    {
        $this->widthMini = $widthMini;

        return $this;
    }

    /**
     * Get widthMini
     *
     * @return integer
     */
    public function getWidthMini()
    {
        return $this->widthMini;
    }

    /**
     * Set heightMini
     *
     * @param integer $heightMini
     *
     * @return Picture
     */
    public function setHeightMini($heightMini)
    {
        $this->heightMini = $heightMini;

        return $this;
    }

    /**
     * Get heightMini
     *
     * @return integer
     */
    public function getHeightMini()
    {
        return $this->heightMini;
    }

    /**
     * Set ipAdded
     *
     * @param string $ipAdded
     *
     * @return Picture
     */
    public function setIpAdded($ipAdded)
    {
        $this->ipAdded = $ipAdded;

        return $this;
    }

    /**
     * Get ipAdded
     *
     * @return string
     */
    public function getIpAdded()
    {
        return $this->ipAdded;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return Picture
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set firm
     *
     * @param \AppBundle\Entity\Firm $firm
     *
     * @return Picture
     */
    public function setFirm(\AppBundle\Entity\Firm $firm = null)
    {
        $this->firm = $firm;

        return $this;
    }

    /**
     * Get firm
     *
     * @return \AppBundle\Entity\Firm
     */
    public function getFirm()
    {
        return $this->firm;
    }
}
