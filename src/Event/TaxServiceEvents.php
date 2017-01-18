<?php

namespace Drupal\commerce_tax_service\Event;

final class TaxServiceEvents {

  /**
   * Name of the event fired after loading a tax service.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_LOAD = 'commerce_tax_service.commerce_tax_service.load';

  /**
   * Name of the event fired after creating a new tax service.
   *
   * Fired before the tax service is saved.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_CREATE = 'commerce_tax_service.commerce_tax_service.create';

  /**
   * Name of the event fired before saving a tax service.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_PRESAVE = 'commerce_tax_service.commerce_tax_service.presave';

  /**
   * Name of the event fired after saving a new tax service.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_INSERT = 'commerce_tax_service.commerce_tax_service.insert';

  /**
   * Name of the event fired after saving an existing tax service.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_UPDATE = 'commerce_tax_service.commerce_tax_service.update';

  /**
   * Name of the event fired before deleting a tax service.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_PREDELETE = 'commerce_tax_service.commerce_tax_service.predelete';

  /**
   * Name of the event fired after deleting a tax service.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_DELETE = 'commerce_tax_service.commerce_tax_service.delete';

  /**
   * Name of the event fired after saving a new tax service translation.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_TRANSLATION_INSERT = 'commerce_tax_service.commerce_tax_service.translation_insert';

  /**
   * Name of the event fired after deleting a tax service translation.
   *
   * @Event
   *
   * @see \Drupal\commerce_tax_service\Event\TaxServiceEvent
   */
  const TAX_SERVICE_TRANSLATION_DELETE = 'commerce_tax_service.commerce_tax_service.translation_delete';

}
