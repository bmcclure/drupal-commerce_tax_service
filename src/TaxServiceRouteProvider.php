<?php

namespace Drupal\commerce_tax_service;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\AdminHtmlRouteProvider;

/**
 * Provides routes for the Tax Service entity.
 */
class TaxServiceRouteProvider extends AdminHtmlRouteProvider {

  /**
   * {@inheritdoc}
   */
  protected function getCanonicalRoute(EntityTypeInterface $entity_type) {
    // Tax services use the edit-form route as the canonical route.
    // @todo Remove this when #2479377 gets fixed.
    return $this->getEditFormRoute($entity_type);
  }

}
