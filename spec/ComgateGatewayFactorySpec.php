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

namespace spec\Oxyshop\Nextgen\Plugin\SyliusComgatePlugin;

use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\ComgateGatewayFactory;
use Payum\Core\GatewayFactoryInterface;
use PhpSpec\ObjectBehavior;

final class ComgateGatewayFactorySpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ComgateGatewayFactory::class);
        $this->shouldHaveType(GatewayFactoryInterface::class);
    }

    public function it_populate_config_run(): void
    {
        $this->createConfig([])->shouldBeArray();
    }
}
