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

namespace Tests\Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Tests\Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Behat\Page\Admin\PaymentMethod\CreatePageInterface;
use Tests\Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Behat\Page\Admin\PaymentMethod\UpdatePageInterface;

final class ManagingPaymentMethodsContext implements Context
{
    /** @var CreatePageInterface */
    private $createPage;

    /** @var UpdatePageInterface */
    private $updatePage;

    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    public function __construct(CreatePageInterface $createPage, UpdatePageInterface $updatePage, CurrentPageResolverInterface $currentPageResolver)
    {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->currentPageResolver = $currentPageResolver;
    }

    /**
     * @When I configure it with test comgate credentials
     */
    public function iConfigureItWithTestComgateCredentials(): void
    {
        /** @var CreatePageInterface|UpdatePageInterface $currentPage */
        $currentPage = $this->currentPageResolver->getCurrentPageWithForm([$this->createPage, $this->updatePage]);

        $currentPage->setComgateGatewayMerchant('139177');
        $currentPage->setComgateGatewaySecretKey('d1e5379eb28c8265331e8bc63a3cf54c');
        $currentPage->setComgateGatewayEmail('teamng@oxyshop.cz');
        $currentPage->setComgateGatewayPaymentMethod('ALL');
        $currentPage->setComgateGatewayTest(true);
    }
}
