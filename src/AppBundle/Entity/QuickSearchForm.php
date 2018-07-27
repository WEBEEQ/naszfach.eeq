<?php
// src/AppBundle/Entity/QuickSearchForm.php
namespace AppBundle\Entity;

class QuickSearchForm
{
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
