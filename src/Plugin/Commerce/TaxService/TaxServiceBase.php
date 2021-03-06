<?php

namespace Drupal\commerce_tax_service\Plugin\Commerce\TaxService;

use Drupal\commerce_order\EntityAdjustableInterface;
use Drupal\commerce_order\Adjustment;
use Drupal\commerce_price\Price;
use Drupal\commerce_price\RounderInterface;
use Drupal\Core\Executable\ExecutablePluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContextAwarePluginAssignmentTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Base class for Tax Service plugins.
 */
abstract class TaxServiceBase extends ExecutablePluginBase implements TaxServiceInterface {

  use ContextAwarePluginAssignmentTrait;

  /**
   * The rounder.
   *
   * @var \Drupal\commerce_price\RounderInterface
   */
  protected $rounder;

  /**
   * Commerce Fedex Logger Channel.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Constructs a new TaxServiceBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The pluginId for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\commerce_price\RounderInterface $rounder
   *   The rounder.
   * @param LoggerInterface $logger
   *   The logger.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RounderInterface $rounder, LoggerInterface $logger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->setConfiguration($configuration);
    $this->rounder = $rounder;
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    /** @var RounderInterface $rounder */
    $rounder = $container->get('commerce_price.rounder');
    /** @var LoggerInterface $logger */
    $logger = $container->get('logger.channel.commerce_tax_service');

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $rounder,
      $logger
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'display_name' => 'Sales tax',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $contexts = $form_state->getTemporaryValue('gathered_contexts') ?: [];
    $form['context_mapping'] = $this->addContextAssignmentElement($this, $contexts);

    $form['display_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Display name'),
      '#description' => $this->t('The name to display on the order for this tax adjustment.'),
      '#default_value' => $this->configuration['display_name'],
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    if (empty($values['target_plugin_configuration']['display_name'])) {
      $form_state->setError($form, $this->t('A display name must be set.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValue($form['#parents']);

    $this->configuration['display_name'] = $values['display_name'];
  }

  public function getDisplayName() {
    return $this->configuration['display_name'];
  }

  /**
   * {@inheritdoc}
   */
  public function getTargetEntityType() {
    return $this->pluginDefinition['target_entity_type'];
  }

  /**
   * {@inheritdoc}
   */
  public function getTargetEntity() {
    return $this->getContextValue($this->getTargetEntityType());
  }

  /**
   * {@inheritdoc}
   */
  public function applyAdjustment(EntityAdjustableInterface $entity, Price $amount) {
    $entity->addAdjustment(new Adjustment([
      'type' => 'tax_service',
      // @todo Change to label from UI.
      'label' => t('Sales tax'),
      'amount' => $amount,
      'source_id' => $this->getPluginId(),
    ]));
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration() {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration) {
    $this->configuration = $configuration + $this->defaultConfiguration();
    return $this;
  }
}
