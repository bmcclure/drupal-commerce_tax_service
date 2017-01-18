<?php

namespace Drupal\commerce_tax_service\EventSubscriber;

use Drupal\commerce\Event\CommerceEvents;
use Drupal\commerce\Event\ReferenceablePluginTypesEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaxServiceSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = [];

    $events[CommerceEvents::REFERENCEABLE_PLUGIN_TYPES][] = ['onReferenceablePluginTypes'];

    return $events;
  }

  /**
   * Acts on ReferenceablePluginTypesEvent events.
   *
   * @param \Drupal\commerce\Event\ReferenceablePluginTypesEvent $event
   *   The event.
   */
  public function onReferenceablePluginTypes(ReferenceablePluginTypesEvent $event) {
    $pluginTypes = $event->getPluginTypes();

    $pluginTypes['commerce_tax_service'] = t('Tax service');
    $pluginTypes['commerce_tax_service_condition'] = t('Tax service condition');

    $event->setPluginTypes($pluginTypes);
  }
}
