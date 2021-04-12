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

namespace spec\Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api;

use Contributte\Comgate\Entity\Codes\PaymentMethodCode;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\Configuration;
use PhpSpec\ObjectBehavior;

final class ConfigurationSpec extends ObjectBehavior
{
    /** @var string */
    private const MERCHANT = '123456';

    /** @var string */
    private const EMAIL = 'info@oxyshop.cz';

    /** @var string */
    private const SECRET = 'abcf1234efgh5678ABCD1234EFGH1234';

    public function let(): void
    {
        $this->beConstructedWith(
            self::MERCHANT,
            self::SECRET,
            self::EMAIL,
            PaymentMethodCode::ALL,
            true,
        );
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Configuration::class);
    }

    public function it_is_merchant_string(): void
    {
        $this->getMerchant()->shouldReturn(self::MERCHANT);
    }

    public function it_is_secret_string(): void
    {
        $this->getSecret()->shouldReturn(self::SECRET);
    }

    public function it_is_method_string(): void
    {
        $this->getMethod()->shouldReturn(PaymentMethodCode::ALL);
    }

    public function it_is_test(): void
    {
        $this->isTest()->shouldReturn(true);
    }

    public function it_is_email(): void
    {
        $this->getEmail()->shouldReturn(self::EMAIL);
    }
}
