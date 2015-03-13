<?php

/**
 * @file
 * Contains Drupal\culturefeed_udb3_app\Controller\EventFormController.
 */

namespace Drupal\culturefeed_udb3_app\Controller;

use Broadway\Repository\AggregateNotFoundException;
use CultuurNet\UDB3\EntityServiceInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
      $container->get('culturefeed_udb3.place.service')
    );
  }

  /**
   * Construct the controller.
   *
   * @param EntityServiceInterface $entityService
   *   The place service.
   */
  public function __construct(EntityServiceInterface $entityService) {
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
      throw new NotFoundHttpException();
    }
    catch (Exception $e) {
      return new Response($e->getMessage(), 400);
    }

    return [
      '#theme' => 'udb3_event_form',
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
