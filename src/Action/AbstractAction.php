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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Action;

use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\Comgate;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;

/**
 * AbstractAction with API and Gateway.
 */
abstract class AbstractAction implements ApiAwareInterface, ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /** @var Comgate */
    protected $api;

    /**
     * {@inheritdoc}
     */
    public function setApi($api): void
    {
        if (false === $api instanceof Comgate) {
            throw new UnsupportedApiException(sprintf(
                'Not supported. Expected %s instance to be set as api.',
                Comgate::class
            ));
        }

        $this->api = $api;
    }
}
