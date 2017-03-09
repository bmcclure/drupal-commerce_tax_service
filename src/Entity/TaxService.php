<?php

namespace Drupal\commerce_tax_service\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;

/**
 * Defines the tax service entity class.
 *
 * @ContentEntityType(
 *   id = "commerce_tax_service",
 *   label = @Translation("Tax service"),
 *   label_singular = @Translation("tax service"),
 *   label_plural = @Translation("tax services"),
 *   label_count = @PluralTranslation(
 *     singular = "@count tax service",
 *     plural = "@count tax services",
 *   ),
 *   handlers = {
 *     "event" = "Drupal\commerce_tax_service\Event\TaxServiceEvent",
 *     "storage" = "Drupal\commerce_tax_service\TaxServiceStorage",
 *     "access" = "Drupal\commerce\EntityAccessControlHandler",
 *     "permission_provider" = "Drupal\commerce\EntityPermissionProvider",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\commerce_tax_service\TaxServiceListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\commerce_tax_service\Form\TaxServiceForm",
 *       "add" = "Drupal\commerce_tax_service\Form\TaxServiceForm",
 *       "edit" = "Drupal\commerce_tax_service\Form\TaxServiceForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "default" = "Drupal\commerce_tax_service\TaxServiceRouteProvider",
 *       "delete-multiple" = "Drupal\entity\Routing\DeleteMultipleRouteProvider",
 *     },
 *     "translation" = "Drupal\content_translation\ContentTranslationHandler"
 *   },
 *   base_table = "commerce_tax_service",
 *   data_table = "commerce_tax_service_field_data",
 *   admin_permission = "administer commerce_tax_service",
 *   fieldable = TRUE,
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "tax_service_id",
 *     "label" = "name",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid",
 *     "status" = "status",
 *   },
 *   links = {
 *     "add-form" = "/tax-service/add",
 *     "canonical" = "/tax-service/{commerce_tax_service}/edit",
 *     "edit-form" = "/tax-service/{commerce_tax_service}/edit",
 *     "delete-form" = "/tax-service/{commerce_tax_service}/delete",
 *     "delete-multiple-form" = "/admin/commerce/tax-services/delete",
 *     "collection" = "/admin/commerce/tax-services",
 *   },
 * )
 */
class TaxService extends ContentEntityBase implements TaxServiceInterface {

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOrderTypes() {
    return $this->get('order_types')->referencedEntities();
  }

  /**
   * {@inheritdoc}
   */
  public function setOrderTypes(array $order_types) {
    $this->set('order_types', $order_types);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOrderTypeIds() {
    $order_type_ids = [];
    foreach ($this->get('order_types') as $field_item) {
      $order_type_ids[] = $field_item->target_id;
    }
    return $order_type_ids;
  }

  /**
   * {@inheritdoc}
   */
  public function setOrderTypeIds(array $order_type_ids) {
    $this->set('order_types', $order_type_ids);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStores() {
    return $this->get('stores')->referencedEntities();
  }

  /**
   * {@inheritdoc}
   */
  public function setStores(array $stores) {
    $this->set('stores', $stores);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStoreIds() {
    $store_ids = [];
    foreach ($this->get('stores') as $field_item) {
      $store_ids[] = $field_item->target_id;
    }
    return $store_ids;
  }

  /**
   * {@inheritdoc}
   */
  public function setStoreIds(array $store_ids) {
    $this->set('stores', $store_ids);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setEnabled($enabled) {
    $this->set('status', (bool) $enabled);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function applies(EntityInterface $entity) {
    $entity_type_id = $entity->getEntityTypeId();

    /** @var \Drupal\commerce_tax_service\Plugin\Commerce\TaxService\TaxServiceInterface $taxService */
    $taxService = $this->get('tax_service')->first()->getTargetInstance();
    if ($taxService->getTargetEntityType() !== $entity_type_id) {
      return FALSE;
    }

    // @todo should whatever invokes this method be providing the context?
    $context = new Context(new ContextDefinition('entity:' . $entity_type_id), $entity);

    // Execute each plugin, this is an AND operation.
    // @todo support OR operations.
    /** @var \Drupal\commerce\Plugin\Field\FieldType\PluginItem $item */
    foreach ($this->get('conditions') as $item) {
      /** @var \Drupal\commerce_tax_service\Plugin\Commerce\TaxServiceCondition\TaxServiceConditionInterface $condition */
      $condition = $item->getTargetInstance([$entity_type_id => $context]);
      if (!$condition->evaluate()) {
        return FALSE;
      }
    }

    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function apply(EntityInterface $entity) {
    $entity_type_id = $entity->getEntityTypeId();
    // @todo should whatever invokes this method be providing the context?
    $context = new Context(new ContextDefinition('entity:' . $entity_type_id), $entity);

    /** @var \Drupal\commerce_tax_service\Plugin\Commerce\TaxService\TaxServiceInterface $taxService */
    $taxService = $this->get('tax_service')->first()->getTargetInstance([$entity_type_id => $context]);
    $taxService->execute();
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The tax service name.'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setSettings([
        'default_value' => '',
        'max_length' => 255,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayConfigurable('form', TRUE);

    $fields['order_types'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Order types'))
      ->setDescription(t('The order types for which the tax service is valid.'))
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setRequired(TRUE)
      ->setSetting('target_type', 'commerce_order_type')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_select',
        'weight' => 2,
      ]);

    $fields['stores'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Stores'))
      ->setDescription(t('The stores for which the tax service is valid.'))
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setRequired(TRUE)
      ->setSetting('target_type', 'commerce_store')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_select',
        'weight' => 2,
      ]);

    $fields['tax_service'] = BaseFieldDefinition::create('commerce_plugin_item:commerce_tax_service')
      ->setLabel(t('Tax service'))
      ->setCardinality(1)
      ->setRequired(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'commerce_plugin_select',
        'weight' => 3,
      ]);

    $fields['conditions'] = BaseFieldDefinition::create('commerce_plugin_item:commerce_tax_service_condition')
      ->setLabel(t('Conditions'))
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setRequired(FALSE)
      ->setDisplayOptions('form', [
        'type' => 'commerce_plugin_select',
        'weight' => 3,
      ]);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Enabled'))
      ->setDescription(t('Whether the tax service is enabled.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => TRUE,
        ],
        'weight' => 20,
      ]);

    return $fields;
  }
}
