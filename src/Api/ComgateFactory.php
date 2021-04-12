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

final class ComgateFactory
{
    /** @var string */
    public const MERCHANT_KEY = 'merchant';

    /** @var string */
    public const SECRET_KEY = 'secret';

    /** @var string */
    public const TEST_KEY = 'test';

    /** @var string */
    public const EMAIL_KEY = 'email';

    /** @var Comgate|null */
    private $api;

    public function create(Configuration $config): Comgate
    {
        if (null === $this->api) {
            $comgate = new \Contributte\Comgate\Comgate(
                $config->getMerchant(),
                $config->getSecret(),
                $config->isTest()
            );
            $httpClient = new \GuzzleHttp\Client([
                'base_uri' => ComgateInterface::API_URL,
            ]);

            $paymentService = new \Contributte\Comgate\Gateway\PaymentService(
                new \Contributte\Comgate\Http\HttpClient($httpClient, $comgate)
            );

            $this->api = new Comgate($paymentService, $config->getEmail(), $config->getMethod());
        }

        return $this->api;
    }
}
