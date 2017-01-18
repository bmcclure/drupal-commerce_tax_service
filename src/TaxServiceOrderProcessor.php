<?php

namespace Drupal\commerce_tax_service;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderTypeInterface;
use Drupal\commerce_order\OrderProcessorInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Applies tax services to orders during the order refresh process.
 */
class TaxServiceOrderProcessor implements OrderProcessorInterface {

  /**
   * The tax service storage.
   *
   * @var \Drupal\commerce_tax_service\TaxServiceStorageInterface
   */
  protected $taxServiceStorage;

  /**
   * The order type storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $orderTypeStorage;

  /**
   * Constructs a new TaxServiceOrderProcessor object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->taxServiceStorage = $entity_type_manager->getStorage('commerce_tax_service');
    $this->orderTypeStorage = $entity_type_manager->getStorage('commerce_order_type');
  }

  /**
   * {@inheritdoc}
   */
  public function process(OrderInterface $order) {
    /** @var OrderTypeInterface $order_type */
    $order_type = $this->orderTypeStorage->load($order->bundle());

    $taxServices = $this->taxServiceStorage->loadValid($order_type, $order->getStore());

    foreach ($taxServices as $taxService) {
      if ($taxService->applies($order)) {
        $taxService->apply($order);
      }
    }
  }
}
