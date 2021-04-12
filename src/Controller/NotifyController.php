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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Controller;

use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\Comgate;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\ComgateInterface;
use Payum\Core\Exception\LogicException;
use Payum\Core\Model\PaymentInterface;
use Payum\Core\Payum;
use Payum\Core\Reply\HttpPostRedirect;
use Payum\Core\Request\GetHumanStatus;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\PaymentRepository;
use Sylius\Bundle\PayumBundle\Model\PaymentSecurityTokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class NotifyController extends AbstractController
{
    /** @var Payum */
    private $payum;

    /** @var PaymentRepository */
    private $paymentRepository;

    public function __construct(Payum $payum, PaymentRepository $paymentRepository)
    {
        $this->payum = $payum;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Background HTTP notification of the payment.
     */
    public function notifyAction(Request $request): Response
    {
        if (null === $paymentId = $request->get('refId', null)) {
            throw new LogicException('A parameter refId not be found.');
        }

        /** @var PaymentInterface|null $payment */
        $payment = $this->paymentRepository->findOneBy(['id' => $paymentId]);

        if (null === $payment) {
            throw new NotFoundHttpException('Payment not found.');
        }

        $hash = null !== $payment ? $payment->getDetails()[Comgate::HASH_KEY_NAME] : '';
        /** @var PaymentSecurityTokenInterface $token */
        $token = $this->payum->getTokenStorage()->find($hash);
        if (null === $token) {
            throw new NotFoundHttpException(sprintf(
                'A token with hash "%s" not found. The token could be invalidated.',
                $hash
            ));
        }

        $gateway = $this->payum->getGateway($token->getGatewayName());
        $gateway->execute(new GetHumanStatus($token));

        return new Response(\GuzzleHttp\json_encode(ComgateInterface::RESPONSE_OK));
    }

    /**
     * Process request from gateway.
     */
    public function redirectAction(Request $request): Response
    {
        if (null === $paymentId = $request->get('refId', null)) {
            throw new LogicException('A parameter refId not be found.');
        }

        /** @var PaymentInterface|null $payment */
        $payment = $this->paymentRepository->findOneBy(['id' => $paymentId]);

        if (null === $payment) {
            throw new NotFoundHttpException('Payment not found.');
        }

        $hash = null !== $payment ? $payment->getDetails()[Comgate::HASH_KEY_NAME] : '';
        /** @var PaymentSecurityTokenInterface $token */
        $token = $this->payum->getTokenStorage()->find($hash);
        if (null === $token) {
            throw new NotFoundHttpException(sprintf(
                'A token with hash "%s" not found. The token could be invalidated.',
                $hash
            ));
        }

        $gateway = $this->payum->getGateway($token->getGatewayName());
        $gateway->execute(new GetHumanStatus($token));

        throw new HttpPostRedirect($token->getAfterUrl());
    }
}
