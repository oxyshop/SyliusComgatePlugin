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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\DependencyInjection\Compiler;

use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\ComgateGatewayFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ManagingPaymentMethodsContextPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $managingPaymentMethodsContext = $container->getDefinition('sylius.behat.context.ui.admin.managing_payment_methods');
        $gatewayFactories = $managingPaymentMethodsContext->getArgument(5);
        $gatewayFactories[ComgateGatewayFactory::NAME] = ComgateGatewayFactory::TITLE;
        $managingPaymentMethodsContext->replaceArgument(5, $gatewayFactories);
    }
}
