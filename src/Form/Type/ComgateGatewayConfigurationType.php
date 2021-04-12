<?php

declare(strict_types=1);
/*
 * This file is part of oXyShop e-commerce platform
 *
 * (c) oXyShop <info@oxyshop.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Form\Type;

use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Data\PaymentMethodsProviderInterface;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Form\Constraints\Merchant;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Form\Constraints\SecretKey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ComgateGatewayConfigurationType extends AbstractType
{
    /** @var PaymentMethodsProviderInterface */
    private $paymentMethodsProvider;

    public function __construct(PaymentMethodsProviderInterface $paymentMethodsProvider)
    {
        $this->paymentMethodsProvider = $paymentMethodsProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('merchant', TextType::class, $this->getMerchantOptions())
            ->add('secret', TextType::class, $this->getSecretOptions())
            ->add('email', TextType::class, $this->getEmailOptions())
            ->add('method', ChoiceType::class, $this->getMethodOptions())
            ->add('test', CheckboxType::class, $this->getTestOptions())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'cascade_validation' => false,
        ]);
    }

    /**
     * @return array<string>
     */
    private function getMerchantOptions(): array
    {
        return [
            'label' => 'oxyshop_sylius_comgate_plugin.form.merchant',
            'constraints' => [
                new NotBlank([
                    'message' => 'oxyshop_sylius_comgate_plugin.form.merchant.not_blank',
                    'groups' => 'sylius',
                ]),
                new Merchant([
                    'message' => 'oxyshop_sylius_comgate_plugin.form.merchant.not_regex',
                    'groups' => 'sylius',
                ]),
            ],
        ];
    }

    /**
     * @return array<string>
     */
    private function getSecretOptions(): array
    {
        return [
            'label' => 'oxyshop_sylius_comgate_plugin.form.secret',
            'constraints' => [
                new NotBlank([
                    'message' => 'oxyshop_sylius_comgate_plugin.form.secret.not_blank',
                    'groups' => 'sylius',
                ]),
                new SecretKey([
                    'message' => 'oxyshop_sylius_comgate_plugin.form.secret.not_regex',
                    'groups' => 'sylius',
                ]),
            ],
        ];
    }

    /**
     * @return array<string>
     */
    private function getEmailOptions(): array
    {
        return [
            'label' => 'oxyshop_sylius_comgate_plugin.form.email',
            'constraints' => [
                new NotBlank([
                    'message' => 'oxyshop_sylius_comgate_plugin.form.email.not_blank',
                    'groups' => 'sylius',
                ]),
                new Email([
                    'message' => 'oxyshop_sylius_comgate_plugin.form.email.not_email',
                    'groups' => 'sylius',
                ]),
            ],
        ];
    }

    /**
     * @return array<string>
     */
    private function getMethodOptions(): array
    {
        return [
            'label' => 'oxyshop_sylius_comgate_plugin.form.method',
            'placeholder' => 'oxyshop_sylius_comgate_plugin.form.method_placeholder',
            'choices' => $this->paymentMethodsProvider->getPayments(),
            'choice_label' => static function (string $choice, string $key, string $value) {
                return sprintf('oxyshop_sylius_comgate_plugin.form.methods.%s', \mb_strtolower($key));
            },
            'constraints' => [
                new NotBlank([
                    'message' => 'oxyshop_sylius_comgate_plugin.form.method.not_blank',
                    'groups' => 'sylius',
                ]),
            ],
        ];
    }

    /**
     * @return array<string>
     */
    private function getTestOptions(): array
    {
        return [
            'label' => 'oxyshop_sylius_comgate_plugin.form.test',
        ];
    }
}
