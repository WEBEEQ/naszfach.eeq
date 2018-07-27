<?php
// src/AppBundle/Entity/Province.php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="province",
 *     indexes={@ORM\Index(name="active", columns={"active"}), @ORM\Index(name="name", columns={"name"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProvinceRepository")
 */
class Province
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
     * @ORM\OneToMany(targetEntity="City", mappedBy="province")
     */
    protected $cities;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="province")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Firm", mappedBy="province")
     */
    protected $firms;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
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
     * @return Province
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
     * @return Province
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
     * Add city
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return Province
     */
    public function addCity(\AppBundle\Entity\City $city)
    {
        $this->cities[] = $city;

        return $this;
    }

    /**
     * Remove city
     *
     * @param \AppBundle\Entity\City $city
     */
    public function removeCity(\AppBundle\Entity\City $city)
    {
        $this->cities->removeElement($city);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Province
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
     * @return Province
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
