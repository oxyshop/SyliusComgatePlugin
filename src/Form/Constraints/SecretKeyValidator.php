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

class SecretKeyValidator extends ConstraintValidator
{
    /** @var int */
    private const CHAR_LENGTH_LIMIT = 32;

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        // Validate only if you get some data. Combine with NotBlank() class if your field is required.
        if (empty($value)) {
            return;
        }

        $pattern = \sprintf('/^[a-zA-Z0-9]{%d}$/', self::CHAR_LENGTH_LIMIT);
        \preg_match($pattern, $value, $matches);
        if (1 !== count($matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ length }}', self::CHAR_LENGTH_LIMIT)
                ->addViolation();
        }
    }
}
