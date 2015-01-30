<?php

namespace Pragmatist\Regel\ExpressionLanguageEvaluator;

use Pragmatist\Regel\Condition\Condition;
use Pragmatist\Regel\Condition\ConditionEvaluator;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

final class ExpressionLanguageConditionEvaluator implements ConditionEvaluator
{
    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * @var boolean
     */
    private $evaluateSyntaxErrorsToFalse;

    /**
     * @param ExpressionLanguage $expressionLanguage
     * @param bool $evaluateSyntaxErrorsToFalse
     */
    public function __construct(ExpressionLanguage $expressionLanguage, $evaluateSyntaxErrorsToFalse = true)
    {
        $this->expressionLanguage = $expressionLanguage;
        $this->evaluateSyntaxErrorsToFalse = (bool) $evaluateSyntaxErrorsToFalse;
    }

    /**
     * @param Condition $condition
     * @param mixed $subject
     * @return bool
     */
    public function evaluate(Condition $condition, $subject)
    {
        try {
            /** @var ExpressionLanguageCondition $condition */
            return (bool) $this->expressionLanguage->evaluate(
                $condition->expression(),
                ['subject' => $subject]
            );
        } catch (SyntaxError $syntaxError) {
            if ($this->evaluateSyntaxErrorsToFalse) {
                return false;
            }
            throw $syntaxError;
        }
    }
}
