<?php
// src/AppBundle/Entity/SearchForm.php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class SearchForm
{
    /**
     * @Assert\Length(max = 100, maxMessage = "Firma może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $name;

    /**
     * @Assert\Length(max = 30, maxMessage = "Ulica może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $street;

    /**
     * @Assert\Length(max = 6, maxMessage = "Kod pocztowy może zawierać maksymalnie {{ limit }} znaków.")
     */
    protected $postcode;

    protected $city;
    protected $province;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    public function getPostcode()
    {
        return $this->postcode;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setProvince($province)
    {
        $this->province = $province;
    }

    public function getProvince()
    {
        return $this->province;
    }
}
