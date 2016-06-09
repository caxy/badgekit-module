<?php

namespace Drupal\badgekit\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the badgekit module.
 */
class BadgesControllerTest extends WebTestBase {

  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "badgekit BadgesController's controller functionality",
      'description' => 'Test Unit for module badgekit and controller BadgesController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests badgekit functionality.
   */
  public function testBadgesController() {
    // Check that the basic functions of module badgekit.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
