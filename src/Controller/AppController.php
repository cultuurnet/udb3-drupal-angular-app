<?php
/**
 * @file
 * Contains Drupal\culturefeed_udb3_app\Controller\AppController.
 */

namespace Drupal\culturefeed_udb3_app\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AppController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * @var \CultureFeed_User
   */
  protected $cf_user;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('culturefeed.current_user')
    );
  }

  public function __construct(\CultureFeed_User $cf_user) {
    $this->cf_user = $cf_user;
  }

  /**
   * Show the landing page.
   */
  public function landing() {

    if (empty($this->cf_user->id)) {
      $renderArray = [
        '#theme' => 'udb3_anonymous_landing',
      ];
    }
    else {
      $renderArray = [
        '#theme' => 'udb3_dashboard',
        '#attached' => [
          'library' => [
            'culturefeed_udb3_app/udb3-angular'
          ]
        ],
      ];
    }

    return $renderArray;

  }

  /**
   * Get the title for the landing page.
   */
  public function getLandingTitle() {
    if (!empty($this->cf_user->id)) {
      return 'Dashboard';
    }
    else {
      return '';
    }
  }

}