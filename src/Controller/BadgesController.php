<?php

namespace Drupal\badgekit\Controller;

use Caxy\BadgeKit\ServiceClient;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class BadgesController.
 *
 * @package Drupal\badgekit\Controller
 */
class BadgesController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function indexAction() {
    /** @var ServiceClient $client */
    $client = \Drupal::service('badgekit.service_client');

    $result = $client->getBadges();

    return array_map(function ($badge) {
      $output[] = [
        '#theme' => 'image',
        '#uri' =>  $badge['imageUrl'],
      ];
      $output[] = [
        '#markup' => $badge['name'],
      ];
      return $output;
    }, $result['badges']);
  }
}
