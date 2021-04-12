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
use Contributte\Comgate\Gateway\PaymentService;

final class Comgate
{
    /** @var string */
    public const HASH_KEY_NAME = 'hash';

    /** @var string */
    public const TRANSACTION_ID_KEY_NAME = 'transId';

    /** @var PaymentService */
    private $gateway;

    /** @var string */
    private $method;

    /** @var string|null */
    private $email;

    public function __construct(
        PaymentService $gateway,
        ?string $email,
        string $method = PaymentMethodCode::ALL
    ) {
        $this->gateway = $gateway;
        $this->method = $method;
        $this->email = $email;
    }

    public function getGateway(): PaymentService
    {
        return $this->gateway;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
