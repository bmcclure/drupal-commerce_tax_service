<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

use Drupal\commerce_price\RounderInterface;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class RemoteTaxServiceBase extends TaxServiceBase implements RemoteTaxServiceInterface {

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, RounderInterface $rounder, LoggerInterface $logger, ClientInterface $client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $rounder, $logger);

    $this->httpClient = $client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    /** @var RounderInterface $rounder */
    $rounder = $container->get('commerce_price.rounder');
    /** @var LoggerInterface $logger */
    $logger = $container->get('logger.channel.commerce_tax_service');
    /** @var ClientInterface $client */
    $client = $container->get('http_client');

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $rounder,
      $logger,
      $client
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
        'mode' => 'test',
        'log' => [],
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
      '#description' => $this->t('Choose whether to use Test or Live mode, if the selected service supports this.'),
      '#default_value' => $this->configuration['mode'],
      '#required' => TRUE,
      '#options' => [
        'test' => $this->t('Test'),
        'live' => $this->t('Live'),
      ],
    ];

    $form['log'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Log the following messages for debugging'),
      '#options' => [
        'request' => $this->t('API request messages'),
        'response' => $this->t('API response messages'),
      ],
      '#default_value' => $this->configuration['log'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    if (empty($values['mode'])) {
      $form_state->setError($form, $this->t('A value for Mode must be set.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    $this->configuration['mode'] = $values['mode'];
    $this->configuration['log'] = $values['log'];

    parent::submitConfigurationForm($form, $form_state);
  }

  public function getMode() {
    return $this->configuration['mode'];
  }
}
