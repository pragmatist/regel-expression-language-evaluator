<?php

namespace Pragmatist\Regel\ExpressionLanguageEvaluator\Tests;

use Pragmatist\Regel\ExpressionLanguageEvaluator\ExpressionLanguageCondition;
use Symfony\Component\ExpressionLanguage\Expression;

final class ExpressionLanguageConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateWithStrings()
    {
        $this->assertEquals(
            'my expression',
            (new ExpressionLanguageCondition('my expression'))->getExpression()
        );
    }

    /**
     * @test
     */
    public function itShouldInstantiateWithExpression()
    {
        $expression = new Expression('my expression');

        $this->assertEquals(
            $expression,
            (new ExpressionLanguageCondition($expression))->getExpression()
        );
    }

    /**
     * @test
     */
    public function itShouldThrowAnExceptionWhenInstantiatedWithInvalidExpression()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        (new ExpressionLanguageCondition(true));
    }
}
