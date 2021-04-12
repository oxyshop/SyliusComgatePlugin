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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Data;

use Contributte\Comgate\Entity\Codes\PaymentMethodCode;

final class PaymentMethodsProvider implements PaymentMethodsProviderInterface
{
    /**
     * @throws \ReflectionException
     *
     * @return array<string>
     */
    public function getPayments(): array
    {
        $reflection = new \ReflectionClass(PaymentMethodCode::class);

        return $reflection->getConstants();
    }
}
