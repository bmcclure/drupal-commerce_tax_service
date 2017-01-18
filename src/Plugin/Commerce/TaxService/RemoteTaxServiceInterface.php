<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

interface RemoteTaxServiceInterface extends TaxServiceInterface {
  public function getMode();
}
