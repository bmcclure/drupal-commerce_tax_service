<?php

namespace Drupal\commerce_tax_service;

use Drupal\commerce_order\Entity\OrderTypeInterface;
use Drupal\commerce_store\Entity\StoreInterface;
use Drupal\Core\Entity\ContentEntityStorageInterface;

/**
 * Defines the interface for tax service storage.
 */
interface TaxServiceStorageInterface extends ContentEntityStorageInterface {

  /**
   * Loads the valid tax service for the given order type and store.
   *
   * @param \Drupal\commerce_order\Entity\OrderTypeInterface $order_type
   *   The order type.
   * @param \Drupal\commerce_store\Entity\StoreInterface $store
   *   The store.
   *
   * @return \Drupal\commerce_tax_service\Entity\TaxServiceInterface[]
   *   The valid tax services.
   */
  public function loadValid(OrderTypeInterface $order_type, StoreInterface $store);
}
