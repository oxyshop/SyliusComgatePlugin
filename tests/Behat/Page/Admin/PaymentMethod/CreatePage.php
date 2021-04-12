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

use Behat\Mink\Exception\ElementNotFoundException;
use Sylius\Behat\Page\Admin\PaymentMethod\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    /**
     * @throws ElementNotFoundException
     */
    public function setComgateGatewayMerchant(string $merchant): void
    {
        $this->getDocument()->fillField('Merchant ID', $merchant);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function setComgateGatewaySecretKey(string $secretKey): void
    {
        $this->getDocument()->fillField('Secret key', $secretKey);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function setComgateGatewayEmail(string $email): void
    {
        $this->getDocument()->fillField('Email', $email);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function setComgateGatewayPaymentMethod(string $method): void
    {
        $this->getDocument()->fillField('Payment method', $method);
    }

    /**
     * @throws ElementNotFoundException
     */
    public function setComgateGatewayTest(bool $test): void
    {
        $this->getDocument()->fillField('Test', $test);
    }
}
