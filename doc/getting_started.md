---
currentMenu: getting_started
---

# Getting started

## Installation

Using [Composer](https://getcomposer.org/):

```bash
composer require pragmatist/regel-expression-language-evaluator
```

## Defining your conditions

You can add an Expression Language condition to a rule just like you normally would.

```php
use Pragmatist\Regel\Action\CallableAction;
use Pragmatist\Regel\ExpressionLanguageEvaluator\ExpressionLanguageCondition;
use Pragmatist\Regel\Rule\ActionableRule;

$rule = new ActionableRule(
    new ExpressionLanguageCondition("subject.body matches '/important/i'"),
    new CallableAction(
        function ($subject) {
            echo "E-mail '{$subject->subject}' is important!'\n";
        }
    )
)
```

## Using the condition evaluator

Just inject the Expression Language condition evaluator into the rule engine, and you're done.

```php
use Pragmatist\Regel\Action\CallableActionExecutor;
use Pragmatist\Regel\Engine\ActionEngine;
use Pragmatist\Regel\ExpressionLanguageEvaluator\ExpressionLanguageConditionEvaluator;
use Pragmatist\Regel\RuleSetProvider\InMemoryRuleSetProvider;

$engine = new ActionEngine(
    new InMemoryRuleSetProvider(),
    new ExpressionLanguageConditionEvaluator(),
    new CallableActionExecutor()
);
```
