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

namespace Tests\Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Behat\Page\Admin\PaymentMethod;

use Sylius\Behat\Page\Admin\PaymentMethod\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    public function setComgateGatewayMerchant(string $merchant): void;

    public function setComgateGatewaySecretKey(string $secretKey): void;

    public function setComgateGatewayEmail(string $email): void;

    public function setComgateGatewayPaymentMethod(string $paymentMethod): void;

    public function setComgateGatewayTest(bool $test): void;
}
