# Advantages of Class-Based Hooks Over Legacy Procedural Hooks in Drupal

Drupal's modern class-based approach to implementing hooks offers several advantages over the legacy procedural method. Here are six key benefits that make the class-based approach superior.

## 1. Dependency Injection & Autowiring (Not Possible in Legacy)

### Class-Based Advantage:
- Allows injecting **services, configurations, and dependencies** directly into a class.
- Procedural hooks require manual service fetching using `\Drupal::service()`, which is not ideal.

#### Example: Injecting `DateFormatterInterface` (Class-Based)
```php
class ThemeHookClass {
  public function __construct(protected DateFormatterInterface $dateFormatter) {}

  #[Hook('theme')]
  public function theme(): array {
    return ['formatted_date_display' => ['variables' => ['timestamp' => 0]]];
  }

  public function getFormattedDate(int $timestamp): string {
    return $this->dateFormatter->format($timestamp, 'custom', 'Y-m-d H:i:s');
  }
}
```

✅ **Why Class-Based Wins:**
- Uses **dependency injection**, making the code more testable and reusable.
- Legacy method **relies on global state (`\Drupal::service()`)**, which is harder to test.

---

## 2. Encapsulation of Logic (Keeps Code Modular & Clean)

### Class-Based Advantage:
- **Encapsulation** groups related logic together.
- Prevents **function name collisions** and makes debugging easier.

#### Example: Centralizing Business Logic
```php
class UserProfileFormatter {
  public function formatUserRole(string $role): string {
    return ucfirst(str_replace('_', ' ', $role));
  }
}
```
Now, inject it inside the **hook class**:
```php
class ThemeHookClass {
  public function __construct(protected UserProfileFormatter $formatter) {}

  #[Hook('theme')]
  public function theme(): array {
    return ['user_profile_class' => ['variables' => ['role' => '']]];
  }

  public function getFormattedRole(string $role): string {
    return $this->formatter->formatUserRole($role);
  }
}
```

✅ **Why Class-Based Wins:**
- The **formatter is reusable** across multiple classes (controllers, services, etc.).
- Procedural code **scatters logic** and requires repetitive function calls.

---

## 3. Class Inheritance & Extensibility (Not Possible in Legacy)

### Class-Based Advantage:
- Allows extending functionality **without modifying the original class**.
- The legacy method would require copying functions manually.

#### Example: Extending a Theme Hook
```php
class AdvancedThemeHookClass extends ThemeHookClass {
  public function getAdvancedWelcomeMessage(): string {
    return parent::getWelcomeMessage() . " Enjoy your stay!";
  }
}
```

✅ **Why Class-Based Wins:**
- New features can be **added without modifying core code**.
- Legacy method would require **copy-pasting and duplicating functions**.

---

## 4. Hook Subscribers for Multiple Hooks (Cleaner & More Organized)

### Class-Based Advantage:
- Multiple hooks **can be grouped inside one class**.
- In procedural, **each hook needs its own function**.

#### Example: Handling Multiple Hooks in One Class
```php
class ThemeHookClass {
  #[Hook('theme')]
  public function theme(): array { /* Theme hook logic */ }

  #[Hook('preprocess_node')]
  public function preprocessNode(array &$variables) { /* Node preprocess logic */ }

  #[Hook('preprocess_page')]
  public function preprocessPage(array &$variables) { /* Page preprocess logic */ }
}
```

✅ **Why Class-Based Wins:**
- **Keeps all related hooks together**.
- In procedural, each hook would be a **separate function**, making it harder to track.

---

## 5. Using Traits for Code Reusability (Not Possible in Legacy)

### Class-Based Advantage:
- **Traits** allow shared logic across multiple hook classes.
- In procedural, you have to **copy-paste the same code** in multiple places.

#### Example: Shared Logic Using Traits
```php
trait DateFormatterTrait {
  public function formatDate(int $timestamp): string {
    return date('Y-m-d H:i:s', $timestamp);
  }
}

class ThemeHookClass {
  use DateFormatterTrait;

  public function getFormattedDate(int $timestamp): string {
    return $this->formatDate($timestamp);
  }
}
```

✅ **Why Class-Based Wins:**
- Code is **reusable across different hook classes**.
- Procedural **duplicates code** instead.

---

## 6. Service Decoration & Overriding Hooks (Not Possible in Legacy)

### Class-Based Advantage:
- **Overriding** hooks is easy in services.
- Legacy procedural functions **cannot be decorated**.

#### Example: Modifying a Hook Without Editing Core Code
```yaml
services:
  theme_hook_class.advanced_theme:
    decorates: theme_hook_class.hook
    class: Drupal\theme_hook_class\Hook\AdvancedThemeHookClass
```

✅ **Why Class-Based Wins:**
- You can **replace an existing hook without modifying its code**.
- Procedural hooks **require direct editing**, which is risky.

---

## 🚀 Conclusion: Why Class-Based Approach Wins
| Feature                        | Class-Based Approach ✅ | Legacy Procedural ❌ |
|--------------------------------|------------------------|----------------------|
| Dependency Injection           | ✅ Yes | ❌ No |
| Encapsulation & Modularity     | ✅ Yes | ❌ No |
| Inheritance & Extensibility    | ✅ Yes | ❌ No |
| Hook Grouping in One Class     | ✅ Yes | ❌ No |
| Code Reusability via Traits    | ✅ Yes | ❌ No |
| Service Decoration & Overriding | ✅ Yes | ❌ No |

---

## ⏭️ Final Thought
If **Drupal eventually removes procedural hooks**, class-based hooks will **already be future-proof**. This method is **cleaner, easier to maintain, and provides powerful OOP capabilities**. 🚀

