<?php

namespace Pragmatist\Regel\ExpressionLanguageEvaluator;

use Pragmatist\Regel\Condition\Condition;
use Symfony\Component\ExpressionLanguage\Expression;

final class ExpressionLanguageCondition implements Condition
{
    /**
     * @var Expression|string
     */
    private $expression;

    /**
     * @param Expression|string $expression
     */
    public function __construct($expression)
    {
        if (!is_string($expression) && !$expression instanceof Expression) {
            throw new \InvalidArgumentException(
                'Expression must be a string or an instance of ' . Expression::class
            );
        }

        $this->expression = $expression;
    }

    /**
     * @return string|Expression
     */
    public function getExpression()
    {
        return $this->expression;
    }
}
