<?php
// src/AppBundle/Bundle/Menu.php
namespace AppBundle\Bundle;

use Doctrine\ORM\EntityManager;

class Menu
{
    protected $categories;
    protected $places;
    protected $isProvince;

    public function __construct(EntityManager $em, $category, $province)
    {
        $this->categories = $em->getRepository('AppBundle:Category')->getCategorySidebarList($category);
        $this->places = $em->getRepository('AppBundle:Province')->getPlaceSidebarList($province, $this->isProvince);
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getPlaces()
    {
        return $this->places;
    }

    public function isProvince()
    {
        return $this->isProvince;
    }
}
