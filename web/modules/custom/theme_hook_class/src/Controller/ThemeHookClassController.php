<?php

namespace Drupal\theme_hook_class\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\theme_hook_class\Hook\ThemeHookClass;

class ThemeHookClassController extends ControllerBase {

  public function __construct(protected ThemeHookClass $themeHookClass) {}

  public function showProfileClass() {
    return [
      '#theme' => 'user_profile_class',
      '#username' => 'John Doe',
      '#user_role' => 'Administrator',
      '#join_date' => 'January 1, 2020',
      '#bio' => 'Passionate Drupal developer.',
    ];
  }

  public function showWelcomeClass() {
    return [
      '#theme' => 'welcome_message_class',
      '#greeting' => $this->themeHookClass->getWelcomeMessage(),
    ];
  }
}
