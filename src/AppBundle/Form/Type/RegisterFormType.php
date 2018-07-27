<?php
// src/AppBundle/Form/Type/RegisterFormType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array(
                'maxlength' => 20,
                'style' => 'width: 200px;'
            )))
            ->add('surname', TextType::class, array('attr' => array(
                'maxlength' => 30,
                'style' => 'width: 300px;'
            )))
            ->add('login', TextType::class, array('attr' => array(
                'maxlength' => 20,
                'style' => 'width: 200px;'
            )))
            ->add('password', PasswordType::class, array('attr' => array(
                'maxlength' => 30,
                'style' => 'width: 300px;'
            )))
            ->add('repeatPassword', PasswordType::class, array('attr' => array(
                'maxlength' => 30,
                'style' => 'width: 300px;'
            )))
            ->add('email', EmailType::class, array('attr' => array(
                'maxlength' => 100,
                'style' => 'width: 350px;'
            )))
            ->add('repeatEmail', EmailType::class, array('attr' => array(
                'maxlength' => 100,
                'style' => 'width: 350px;'
            )))
            ->add('accept', CheckboxType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'AppBundle\Entity\RegisterForm',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'register_form_item'
        ));
    }
}
