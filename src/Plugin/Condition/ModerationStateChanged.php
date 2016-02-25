<?php

namespace Drupal\gravypower_contrib\Plugin\Condition;

use Drupal\rules\Core\RulesConditionBase;

/**
 * Provides a 'Data comparison' condition.
 *
 * @Condition(
 *   id = "moderation_state_changed",
 *   label = @Translation("Moderation State Changed"),
 *   category = @Translation("Workbench Moderation"),
 *   context = {
 *     "operator" = @ContextDefinition("string",
 *       label = @Translation("Operator"),
 *       description = @Translation("The comparison operator."),
 *       default_value = "==",
 *       required = FALSE
 *     ),
 *     "value" = @ContextDefinition("any",
 *        label = @Translation("Data value"),
 *        description = @Translation("The Moderation State to compare with.")
 *     )
 *   }
 * )
 *
 */
class ModerationStateChanged extends RulesConditionBase {

    protected function doEvaluate($operator, $value)
    {

        $t = true;
    }
}