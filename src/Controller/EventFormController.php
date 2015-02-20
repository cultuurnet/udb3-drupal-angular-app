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

  public function addEvent() {
    return [
      '#theme' => 'udb3_event_form',
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3_angular'
        ]
      ]
    ];
  }

}
