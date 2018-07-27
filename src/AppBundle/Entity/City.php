<?php
// src/AppBundle/Entity/City.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="city",
 *     indexes={@ORM\Index(name="active", columns={"active"}), @ORM\Index(name="name", columns={"name"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 */
class City
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
     * @ORM\Column(type="string", length=30, options={"default":""})
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="cities")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     */
    protected $province;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="city")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Firm", mappedBy="city")
     */
    protected $firms;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->firms = new ArrayCollection();
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
     * @return City
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
     * @return City
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
     * Set province
     *
     * @param \AppBundle\Entity\Province $province
     *
     * @return City
     */
    public function setProvince(\AppBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \AppBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return City
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add firm
     *
     * @param \AppBundle\Entity\Firm $firm
     *
     * @return City
     */
    public function addFirm(\AppBundle\Entity\Firm $firm)
    {
        $this->firms[] = $firm;

        return $this;
    }

    /**
     * Remove firm
     *
     * @param \AppBundle\Entity\Firm $firm
     */
    public function removeFirm(\AppBundle\Entity\Firm $firm)
    {
        $this->firms->removeElement($firm);
    }

    /**
     * Get firms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFirms()
    {
        return $this->firms;
    }
}
