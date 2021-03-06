<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

use Drupal\commerce_order\EntityAdjustableInterface;
use Drupal\commerce_price\Price;
use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Core\Executable\ExecutableInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\ContextAwarePluginInterface;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Defines an interface for Offer plugins.
 */
interface TaxServiceInterface extends ConfigurablePluginInterface, ContainerFactoryPluginInterface, ContextAwarePluginInterface, ExecutableInterface, PluginFormInterface {

  const ORDER = 'commerce_order';
  const ORDER_ITEM = 'commerce_order_item';

  /**
   * Gets the entity type the tax service is for.
   *
   * @return string
   *   The entity type it applies to.
   */
  public function getTargetEntityType();

  /**
   * Get the target entity for the tax service.
   *
   * @return \Drupal\Core\Entity\EntityInterface
   *   The target entity.
   */
  public function getTargetEntity();

  /**
   * Get the display name for the tax service line item.
   *
   * @return string
   *   The display name.
   */
  public function getDisplayName();

  /**
   * Applies the tax service's adjustment to an item.
   *
   * @param \Drupal\commerce_order\EntityAdjustableInterface $entity
   *   The adjustable entity.
   * @param \Drupal\commerce_price\Price $amount
   *   The price object.
   *
   * @return \Drupal\commerce_order\Adjustment
   *   The adjustment.
   */
  public function applyAdjustment(EntityAdjustableInterface $entity, Price $amount);
}
