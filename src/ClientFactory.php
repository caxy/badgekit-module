<?php

namespace Drupal\badgekit;

use Drupal\Core\Config\ConfigFactoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

/**
 * Class ClientFactory
 * @package Drupal\badgekit
 */
class ClientFactory extends \Drupal\Core\Http\ClientFactory {
  private $config_factory;

  /**
   * ClientFactory constructor.
   * @param HandlerStack $stack
   * @param ConfigFactoryInterface $config_factory
   */
  public function __construct(
    HandlerStack $stack,
    ConfigFactoryInterface $config_factory
  ) {
    parent::__construct($stack);
    $this->config_factory = $config_factory;
  }

  /**
   * @param array $config
   * @return Client
   */
  public function fromOptions(array $config = []) {
    $config['base_uri'] = $this->config_factory->get('badgekit.settings')->get(
      'url'
    );
    return parent::fromOptions($config);
  }
}
