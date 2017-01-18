<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

interface SimpleTaxServiceInterface extends TaxServiceInterface {
  /**
   * Gets the percentage amount, as a decimal.
   *
   * @return string
   *   The amount.
   */
  public function getAmount();
}
