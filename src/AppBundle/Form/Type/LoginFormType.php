<?php
// src/AppBundle/Form/Type/LoginFormType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, array('attr' => array(
                'maxlength' => 20,
                'style' => 'width: 200px;'
            )))
            ->add('password', PasswordType::class, array('required' => false, 'attr' => array(
                'maxlength' => 30,
                'style' => 'width: 300px;'
            )))
            ->add('forget', CheckboxType::class, array('required' => false))
            ->add('remember', CheckboxType::class, array('required' => false))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'      => 'AppBundle\Entity\LoginForm',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'login_form_item'
        ));
    }
}
