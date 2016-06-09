<?php

namespace Drupal\badgekit\Controller;

use Caxy\BadgeKit\ServiceClient;
use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserController
 * @package Drupal\badgekit\Controller
 */
class UserController extends ControllerBase {
  /**
   * @var ServiceClient
   */
  private $serviceClient;

  /**
   * UserController constructor.
   * @param ServiceClient $serviceClient
   */
  public function __construct(ServiceClient $serviceClient) {
    $this->serviceClient = $serviceClient;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('badgekit.service_client')
    );
  }

  /**
   * @param User $user
   * @return array
   */
  public function badgeInstancesAction(User $user) {
    $result = $this->serviceClient->getUserBadgeInstances([
      'email' => $user->getEmail(),
    ]);

    return array_map(function ($instance) {
      $badge = $instance['badge'];
      $output[] = [
        '#theme' => 'image',
        '#uri' =>  $badge['imageUrl'],
      ];
      $output[] = [
        '#markup' => $badge['name'],
      ];
      return $output;
    }, $result['instances']);
  }

  /**
   * @param User $user
   * @return array
   */
  public function submittedApplicationsAction(User $user) {
    $result = $this->serviceClient->getAdminApplications([
      'query' => ['email' => $user->getEmail()],
    ]);

    $rows = array_map([$this, 'prepareRow'], $result['applications']);

    return [
      '#type' => 'table',
      '#header' => [
        'learner',
        'created',
        'assignedTo',
        'assignedExpiration',
        'badge',
        'processed',
        'evidence',
      ],
      '#rows' => $rows,
    ];
  }

  /**
   * @param User $user
   * @return array
   */
  public function assignedApplicationsAction(User $user) {
    $result = $this->serviceClient->getAdminApplications([
      'query' => ['assignedTo' => $user->getEmail()],
    ]);

    $rows = array_map([$this, 'prepareRow'], $result['applications']);

    return [
      '#type' => 'table',
      '#header' => [
        'learner',
        'created',
        'assignedTo',
        'assignedExpiration',
        'badge',
        'processed',
        'evidence',
      ],
      '#rows' => $rows,
    ];
  }

  private function prepareRow($row) {
    return [
      $row['learner'],
      $row['created'],
      $row['assignedTo'],
      $row['assignedExpiration'],
      $row['badge']['slug'],
      $row['processed'],
      $row['evidence'],
    ];
  }
}