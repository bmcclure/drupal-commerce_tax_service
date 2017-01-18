<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxServiceCondition;

use Drupal\Core\Condition\ConditionInterface;

/**
 * Defines an interface for Condition plugins.
 */
interface TaxServiceConditionInterface extends ConditionInterface {

  /**
   * Gets the entity type the condition is for.
   *
   * @return string
   *   The entity type it applies to.
   */
  public function getTargetEntityType();

  /**
   * Get the target entity for the offer.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The target entity.
   */
  public function getTargetEntity();

}
