<?php

namespace App\Form;

use App\Entity\Dobrovolnici;
use App\Entity\DobrovolniciAkceCiselnik;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->add('vek', NumberType::class, [
                'label' => 'Věk',
                'attr' => [
                    'class' => 'form-control mb-3',
                    'maxlength' => 3,  // max 3 znaky v inputu
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('telefon', TelType::class, [
                'label' => 'Telefon',
                'attr' => ['class' => 'form-control mb-3'],
            ])

            ->add('akce', EntityType::class, [
                'class' => DobrovolniciAkceCiselnik::class,
                'choice_label' => 'polozkaCiselniku',
                'multiple' => true,
                'expanded' => true, // musí být true
                'label' => 'Na jakých aktivitách se můžete/chcete podílet?',
                'choice_attr' => fn($choice, $key, $value) => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-check-label'],
            ])
            ->add('isZkusenosti', ChoiceType::class, [
                'label' => 'Máte předchozí zkušenosti s dobrovolnickou službou?',
                'choices' => [
                    'Ano' => true,
                    'Ne' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'choice_attr' => fn($choice, $key, $value) => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-check-label'],
            ])

            ->add('isSouhlasGdpr', CheckboxType::class, [
                'label' => 'Souhlasím se zpracováním osobních údajů (GDPR)',

                'attr' => ['class' => 'form-check-input mb-3 mt-3'],
                'label_attr' => ['class' => 'form-check-label me-3 mt-3 fw-bold'],
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
