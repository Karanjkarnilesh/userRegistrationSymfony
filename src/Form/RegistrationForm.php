<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'label' => 'Username',
                    'required' => true,
                ]
            ])
            ->add('Email', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'label' => 'Username',
                    'required' => true,
                ]
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'label' => 'Phone',
                    'required' => true,
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => array(
                    'Male' => 'M',
                    'Female' =>'F',
                    'Other'=>null
                ),
                'attr' => [
                    'class'=>'form-control',
                    'label' => 'Gender',
                    'required' => true,
                ],
                'expanded' => true,
            ])
            ->add('birthDate', DateType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'label' => 'BirthDate',
                    'required' => true,
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class'=>'form-control',
                    'label' => 'Address',
                    'required' => true,
                ]
            ])
            ->add('zipcode', null, [
                'attr' => [
                    'class'=>'form-control',
                    'label' => 'Zipcode',
                    'required' => true,
                ]
            ])
            ->add('image', FileType::class, [
                'mapped' => true,
                'attr' => [
                    'label' => 'Image',
                    'class'=>'form-control',
                    'required' => true,
                ]
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field form-control')),
                'required' => true,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ));
    }
}
