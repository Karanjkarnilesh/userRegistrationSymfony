<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'label' => 'Email',
                    'required' => true,
                ]
            ])
            ->add(
                'password',
                PasswordType::class,
                [
                    'attr' => ['class' => 'form-control'],
                    'required' => true,
                ]
            );
    }
}
