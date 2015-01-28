<?php

namespace Pragmatist\Regel\ExpressionLanguageEvaluator\Tests;

use Mockery as m;
use Pragmatist\Regel\ExpressionLanguageEvaluator\ExpressionLanguageCondition;
use Pragmatist\Regel\ExpressionLanguageEvaluator\ExpressionLanguageConditionEvaluator;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\ExpressionLanguage\SyntaxError;

final class ExpressionLanguageConditionEvaluatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $expressionLanguage;

    /**
     * @var ExpressionLanguageConditionEvaluator
     */
    private $evaluator;

    public function setUp()
    {
        $this->expressionLanguage = m::mock(ExpressionLanguage::class);
        $this->evaluator = new ExpressionLanguageConditionEvaluator(
            $this->expressionLanguage
        );
    }

    /**
     * @test
     */
    public function itShouldEvaluateACondition()
    {
        $this->expressionLanguage->shouldReceive('evaluate')
            ->with('true', ['subject' => 'my subject'])
            ->andReturn(true);

        $this->assertTrue(
            $this->evaluator->evaluate(
                new ExpressionLanguageCondition('true'),
                'my subject'
            )
        );
    }

    /**
     * @test
     */
    public function itShouldEvaluateSyntaxErrorsToFalse()
    {
        $this->expressionLanguage->shouldReceive('evaluate')
            ->with('very invalid expression', ['subject' => 'my subject'])
            ->andThrow(SyntaxError::class);

        $this->assertFalse(
            $this->evaluator->evaluate(
                new ExpressionLanguageCondition('very invalid expression'),
                'my subject'
            )
        );
    }

    /**
     * @test
     */
    public function itShouldReThrowSyntaxErrorsIfNotEvaluatingSyntaxErrorsToFalse()
    {
        $this->evaluator = new ExpressionLanguageConditionEvaluator(
            $this->expressionLanguage,
            false
        );

        $this->expressionLanguage->shouldReceive('evaluate')
            ->with('very invalid expression', ['subject' => 'my subject'])
            ->andThrow(SyntaxError::class);

        $this->setExpectedException(SyntaxError::class);
        $this->evaluator->evaluate(
            new ExpressionLanguageCondition('very invalid expression'),
            'my subject'
        );
    }
}
