<?php
// src/AppBundle/Entity/Category.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="category",
 *     indexes={@ORM\Index(name="active", columns={"active"}), @ORM\Index(name="name", columns={"name"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Column(type="integer", options={"unsigned":true})
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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="categories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="category")
     */
    protected $categories;

    /**
     * @ORM\OneToMany(targetEntity="FirmCategory", mappedBy="category")
     */
    protected $firmCategories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->firmCategories = new ArrayCollection();
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
     * Set active
     *
     * @param boolean $active
     *
     * @return Category
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
     * @return Category
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Category
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

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Category
     */
    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Category $category
     */
    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add firmCategory
     *
     * @param \AppBundle\Entity\FirmCategory $firmCategory
     *
     * @return Category
     */
    public function addFirmCategory(\AppBundle\Entity\FirmCategory $firmCategory)
    {
        $this->firmCategories[] = $firmCategory;

        return $this;
    }

    /**
     * Remove firmCategory
     *
     * @param \AppBundle\Entity\FirmCategory $firmCategory
     */
    public function removeFirmCategory(\AppBundle\Entity\FirmCategory $firmCategory)
    {
        $this->firmCategories->removeElement($firmCategory);
    }

    /**
     * Get firmCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirmCategories()
    {
        return $this->firmCategories;
    }
}
