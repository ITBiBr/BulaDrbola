<?php

namespace App\Form;

use App\Entity\Dobrovolnici;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DobrovolniciType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jmeno')
            ->add('prijmeni')
            ->add('email')
            ->add('telefon')
            ->add('isSouhlasGdpr')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dobrovolnici::class,
        ]);
    }
}
