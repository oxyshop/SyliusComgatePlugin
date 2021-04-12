# Oxyshop Sylius Comgate Plugin
**[WIP]** This plugin allows you to integrate Comgate payment with Sylius.

## Content
- [Installation](#installation)
- [Eshop configuration](#eshop-configuration)
- [Gateway configuration](#gateway-configuration)
- [Limitations](#limitations) :warning:
- [Testing](#testing)
  - [Test, stage & production environment](#test-stage--production-environment)
  - [Local development](#local-development)
- [Development](#development)
  - [Implemented functionality](#implemented-functionality)
  - [Magic (non-standard implementation)](#magic-non-standard-implementation)
- [Links](#links)

## Installation
The best way to install the bundle is using Composer:
```bash
$ composer require oxyshop/sylius-comgate-plugin
```

And you're done.

Other manual changes are done automatically via [Flex](https://symfony.com/doc/current/setup/flex.html). In case you don't use a Flex, you have to do following steps:

Register plugin `bundles.php`
```php
// bundles.php

return [
    // ...
    Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\OxyshopSyliusComgatePlugin::class => ['all' => true],
];
```

### Eshop configuration
1. Add new payment method **Comgate** in Sylius administration
1. Enter **Merchant ID**
1. Enter **Secret Key**
1. Select **Payment Method**
1. Enter **Email**
1. Turn on **Test** if necessary

Testing credentials can be found in [ManagingPaymentMethodsContext](./tests/Behat/Context/Ui/Admin/ManagingPaymentMethodsContext.php#L46) class.

At this moment, you can't combine more payment methods in one configuration. You have to create new Comgate configuration per method.

### Gateway configuration
Use the following settings to set up a store at [portal.comgate.cz/en/](https://portal.comgate.cz/en/):

| Name            | Value                                                           |
|----------------:|-----------------------------------------------------------------|
| Password        | \<secretKey\>                                                   |
| Connection name | \<shopCode\>                                                    |
| Method          | HTTP POST protokol - backend - RECOMMENDED                      |
| Notification    | yes/no                                                          |
| Url paid        | https://www.example.com/payment/comgate/redirect?refId=${refId} |
| Url cancelled   | https://www.example.com/payment/comgate/redirect?refId=${refId} |
| Url pending     | https://www.example.com/payment/comgate/redirect?refId=${refId} |
| Url result      | https://www.example.com/payment/comgate/notify                  |
| IP whitelist    | \<eshopIps\>*                                                   |

\*) Comgate allows requests only from whitelisted IPs.

## Limitations
- The Comgate gateway accepts payments greater than or equal to
    - 1 EUR
    - 1 GBP
    - 1 USD
    - 10 CZK
    - 10 PLN
    - 100 HUF
- List of [supported countries](https://github.com/contributte/comgate/blob/master/src/Entity/Codes/CountryCode.php)

## Testing

### Test, stage & production environment
While testing Comgate on test/stage/prod environment it's necessary to have the environment accessible from the outside.
Don't forget to whitelist your environment in Comgate administration as well to allow requests from eshop to Comgate.

### Local development
You can test the Comgate implementation locally, but the request from Comgate gateway must be simulated via [Postman](https://www.getpostman.com) or any other client.
The request you can find under the **Integration** section at [Comgate portal](https://portal.comgate.cz/en/testing-payments) by **ComGate ID**.

## Development
### Implemented functionality
- [x] Create payment
- [x] Get payment status
- [ ] Recurring payments
- [ ] Payment refund
- [ ] Payment pre-authorization
- [ ] Cancel payment pre-authorization
- [ ] Available methods
- [x] EET
- [ ] Custom EET
- [ ] Fix conversion of price into pennies
- [ ] In case of an error, the change of the payment method must be available

### Magic (non-standard implementation)
- The method `OxyshopSyliusComgatePlugin::build()` contains hack to add compiler pass only on test environments.
- The `ManagingPaymentMethodsContextPass` manually adds the Comgate factory to the `Sylius\Behat\Context\Ui\Admin\ManagingPaymentMethodsContext`.

## Links
- [Official Comgate API documentation](https://www.comgate.cz/en/api-protocol), [CZ](https://www.comgate.cz/cz/protokol-api)
- We're using API client from [Contributte/Comgate](https://github.com/contributte/comgate/)
