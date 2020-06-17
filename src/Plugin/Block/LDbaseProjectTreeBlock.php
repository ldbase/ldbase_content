<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Render\Markup;

/**
 * Provides a "Project Tree" block.
 *
 * @Block(
 *   id="project_tree_block",
 *   admin_label = @Translation("Project Tree Block"),
 *   category = @Translation("LDbase Block")
 * )
 */
class LDbaseProjectTreeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    //$node = \Drupal::routeMatch()->getParameter('node');

    $url = \Drupal::request()->getRequestUri();
    $ldbase_object_uuid = \Drupal::service('ldbase.object_service')->isUrlAnLdbaseObjectUrl($url);
    if ($ldbase_object_uuid) {
      dd($ldbase_object_uuid);
      $node = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($ldbase_object_uuid);
      $parent_project_node = \Drupal::service('ldbase.object_service')->getLdbaseRootProjectNodeFromLdbaseObjectNid($node->id());
      $tree_view = \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::output_tree($parent_project_node->uuid(), $node->uuid());
      return $tree_view;
    }
    else {
      return NULL;
    }
 

  }

  public function getCacheMaxAge() {
    return 0;
  }

}
