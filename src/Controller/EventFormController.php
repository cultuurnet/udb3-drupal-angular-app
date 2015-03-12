<?php

/**
 * @file
 * Contains Drupal\culturefeed_udb3_app\Controller\EventFormController.
 */

namespace Drupal\culturefeed_udb3_app\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the event form (add / update)
 */
class EventFormController extends ControllerBase {

  /**
   * Add an event.
   */
  public function addEvent() {
    return [
      '#theme' => 'udb3_event_form',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular'
        ]
      ]
    ];
  }

  /**
   * Edit an event.
   */
  public function editEvent($id) {
    return [
      '#theme' => 'udb3_event_form',
      '#item_id' => $id,
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular'
        ]
      ]
    ];
  }

}
