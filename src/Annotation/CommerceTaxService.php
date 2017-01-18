<?php

namespace Drupal\commerce_tax_service\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines the tax service plugin annotation object.
 *
 * Plugin namespace: Plugin\Commerce\TaxService.
 *
 * @see plugin_api
 *
 * @Annotation
 */
class CommerceTaxService extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The tax service label.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

  /**
   * An array of context definitions describing the context used by the plugin.
   *
   * The array is keyed by context names.
   *
   * @var \Drupal\Core\Annotation\ContextDefinition[]
   */
  public $context = [];

  /**
   * The target entity type this action applies to.
   *
   * For example, this should be 'commerce_order' or 'commerce_order_item'.
   *
   * @var string
   */
  public $target_entity_type;
}
