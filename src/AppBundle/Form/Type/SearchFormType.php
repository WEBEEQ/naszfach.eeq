<?php
// src/AppBundle/Form/Type/SearchFormType.php
namespace AppBundle\Form\Type;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchFormType extends AbstractType
{
    protected $controller = null;
    protected $province = null;

    public function __construct(Controller $controller, $province)
    {
        $this->controller = $controller;
        $this->province = $province;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formProvinces = $this->controller->getDoctrine()->getRepository('AppBundle:Province')->getProvinces();
        $formCites = $this->controller->getDoctrine()->getRepository('AppBundle:City')->getCities($this->province);
        $provinceArray[0] = null;
        $cityArray[0] = null;

        foreach ($formProvinces as $formProvince) {
            $provinceId = $formProvince->getId();
            $provinceName = $formProvince->getName();
            $provinceArray[$provinceId] = isset($provinceId) ? $provinceName : null;
        }
        foreach ($formCites as $formCity) {
            $cityId = $formCity->getId();
            $cityName = $formCity->getName();
            $cityArray[$cityId] = isset($cityId) ? $cityName : null;
        }

        $builder
            ->add('name', TextType::class, array('required' => false, 'attr' => array(
                'maxlength' => 100,
                'style' => 'width: 350px;'
            )))
            ->add('street', TextType::class, array('required' => false, 'attr' => array(
                'maxlength' => 30,
                'style' => 'width: 300px;'
            )))
            ->add('postcode', TextType::class, array('required' => false, 'attr' => array(
                'maxlength' => 6,
                'style' => 'width: 60px;'
            )))
            ->add('city', ChoiceType::class, array('choices' => $cityArray))
            ->add('province', ChoiceType::class, array('choices' => $provinceArray))
            ->add('save', SubmitType::class)
            ->add('reset', ResetType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'AppBundle\Entity\SearchForm',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'search_form_item'
        ));
    }
}
