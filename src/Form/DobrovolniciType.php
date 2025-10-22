<?php

namespace App\Form;

use App\Entity\Dobrovolnici;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DobrovolniciType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jmeno', TextType::class, [
                'label' => 'Jméno',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'placeholder' => 'Zadejte své jméno',
                ],
            ])
            ->add('prijmeni', TextType::class, [
                'label' => 'Příjmení',
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('telefon', TelType::class, [
                'label' => 'Telefon',
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('isSouhlasGdpr', CheckboxType::class, [
                'label' => 'Souhlasím se zpracováním osobních údajů (GDPR)',
                'attr' => ['class' => 'form-check-input mb-3'],
                'label_attr' => ['class' => 'form-check-label me-3'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Odeslat',
                'attr' => ['class' => 'btn btn-sm btn-outline-primary rounded-pill mt-3 px-4 border-2'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dobrovolnici::class,
        ]);
    }
}
