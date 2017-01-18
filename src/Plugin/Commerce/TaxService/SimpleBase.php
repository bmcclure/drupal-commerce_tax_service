<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

use Drupal\Core\Form\FormStateInterface;

abstract class SimpleBase extends TaxServiceBase {
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
        'amount' => 0,
      ] + parent::defaultConfiguration();
  }

  /**
   * Gets the percentage amount, as a decimal.
   *
   * @return string
   *   The amount.
   */
  public function getAmount() {
    return (string) $this->configuration['amount'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form += parent::buildConfigurationForm($form, $form_state);

    $form['amount'] = [
      '#type' => 'commerce_number',
      '#title' => $this->t('Percentage'),
      '#default_value' => $this->configuration['amount'] * 100,
      '#maxlength' => 255,
      '#required' => TRUE,
      '#min' => 0,
      '#max' => 100,
      '#size' => 4,
      '#field_suffix' => t('%'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    if (empty($values['target_plugin_configuration']['amount'])) {
      $form_state->setError($form, $this->t('Percentage amount cannot be empty.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    $this->configuration['amount'] = (string) ($values['amount'] / 100);

    parent::submitConfigurationForm($form, $form_state);
  }
}
