<?php

declare(strict_types=1);

namespace Drupal\theme_hook_class\Hook;

use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\Datetime\DateFormatterInterface;

class ThemeHookClass {

  public function __construct(protected DateFormatterInterface $dateFormatter) {}

  #[Hook('theme')]
  public function theme(): array {
    return [
      'user_profile_class' => [
        'variables' => [
          'username' => '',
          'user_role' => '',
          'join_date' => '',
          'bio' => '',
        ],
      ],
      'welcome_message_class' => [
        'variables' => [
          'greeting' => '',
        ],
      ],
    ];
  }

  public function getWelcomeMessage(): string {
    $hour = (int) date('H');
    return $hour < 12 ? "Good morning!" : ($hour < 18 ? "Good afternoon!" : "Good evening!");
  }
}
