<?php

declare(strict_types=1);

namespace Drupal\test_tokens\Enum;

use Drupal\Component\Datetime\DateTimePlus;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Existing project versions.
 */
enum Versions: string {

  case First = 'v1';
  case Second = 'v2';
  case Third = 'v3';
  case Fourth = 'v4';
  case Fifth = 'v5';

  /**
   * Get the current version depending on the current date.
   *
   * @return self|null
   *   The version.
   */
  public static function currentVersion(): ?self {
    $current_month = DateTimePlus::createFromFormat('U', time())->format('Ymd');

    foreach (self::cases() as $version) {
      if ($version->begin() <= $current_month && ($version->end() === '' || $version->end() > $current_month)) {
        $current_version = $version;
      }
    }

    return $current_version;
  }

  /**
   * Begin date.
   *
   * @return string
   *   The first day of the version.
   */
  public function begin(): string {
    return match ($this) {
      self::First => '20240102',
      self::Second => '20240709',
      self::Third => '20250303',
      self::Fourth => '20250901',
      self::Fifth => '20260105',
    };
  }

  /**
   * End date.
   *
   * @return string
   *   The last day of the version.
   */
  public function end(): string {
    return match ($this) {
      self::First => '20240708',
      self::Second => '20250302',
      self::Third => '20250831',
      self::Fourth => '20250104',
      self::Fifth => '',
    };
  }

  /**
   * Human-readable date from begin method.
   *
   * @return string
   *   The date.
   */
  public function humanReadableBeginDate(): string {
    return \Drupal::service('date.formatter')
      ->format(
        DateTimePlus::createFromFormat(
          'Ymd',
          $this->begin()
        )->getTimestamp(),
        'custom_long_day'
      );
  }

  /**
   * Human-readable date from begin method.
   *
   * @return string
   *   The date.
   */
  public function humanReadableEndDate(): string {
    return \Drupal::service('date.formatter')
      ->format(
        DateTimePlus::createFromFormat(
          'Ymd',
          $this->end()
        )->getTimestamp(),
        'custom_long_day'
      );
  }

}
