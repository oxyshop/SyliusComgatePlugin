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

use Brick\Money\Money;
use Contributte\Comgate\Entity\Codes\CountryCode;
use Contributte\Comgate\Entity\Codes\LangCode;
use Contributte\Comgate\Entity\Payment;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\Comgate;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Exception\ComgateException;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Exception\PaymentCreateException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Reply\HttpPostRedirect;
use Payum\Core\Request\Capture;
use Sylius\Component\Core\Model\PaymentInterface;

final class CaptureAction extends AbstractAction
{
    /**
     * @param Capture $request
     *
     * @throws ComgateException
     * @throws PaymentCreateException
     */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);
        /** @var PaymentInterface $model */
        $model = $request->getModel();
        if ( ! $model instanceof PaymentInterface) {
            throw new ComgateException(sprintf(
                'Not supported. Expected %s instance to be set as api.',
                PaymentInterface::class
            ));
        }

        // Create a new payment
        $payment = Payment::of(
            Money::of($model->getAmount() / 100, $model->getCurrencyCode()), // @todo Validate minimum order price
            sprintf('Comgate order \'%s\'', $model->getId()),
            (string) $model->getId(),
            $this->api->getEmail(), // @todo This should be rather an email of the customer
            $this->api->getMethod(),
            explode('_', $model->getOrder()->getLocaleCode())[1] ?? CountryCode::ALL,
            explode('_', $model->getOrder()->getLocaleCode())[0] ?? LangCode::CS,
        );

        // @todo Set more parameters for better payment identification

        // Create new payment on gateway
        $response = $this->api->getGateway()->create($payment);
        if (false === $response->isOk()) {
            throw new PaymentCreateException($response);
        }

        $responseData = $response->getData();
        $token = $request->getToken();

        // Update transaction with Comgate ID and some additional debugging information
        $model->setDetails([
            Comgate::HASH_KEY_NAME => $token->getHash(),
            Comgate::TRANSACTION_ID_KEY_NAME => $responseData['transId'],
            // @todo Remove it sometime in the future when it turns out to be unnecessary
            'afterUrl' => $token->getAfterUrl(),
            'targetUrl' => $token->getTargetUrl(),
            'gatewayName' => $token->getGatewayName(),
        ]);
        $request->setModel($model);

        throw new HttpPostRedirect($responseData['redirect']);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request): bool
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof PaymentInterface
        ;
    }
}
