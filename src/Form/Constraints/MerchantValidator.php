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

namespace Oxyshop\Nextgen\Plugin\SyliusComgatePlugin\Form\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MerchantValidator extends ConstraintValidator
{
    /** @var int */
    private const CHAR_LENGTH_LIMIT = 6;

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        // Validate only if you get some data. Combine with NotBlank() class if your field is required.
        if (empty($value)) {
            return;
        }

        $pattern = \sprintf('/\d{%d}/', self::CHAR_LENGTH_LIMIT);
        if ( ! \preg_match($pattern, $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ length }}', self::CHAR_LENGTH_LIMIT)
                ->addViolation();
        }
    }
}
