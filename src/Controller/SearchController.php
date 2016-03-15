<?php

namespace Drupal\culturefeed_udb3_app\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;

/**
 * Class SearchController.
 *
 * @package Drupal\culturefeed_udb3_app\Controller
 */
class SearchController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Set the search template.
   *
   * @return array
   *   The render array.
   */
  public function search() {

    $renderArray = [
      '#theme' => 'udb3_search',
      '#content' => array('Hello', 'world'),
      '#attached' => [
        'library' => [
          'culturefeed_udb3_app/udb3-angular',
        ],
      ],
    ];

    return $renderArray;

  }

}
