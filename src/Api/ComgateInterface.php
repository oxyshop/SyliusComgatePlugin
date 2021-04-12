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

interface ComgateInterface
{
    /** @var string */
    public const API_URL = 'https://payments.comgate.cz/v1.0/'; // @todo Use constant from package Contributte/Comgate

    /** @var array */
    public const RESPONSE_OK = ['code' => 0, 'message' => 'OK'];
}
