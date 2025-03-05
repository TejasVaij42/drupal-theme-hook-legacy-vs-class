<?php

namespace Drupal\theme_hook_legacy\Controller;

use Drupal\Core\Controller\ControllerBase;

class ThemeHookLegacyController extends ControllerBase {
  
  public function showProfileLegacy() {
    return [
      '#theme' => 'user_profile_legacy',
      '#username' => 'John Doe',
      '#user_role' => 'Administrator',
      '#join_date' => 'January 1, 2020',
      '#bio' => 'Passionate Drupal developer.',
    ];
  }

  public function showWelcomeLegacy() {
    // Manually loading the service since dependency injection is not available in procedural hooks.
    $date_formatter = \Drupal::service('date.formatter');

    // Get current hour.
    $hour = (int) date('H');

    if ($hour < 12) {
      $greeting = "Good morning!";
    } elseif ($hour < 18) {
      $greeting = "Good afternoon!";
    } else {
      $greeting = "Good evening!";
    }

    return [
      '#theme' => 'welcome_message_legacy',
      '#greeting' => $greeting,
    ];
  }
}
