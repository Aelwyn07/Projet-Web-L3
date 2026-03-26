<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductQuantityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choices = $options['quantity_choices'];

        $builder
            ->add('product_id', HiddenType::class)
            ->add('quantity', ChoiceType::class, [
                'choices' => $choices,
                'data' => 0, // 0 présélectionné
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'quantity_choices' => [],
        ]);
    }
}
