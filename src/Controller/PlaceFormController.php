<?php

/**
 * @file
 * Contains Drupal\culturefeed_udb3_app\Controller\EventFormController.
 */

namespace Drupal\culturefeed_udb3_app\Controller;

use Broadway\Repository\AggregateNotFoundException;
use CultuurNet\UDB3\EntityServiceInterface;
use CultuurNet\UDB3\EventServiceInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for the place form (update)
 */
class PlaceFormController extends ControllerBase {

  /**
   * The place service.
   *
   * @var EntityServiceInterface
   */
  protected $entityService;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('culturefeed_udb3.event.service')
    );
  }

  /**
   * Construct the controller.
   *
   * @param EntityServiceInterface $entityService
   *   The place service.
   */
  public function __construct(EventServiceInterface $entityService) {
    $this->entityService = $entityService;
  }

  /**
   * Edit a place.
   */
  public function editPlace($id) {

    try {
      $this->entityService->getEntity($id);
    }
    catch (AggregateNotFoundException $e) {
      return new \Symfony\Component\HttpFoundation\Response('', 404);
    }
    catch (Exception $e) {
      return new Response($e->getMessage(), 400);
    }

    return [
      '#theme' => 'udb3_place_form',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular'
        ],
        'drupalSettings' => [
          'culturefeed_udb3_app' => [
            'itemId' => $id,
            'offerType' => 'place'
          ]
        ]
      ]
    ];
  }

}
