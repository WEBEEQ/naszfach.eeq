<?php
// src/AppBundle/Bundle/QuickForm.php
namespace AppBundle\Bundle;

use AppBundle\Entity\QuickSearchForm;
use AppBundle\Form\Type\QuickSearchFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QuickForm
{
    protected $controller = null;
    protected $quickSearchForm;
    protected $quickForm;

    public function __construct(Controller $controller, &$request)
    {
        $this->controller = $controller;
        $this->quickSearchForm = new QuickSearchForm();
        $quickSearchFormType = new QuickSearchFormType($this->controller);
        $this->quickForm = $this->controller->createForm($quickSearchFormType, $this->quickSearchForm);
        $this->quickForm->handleRequest($request);
    }

    public function clearForm()
    {
        unset($this->quickSearchForm);
        unset($this->quickForm);
        $this->quickSearchForm = new QuickSearchForm();
        $quickSearchFormType = new QuickSearchFormType($this->controller);
        $this->quickForm = $this->controller->createForm($quickSearchFormType, $this->quickSearchForm);
    }

    public function setName($name)
    {
        $this->quickSearchForm->setName($name);
    }

    public function getName()
    {
        return $this->quickSearchForm->getName();
    }

    public function createView()
    {
        return $this->quickForm->createView();
    }
}
