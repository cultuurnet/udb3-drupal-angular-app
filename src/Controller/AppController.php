<?php
/**
 * @file
 * Contains Drupal\culturefeed_udb3_app\Controller\AppController.
 */

namespace Drupal\culturefeed_udb3_app\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
      return new RedirectResponse('/udb3/search');
    }

    return $renderArray;

  }


  /**
   * Function to view an event detail.
   */
  public function viewEvent($id) {

    return [
      '#theme' => 'udb3_event_view',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular'
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'eventId' => $id,
            'offerType' => 'event',
          ]
        ]
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
          'culturefeed_udb3_app/udb3-angular'
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'placeId' => $id,
            'offerType' => 'place',
          ]
        ]
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
    if (!empty($this->cf_user->id)) {
      return 'Dashboard';
    }
    else {
      return '';
    }
  }

}
