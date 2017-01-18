<?php

namespace Drupal\commerce_tax_service\Entity;

use Drupal\commerce_store\Entity\EntityStoresInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Defines the interface for tax services.
 */
interface TaxServiceInterface extends EntityInterface, EntityStoresInterface {

  /**
   * Gets the tax service name.
   *
   * @return string
   *   The tax service name.
   */
  public function getName();

  /**
   * Sets the tax service name.
   *
   * @param string $name
   *   The tax service name.
   *
   * @return $this
   */
  public function setName($name);

  /**
   * Gets the tax service order types.
   *
   * @return \Drupal\commerce_order\Entity\OrderTypeInterface[]
   *   The tax service order types.
   */
  public function getOrderTypes();

  /**
   * Sets the tax service order types.
   *
   * @param \Drupal\commerce_order\Entity\OrderTypeInterface[] $order_types
   *   The tax service order types.
   *
   * @return $this
   */
  public function setOrderTypes(array $order_types);

  /**
   * Gets the tax service order type IDs.
   *
   * @return int[]
   *   The tax service order type IDs.
   */
  public function getOrderTypeIds();

  /**
   * Sets the tax service order type IDs.
   *
   * @param int[] $order_type_ids
   *   The tax service order type IDs.
   *
   * @return $this
   */
  public function setOrderTypeIds(array $order_type_ids);

  /**
   * Get whether the tax service is enabled.
   *
   * @return bool
   *   TRUE if the tax service is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets whether the tax service is enabled.
   *
   * @param bool $enabled
   *   Whether the tax service is enabled.
   *
   * @return $this
   */
  public function setEnabled($enabled);

  /**
   * Checks whether the tax service entity can be applied.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity.
   *
   * @return bool
   *   TRUE if tax service can be applied, or false if conditions failed.
   */
  public function applies(EntityInterface $entity);

  /**
   * Apply the tax service to an entity.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity.
   */
  public function apply(EntityInterface $entity);
}
