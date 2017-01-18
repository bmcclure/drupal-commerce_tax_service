<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

/**
 * Provides a 'Simple (Order item)' tax service.
 *
 * @CommerceTaxService(
 *   id = "commerce_tax_service_simple_order_item",
 *   label = @Translation("Simple (Order item)"),
 *   target_entity_type = "commerce_order_item",
 * )
 */
class SimpleOrderItem extends SimpleBase {

  /**
   * {@inheritdoc}
   */
  public function execute() {
    /** @var \Drupal\commerce_order\Entity\OrderItemInterface $orderItem */
    $orderItem = $this->getTargetEntity();

    $adjustment_amount = $orderItem->getTotalPrice()->multiply($this->getAmount());
    $adjustment_amount = $this->rounder->round($adjustment_amount);

    $this->applyAdjustment($orderItem, $adjustment_amount);
  }
}
