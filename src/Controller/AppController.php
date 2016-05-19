<?php

namespace Drupal\culturefeed_udb3_app\Controller;

use CultureFeed_User;
use CultuurNet\UDB3\EntityServiceInterface;
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
   * The event service.
   *
   * @var \CultuurNet\UDB3\EntityServiceInterface
   */
  protected $eventService;

  /**
   * The place service.
   *
   * @var \CultuurNet\UDB3\EntityServiceInterface
   */
  protected $placeService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('culturefeed.current_user'),
      $container->get('culturefeed_udb3.event_service'),
      $container->get('culturefeed_udb3.place_service')
    );
  }

  /**
   * AppController constructor.
   *
   * @param \CultureFeed_User $cf_user
   *   The culturefeed user.
   * @param \CultuurNet\UDB3\EntityServiceInterface $event_service
   *   The event service.
   * @param \CultuurNet\UDB3\EntityServiceInterface $place_service
   *   The place service.
   */
  public function __construct(
      CultureFeed_User $cf_user,
      EntityServiceInterface $event_service,
      EntityServiceInterface $place_service
  ) {
    $this->cfUser = $cf_user;
    $this->eventService = $event_service;
    $this->placeService = $place_service;
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

    $event = json_decode($this->eventService->getEntity($id));
    return [
      '#theme' => 'udb3_event_view',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'eventId' => $event->{'@id'},
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

    $place = json_decode($this->placeService->getEntity($id));
    return [
      '#theme' => 'udb3_place_view',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'placeId' => $place->{'@id'},
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
