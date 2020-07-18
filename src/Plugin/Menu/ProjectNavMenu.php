<?php

namespace Drupal\ldbase_content\Plugin\Menu;

use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\Core\Cache\Cache;

/**
 * Gets the nid for the currently viewed node and assigns it to a
 * route parameter.
 */
class ProjectNavMenu extends MenuLinkDefault {

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
  }

  /**
   * {@inheritdoc}
   */
  public function getRouteParameters() {
    $url = \Drupal::request()->getRequestUri();
    $ldbase_object_uuid = \Drupal::service('ldbase.object_service')->isUrlAnLdbaseObjectUrl($url);
    if ($ldbase_object_uuid) {
      $node = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($ldbase_object_uuid);
      $parent_project_node = \Drupal::service('ldbase.object_service')->getLdbaseRootProjectNodeFromLdbaseObjectNid($node->id());
      return ['project_uuid' => $parent_project_node->uuid(), 'node' => $parent_project_node->id()];
    }

  }
}
