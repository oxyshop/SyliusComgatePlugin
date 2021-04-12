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

use Contributte\Comgate\Entity\Codes\PaymentStatusCode;
use Contributte\Comgate\Entity\PaymentStatus;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Api\Comgate;
use Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Exception\PaymentStatusException;
use Payum\Core\Request\GetStatusInterface;
use Sylius\Component\Payment\Model\PaymentInterface;

final class StatusAction extends AbstractAction
{
    /**
     * @param GetStatusInterface $request
     *
     * @throws PaymentStatusException
     */
    public function execute($request): void
    {
        /** @var PaymentInterface $payment */
        $payment = $request->getFirstModel();
        $transId = $payment->getDetails()[Comgate::TRANSACTION_ID_KEY_NAME];

        $response = $this->api->getGateway()->status(PaymentStatus::of($transId));
        if (false === $response->isOk()) {
            $request->markFailed();

            throw new PaymentStatusException($response);
        }

        switch ($response->getData()['status']) {
            case PaymentStatusCode::PENDING:
                $request->markPending();

                break;
            case PaymentStatusCode::AUTHORIZED:
                $request->markAuthorized();

                break;
            case PaymentStatusCode::CANCELLED:
                $request->markCanceled();

                break;
            case PaymentStatusCode::PAID:
                $request->markCaptured();

                break;
            default:
                $request->markUnknown();

                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports($request): bool
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof PaymentInterface
        ;
    }
}
