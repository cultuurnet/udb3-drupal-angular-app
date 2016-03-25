<?php

namespace Drupal\culturefeed_udb3_app\Controller;

use CultuurNet\UDB3\EventNotFoundException;
use CultuurNet\UDB3\EventServiceInterface;
use CultuurNet\UDB3\UDB2\EventNotFoundException as UDB2EventNotFoundException;
use Drupal\Core\Controller\ControllerBase;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller for the event form (add / update).
 */
class EventFormController extends ControllerBase {

  /**
   * The event service.
   *
   * @var EventServiceInterface
   */
  protected $eventService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('culturefeed_udb3.event_service')
    );
  }

  /**
   * Construct the controller.
   *
   * @param EventServiceInterface $event_service
   *   The event service.
   */
  public function __construct(EventServiceInterface $event_service) {
    $this->eventService = $event_service;
  }

  /**
   * Add an event.
   */
  public function addEvent() {
    return [
      '#theme' => 'udb3_event_form',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'excludeFooter' => TRUE,
          ],
        ],
      ],
    ];
  }

  /**
   * Edit an event.
   */
  public function editEvent($id) {

    try {
      $this->eventService->getEvent($id);
    }
    catch (UDB2EventNotFoundException $e) {
      throw new NotFoundHttpException();
    }
    catch (EventNotFoundException $e) {
      throw new NotFoundHttpException();
    }
    catch (Exception $e) {
      return new Response($e->getMessage(), 400);
    }

    return [
      '#theme' => 'udb3_event_form',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'eventId' => $id,
            'offerType' => 'event',
            'excludeFooter' => TRUE,
          ],
        ],
      ],
    ];
  }

}
