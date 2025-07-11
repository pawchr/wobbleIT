<?php

namespace App\Form;

use App\Entity\User;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class RegistrationForm extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('email', null, [
            'label' => false,
        ])
        ->add('name', null, [
            'label' => false,
        ])
        ->add('surname', null, [
            'label' => false,
        ])
        ->add('birth_date', DateType::class, [
            'widget' => 'single_text',
            'html5' => true,
            'label' => false,
            'required' => true,
            'attr' => [
                'max' => (new \DateTime())->format('Y-m-d'),
                'placeholder' => 'Birth date',
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'mapped' => false,
            'label' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    'max' => 4096,
                ]),
            ],
        ])
        ->add('confirmPassword', PasswordType::class, [
            'mapped' => false,
            'label' => false,
            'constraints' => [
                new NotBlank(['message' => 'Please confirm your password']),
            ],
        ])
        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'label' => 'I accept the Terms of Service, the AUP and Privacy Policy',
            'label_attr' => [
                'class' => 'text-darkgreen',
            ],
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ]);
                $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $password = $form->get('plainPassword')->getData();
                $confirmPassword = $form->get('confirmPassword')->getData();

                if ($password !== $confirmPassword) {
                    $form->get('confirmPassword')->addError(new \Symfony\Component\Form\FormError('Passwords do not match.'));
                }
            });
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
