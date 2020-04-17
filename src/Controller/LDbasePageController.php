<?php

namespace Drupal\ldbase_content\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\examples\Utility\DescriptionTemplateTrait;
use Drupal\Core\Render\Markup;

/**
 * Controller routines for page example routes.
 */
class LDbasePageController extends ControllerBase {

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

  public function home() {
    return [
      '#markup' => '<p>' . $this->t('This is the front page.') . '</p>',
    ];
  }

  public function about() {
    return [
      '#markup' => '<p>' . $this->t('This is the "About" page.') . '</p>',
    ];
  }

  public function about_ldbase() {
    return [
      '#markup' => '<p>' . $this->t('This is the "About LDbase" page.') . '</p>',
    ];
  }

  public function why_share_behavioral_data() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Why Share Behavioral Data" page.') . '</p>',
    ];
  }

  public function who_might_want_to_use_ldbase() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Who Might Want To Use LDbase" page.') . '</p>',
    ];
  }

  public function ldbase_team() {
    return [
      '#markup' => '<p>' . $this->t('This is the "LDbase Team" page.') . '</p>',
    ];
  }

  public function contact() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Contact" page.') . '</p>',
    ];
  }

  public function resources() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Resources" page.') . '</p>',
    ];
  }

  public function general_user_agreement() {
    return [
      '#markup' => '<p>' . $this->t('This is the "General User Agreement" page.') . '</p>',
    ];
  }

  public function user_guide() {
    return [
      '#markup' => '<p>' . $this->t('This is the "User Guide" page.') . '</p>',
    ];
  }

  public function faq() {
    return [
      '#markup' => '<p>' . $this->t('This is the "FAQ" page.') . '</p>',
    ];
  }

  public function best_practices() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Best Practices" page.') . '</p>',
    ];
  }

  public function templates() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Templates" page.') . '</p>',
    ];
  }

  public function community() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Community" page.') . '</p>',
    ];
  }

  public function users() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Users" page.') . '</p>',
    ];
  }

  public function institutions() {
    return [
      '#markup' => '<p>' . $this->t('This is the "Institutions" page.') . '</p>',
    ];
  }

}
