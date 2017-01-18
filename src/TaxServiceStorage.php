<?php

namespace Drupal\commerce_tax_service;

use Drupal\commerce\CommerceContentEntityStorage;
use Drupal\commerce_order\Entity\OrderTypeInterface;
use Drupal\commerce_store\Entity\StoreInterface;

/**
 * Defines the tax service storage.
 */
class TaxServiceStorage extends CommerceContentEntityStorage implements TaxServiceStorageInterface {

  /**
   * Helper method to return base query for valid tax services.
   *
   * @param \Drupal\commerce_order\Entity\OrderTypeInterface $order_type
   *   The order type.
   * @param \Drupal\commerce_store\Entity\StoreInterface $store
   *   The store.
   *
   * @return \Drupal\Core\Entity\Query\QueryInterface
   *   The entity query.
   */
  protected function loadValidQuery(OrderTypeInterface $order_type, StoreInterface $store) {
    return $this->getQuery()
      ->condition('stores', [$store->id()], 'IN')
      ->condition('order_types', [$order_type->id()], 'IN')
      ->condition('status', TRUE);
  }

  /**
   * {@inheritdoc}
   */
  public function loadValid(OrderTypeInterface $order_type, StoreInterface $store) {
    $query = $this->loadValidQuery($order_type, $store);
    $result = $query->execute();

    if (empty($result)) {
      return [];
    }

    $taxServices = $this->loadMultiple($result);

    return $taxServices;
  }
}
