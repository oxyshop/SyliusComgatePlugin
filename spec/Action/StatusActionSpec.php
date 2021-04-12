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

namespace spec\Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Action;

use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Action\StatusAction;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayInterface;
use Payum\Core\Request\GetHttpRequest;
use Payum\Core\Request\Notify;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\PaymentInterface;

final class StatusActionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(StatusAction::class);
    }

    public function it_implements_action_interface(): void
    {
        $this->shouldHaveType(ActionInterface::class);
    }

    public function it_implements_api_aware_interface(): void
    {
        $this->shouldHaveType(ApiAwareInterface::class);
    }

    public function it_implements_gateway_aware_interface(): void
    {
        $this->shouldHaveType(GatewayAwareInterface::class);
    }

    /**
     * @param Notify|\PhpSpec\Wrapper\Collaborator           $request
     * @param \PhpSpec\Wrapper\Collaborator|PaymentInterface $payment
     */
    public function it_supports_only_capture_request_and_payment_interface(
        Notify $request,
        PaymentInterface $payment
    ): void {
        $request->getModel()->willReturn($payment);

        $this->supports($request)->shouldBeBoolean();
    }

    /**
     * @param Notify|\PhpSpec\Wrapper\Collaborator           $request
     * @param \PhpSpec\Wrapper\Collaborator|PaymentInterface $payment
     * @param GatewayInterface|\PhpSpec\Wrapper\Collaborator $gateway
     *
     * @throws \Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Exception\PaymentStatusException
     */
    public function it_executes(
        Notify $request,
        PaymentInterface $payment,
        GatewayInterface $gateway
    ): void {
        $httpRequest = new GetHttpRequest();
        $httpRequest->request = [
            'merchantReference' => '1000-11',
        ];

        $gateway->execute($httpRequest);
        $this->setGateway($gateway);

        $request->getModel()->willReturn($payment);
        $request->getFirstModel()->willReturn($payment);
    }
}
