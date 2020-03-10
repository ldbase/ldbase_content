<?php

namespace Drupal\ldbase_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;

/**
 * Controller routines for page example routes.
 */
class LDbaseContentController extends ControllerBase {

  public function about() {
    return [
      '#markup' => '<p>' . $this->t('This is the about page. Text about LDbase goes here.') . '</p>',
    ];
  }


  public function policies() {
    return [
      '#markup' => '<p>' . $this->t('This is the policies page. Text about LDbase policies go here.') . '</p>',
    ];
  }


}
