<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Product;
use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label')
            ->add('unit_price')
            ->add('stock')
            ->add('countries', 
                EntityType::class, 
                [
                    'class' => Country::class,
                    'label' => 'choisissez les pays',
                    'choice_label' => 'name',
                    'placeholder' => '------',
                    'multiple' => true,
                    'expanded' => true,       // checkbox
                    'mapped' => false,        // association déjà dans le controller
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
