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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin;

use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\ComgateFactory;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\Configuration;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

final class ComgateGatewayFactory extends GatewayFactory
{
    /** @var string */
    public const NAME = 'comgate';

    /** @var string */
    public const TITLE = 'Comgate';

    /**
     * {@inheritdoc}
     */
    protected function populateConfig(ArrayObject $config): void
    {
        $config->defaults([
            'payum.factory_name' => self::NAME,
            'payum.factory_title' => self::TITLE,
        ]);

        $config['payum.required_options'] = [
            'merchant',
            'secret',
            'email',
        ];

        $config['payum.api'] = static function (ArrayObject $config) {
            $config->validateNotEmpty($config['payum.required_options']);
            [
                'merchant' => $merchant,
                'secret' => $secret,
                'email' => $email,
                'method' => $method,
                'test' => $test,
            ] = $config;
            $apiConfig = new Configuration($merchant, $secret, $email, $method, $test);
            $apiFactory = new ComgateFactory();

            return $apiFactory->create($apiConfig);
        };
    }
}
