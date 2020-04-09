<?php

namespace Drupal\ldbase_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Drupal\Core\Render\Markup;

/**
 * Controller routines for page example routes.
 */
class LDbaseContentController extends ControllerBase {

  public function about() {
    return [
      '#markup' => '<p>' . $this->t('This is the about page. Text About LDbase goes here.') . '</p>',
    ];
  }


  public function policies() {
    return [
      '#markup' => '<p>' . $this->t('This is the Policies page. Text about LDbase policies go here.') . '</p>',
    ];
  }

  public function access_denied() {
    return [
      '#markup' => '<p>' . $this->t('This is the Access Denied (403) page. Users will see it when they try to go to something they don\'t have access to.') . '</p>',
    ];
  }

  public function not_found() {
    return [
      '#markup' => '<p>' . $this->t('This is the Not Found (404) page. Users will see it when they try to go to something that doesn\'t exist.') . '</p>',
    ];
  }

}
