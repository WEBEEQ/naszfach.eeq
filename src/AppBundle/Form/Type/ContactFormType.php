<?php
// src/AppBundle/Form/Type/ContactFormType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array('attr' => array(
                'maxlength' => 100,
                'style' => 'width: 350px;'
            )))
            ->add('subject', TextType::class, array('attr' => array(
                'maxlength' => 100,
                'style' => 'width: 350px;'
            )))
            ->add('message', TextareaType::class, array('attr' => array(
                'maxlength' => 10000,
                'style' => 'width: 350px; height: 130px;'
            )))
            ->add('save', SubmitType::class)
            ->add('reset', ResetType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'AppBundle\Entity\ContactForm',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'contact_form_item'
        ));
    }
}
