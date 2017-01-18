<?php

namespace Drupal\commerce_tax_service\Event;

use Drupal\commerce_tax_service\Entity\TaxServiceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the tax service event.
 *
 * @see \Drupal\commerce_tax_service\Event\TaxServiceEvents
 */
class TaxServiceEvent extends Event {

  /**
   * The tax service.
   *
   * @var \Drupal\commerce_tax_service\Entity\TaxServiceInterface
   */
  protected $taxService;

  /**
   * Constructs a new TaxServiceEvent.
   *
   * @param \Drupal\commerce_tax_service\Entity\TaxServiceInterface $taxService
   *   The tax service.
   */
  public function __construct(TaxServiceInterface $taxService) {
    $this->taxService = $taxService;
  }

  /**
   * Gets the tax service.
   *
   * @return \Drupal\commerce_tax_service\Entity\TaxServiceInterface
   *   The tax service.
   */
  public function getTaxService() {
    return $this->taxService;
  }

}
