<?php
// src/AppBundle/Entity/FirmCategory.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="firm_category", indexes={@ORM\Index(name="active", columns={"active"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FirmCategoryRepository")
 */
class FirmCategory
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
     * @ORM\ManyToOne(targetEntity="Firm", inversedBy="$firmCategories")
     * @ORM\JoinColumn(name="firm_id", referencedColumnName="id")
     */
    protected $firm;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="$firmCategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

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
     * @return FirmCategory
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
     * Set firm
     *
     * @param \AppBundle\Entity\Firm $firm
     *
     * @return FirmCategory
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

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return FirmCategory
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
