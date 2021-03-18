<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\TimeZone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'date',
                DateType::class,
                [
                    'widget' => 'choice',
                    'years' => range((int)date('Y') - 200, (int)date('Y') + 5),
                    'mapped' => false
                ]
            )
            ->add(
                'timezone',
                TimezoneType::class,
                [
                    'mapped' => false
                ]
            )
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => self::class,
            ]
        );
    }
}