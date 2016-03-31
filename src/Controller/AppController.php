<?php

namespace Drupal\culturefeed_udb3_app\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class AppController.
 *
 * @package Drupal\culturefeed_udb3_app\Controller
 */
class AppController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The culturefeed user.
   *
   * @var \CultureFeed_User
   */
  protected $cfUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('culturefeed.current_user')
    );
  }

  /**
   * AppController constructor.
   *
   * @param \CultureFeed_User $cf_user
   *   The culturefeed user.
   */
  public function __construct(\CultureFeed_User $cf_user) {
    $this->cfUser = $cf_user;
  }

  /**
   * Show the dashboard.
   */
  public function dashboard() {

    return [
      '#theme' => 'udb3_dashboard',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
      ],
    ];

  }

  /**
   * Show the landing page or redirect to dashboard.
   */
  public function landing() {

    if (empty($this->cfUser->id)) {
      return [
        '#theme' => 'udb3_anonymous_landing',
      ];
    }
    else {
      return new RedirectResponse('/udb3/dashboard');
    }

  }

  /**
   * Function to view an event detail.
   */
  public function viewEvent($id) {

    return [
      '#theme' => 'udb3_event_view',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'eventId' => $id,
            'offerType' => 'event',
          ],
        ],
      ],
    ];

  }

  /**
   * Function to view a place detail.
   */
  public function viewPlace($id) {
    return [
      '#theme' => 'udb3_place_view',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'placeId' => $id,
            'offerType' => 'place',
          ],
        ],
      ],
    ];

  }

  /**
   * Function to view the copyright.
   */
  public function viewCopyright() {
    return [
      '#theme' => 'udb3_copyright',
    ];
  }

  /**
   * Function to view the user agreement.
   */
  public function viewUserAgreement() {
    return [
      '#theme' => 'udb3_user_agreement',
    ];
  }

  /**
   * Get the title for the landing page.
   */
  public function getLandingTitle() {
    if (!empty($this->cfUser->id)) {
      return 'Dashboard';
    }
    else {
      return '';
    }
  }

}
