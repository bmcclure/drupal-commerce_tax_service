<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxServiceCondition;

use Drupal\Core\Condition\ConditionPluginBase;

/**
 * Base class for Tax Service Condition plugins.
 */
abstract class TaxServiceConditionBase extends ConditionPluginBase implements TaxServiceConditionInterface {

  /**
   * {@inheritdoc}
   */
  public function getTargetEntityType() {
    return $this->pluginDefinition['target_entity_type'];
  }

  /**
   * {@inheritdoc}
   */
  public function getTargetEntity() {
    return $this->getContextValue($this->getTargetEntityType());
  }

  /**
   * {@inheritdoc}
   */
  public function execute() {
    $result = $this->evaluate();
    return $this->isNegated() ? !$result : $result;
  }
}
