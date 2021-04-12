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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Exception;

use Contributte\Comgate\Http\Response;

class PaymentStatusException extends ComgateException
{
    public function __construct(Response $response)
    {
        $message = sprintf(
            '[Comgate] Cannot get payment status: "%s", error code: %s, see %s',
            $response->getData()['message'],
            $response->getData()['code'],
            self::API_REFERENCE
        );

        parent::__construct($message);
    }
}
