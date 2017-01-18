<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxServiceCondition;

use Drupal\address\Plugin\Field\FieldType\AddressItem;
use Drupal\address\Repository\SubdivisionRepository;
use Drupal\commerce_tax_service\Annotation\CommerceTaxServiceCondition;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an 'Order: Billing state' condition.
 *
 * @CommerceTaxServiceCondition(
 *   id = "commerce_tax_service_order_billing_state",
 *   label = @Translation("Billing state"),
 *   target_entity_type = "commerce_order",
 * )
 */
class BillingState extends TaxServiceConditionBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
        'states' => [],
      ] + parent::defaultConfiguration();
  }

  protected function getStateOptions() {
    /** @var SubdivisionRepository $subdivisionRepository */
    $subdivisionRepository = \Drupal::service('address.subdivision_repository');

    $list = $subdivisionRepository->getList([]);

    dpm($list);

    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form += parent::buildConfigurationForm($form, $form_state);

    $form['states'] = [
      '#type' => 'select',
      '#title' => $this->t('States'),
      '#description' => $this->t('Select the state(s) you wish this tax service to apply to.'),
      '#multiple' => TRUE,
      '#options' => $this->getStateOptions(),
      '#default_value' => $this->configuration['states'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    $states = $this->configuration['states'];

    if (empty($states)) {
      return FALSE;
    }


    /** @var \Drupal\commerce_order\Entity\OrderInterface $order */
    $order = $this->getTargetEntity();

    if (!$order->getBillingProfile()->hasField('address') || $order->getBillingProfile()->get('address')->isEmpty()) {
      return FALSE;
    }

    /** @var AddressItem $address */
    $address = $order->getBillingProfile()->get('address')->first();

    $state = $address->getAdministrativeArea();

    dpm($state);

    return in_array($state, $states);
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t('Compares the order billing state.');
  }
}
