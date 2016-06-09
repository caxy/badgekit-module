<?php

namespace Drupal\badgekit;

use Caxy\BadgeKit\JwtMiddleware;
use Drupal\Core\Config\ConfigFactoryInterface;

class JwtMiddlewareFactory {
  /**
   * @var ConfigFactoryInterface
   */
  private $config_factory;

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config_factory = $config_factory;
  }

  public function create() {
    return new JwtMiddleware(
      $this->config_factory->get('badgekit.settings')->get('secret')
    );
  }
}
