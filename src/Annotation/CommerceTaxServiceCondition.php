<?php

namespace Drupal\commerce_tax_service\Annotation;

use Drupal\Core\Condition\Annotation\Condition;

/**
 * Defines the tax service condition plugin annotation object.
 *
 * Plugin namespace: Plugin\Commerce\TaxServiceCondition.
 *
 * @Annotation
 */
class CommerceTaxServiceCondition extends Condition {

  /**
   * The target entity type this action applies to.
   *
   * For example, this should be 'commerce_order' or 'commerce_order_item'.
   *
   * @var string
   */
  public $target_entity_type;

}
