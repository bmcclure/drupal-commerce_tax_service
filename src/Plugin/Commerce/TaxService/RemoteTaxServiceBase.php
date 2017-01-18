<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

use Drupal\Core\Form\FormStateInterface;

abstract class RemoteTaxServiceBase extends TaxServiceBase implements RemoteTaxServiceInterface {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
        'mode' => 'test',
      ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form += parent::buildConfigurationForm($form, $form_state);

    $form['mode'] = [
      '#type' => 'radios',
      '#title' => $this->t('Mode'),
      '#default_value' => $this->configuration['mode'],
      '#required' => TRUE,
      '#options' => [
        'test' => $this->t('Test'),
        'live' => $this->t('Live'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    if (empty($values['target_plugin_configuration']['mode'])) {
      $form_state->setError($form, $this->t('A value for Mode must be set.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    $this->configuration['mode'] = $values['mode'];

    parent::submitConfigurationForm($form, $form_state);
  }

  public function getMode() {
    return $this->configuration['mode'];
  }
}
