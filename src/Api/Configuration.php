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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api;

use Contributte\Comgate\Entity\Codes\PaymentMethodCode;

final class Configuration
{
    /** @var string */
    private $merchant;

    /** @var string */
    private $secret;

    /** @var string */
    private $method;

    /** @var string|null */
    private $email;

    /** @var bool */
    private $test;

    public function __construct(
        string $merchant,
        string $secret,
        ?string $email,
        string $method = PaymentMethodCode::ALL,
        bool $test = true
    ) {
        $this->merchant = $merchant;
        $this->secret = $secret;
        $this->method = $method;
        $this->email = $email;
        $this->test = $test;
    }

    public function getMerchant(): string
    {
        return $this->merchant;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function isTest(): bool
    {
        return $this->test;
    }
}
