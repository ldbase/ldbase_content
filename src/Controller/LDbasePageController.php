<?php

namespace Drupal\ldbase_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Controller routines for page example routes.
 */
class LDbasePageController extends ControllerBase {

  public function home() {
    return [
      '#markup' => '',
    ];
  }

  public function dataExports() {
    return [
      '#markup' => '',
    ];
  }

  public function browseData() {
    $browse_page = $this->entityTypeManager()
      ->getStorage('node')
      ->loadByProperties(['title' => 'Browse our Data']);
    if (!empty($browse_page)) {
      $node = $this->entityTypeManager()
        ->getViewBuilder('node')
        ->view($browse_page[1]);
      return $node;
    }
    else {
      return [
        '#markup' => '',
      ];
    }

  }

}
