<?php

namespace App\Form;

use App\Entity\Province;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProvinceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('image')
            ->add('submit',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-primary shadow-sm hover:bg-indigo-700 bg-indigo-600'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Province::class,
        ]);
    }
}
