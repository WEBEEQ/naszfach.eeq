<?php
// src/AppBundle/Form/Type/QuickSearchFormType.php
namespace AppBundle\Form\Type;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuickSearchFormType extends AbstractType
{
    protected $controller = null;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->controller->generateUrl('searchpage'))
            ->setMethod('POST')
            ->add('name', TextType::class, array('required' => false, 'attr' => array(
                'maxlength' => 100,
                'style' => 'width: 120px;'
            )))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'AppBundle\Entity\QuickSearchForm',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'quick_search_form_item'
        ));
    }
}
