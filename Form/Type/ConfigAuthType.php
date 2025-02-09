<?php

declare(strict_types=1);

namespace MauticPlugin\MauticYourlsBundle\Form\Type;

use MauticPlugin\MauticYourlsBundle\Validator\Constraints\Connection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigAuthType extends AbstractType
{
    public const SECRET_SIGNATURE_TOKEN = 'secret_signature_token';
    public const API_URL = 'api_url';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::SECRET_SIGNATURE_TOKEN,
            TextType::class,
            [
                'label'      => 'mautic.yourls.secret_signature_token',
                'label_attr' => ['class' => 'control-label'],
                'required'   => true,
                'attr'       => [
                    'class'   => 'form-control',
                    'tooltip' => 'mautic.yourls.secret_signature_token.tooltip',
                ],
                'constraints' => [
                    new Connection(),
                ],
            ]
        );

        $builder->add(
            self::API_URL,
            TextType::class,
            [
                'label'      => 'mautic.yourls.api_url',
                'label_attr' => ['class' => 'control-label'],
                'required'   => true,
                'attr'       => [
                    'class'   => 'form-control',
                    'tooltip' => 'mautic.yourls.api_url.tooltip',
                    'placeholder' => 'https://yourls.example.com/yourls-api.php',
                ],
                'constraints' => [
                    new Connection(),
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->setDefaults(
            [
                'integration' => null,
            ]
        );
    }
}
