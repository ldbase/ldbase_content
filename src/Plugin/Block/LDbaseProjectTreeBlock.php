<?php

namespace Drupal\ldbase_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use \Drupal\Core\Link;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;

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

    $url = \Drupal::request()->getRequestUri();
    $ldbase_object_uuid = \Drupal::service('ldbase.object_service')->isUrlAnLdbaseObjectUrl($url);
    if ($ldbase_object_uuid) {
      $node = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($ldbase_object_uuid);
      $parent_project_node = \Drupal::service('ldbase.object_service')->getLdbaseRootProjectNodeFromLdbaseObjectNid($node->id());
      $tree_view = \Drupal\ldbase_content\Controller\LDbaseProjectTreeController::output_tree($parent_project_node->uuid(), $node->uuid());
      $parent_project_uuid = $parent_project_node->uuid();

      $child_nids = \Drupal::service('ldbase_handlers.publish_status_service')->getChildNids($parent_project_node->id());

      if (!empty($child_nids) && count($child_nids) > 1) {
        $url = Url::fromRoute('ldbase.sort_project_hierarchy', ['node' => $parent_project_uuid]);
        if ($url->access()) {
          $link = Link::createFromRoute(t('Change Hierarchy'), 'ldbase.sort_project_hierarchy',['node' => $parent_project_uuid]);
          $tree_view .= "<div id='change-hierarchy-link'>{$link->toString()}</div>";
        }
      }

      return [
        '#markup' => Markup::create($tree_view)
      ];
    }
    else {
      return NULL;
    }


  }

  public function getCacheMaxAge() {
    return 0;
  }

}
