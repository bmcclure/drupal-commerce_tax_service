<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

/**
 * Provides a 'Simple (Order)' tax service.
 *
 * @CommerceTaxService(
 *   id = "commerce_tax_service_simple_order",
 *   label = @Translation("Simple (Order)"),
 *   target_entity_type = "commerce_order",
 * )
 */
class SimpleOrder extends SimpleBase {

  /**
   * {@inheritdoc}
   */
  public function execute() {
    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $this->getTargetEntity();

    $adjustment_amount = $order->getTotalPrice()->multiply($this->getAmount());
    $adjustment_amount = $this->rounder->round($adjustment_amount);

    $this->applyAdjustment($order, $adjustment_amount);
  }

}
