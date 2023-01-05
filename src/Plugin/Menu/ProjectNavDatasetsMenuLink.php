<?php

namespace Drupal\ldbase_content\Plugin\Menu;

use Drupal\Core\Menu\MenuLinkDefault;
use Drupal\Core\Cache\Cache;

/**
 * Returns the node id and sets the title for the link
 */
class ProjectNavDatasetsMenuLink extends MenuLinkDefault {

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    $url = \Drupal::request()->getRequestUri();
    $ldbase_object_uuid = \Drupal::service('ldbase.object_service')->isUrlAnLdbaseObjectUrl($url);
    if ($ldbase_object_uuid) {
      $node = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($ldbase_object_uuid);
      $parent_project_node = \Drupal::service('ldbase.object_service')->getLdbaseRootProjectNodeFromLdbaseObjectNid($node->id());

      /* Retrieve all datasets for the project */
      $dataset_query = \Drupal::entityQuery('node')
        ->accessCheck(TRUE)
        ->condition('type', 'dataset')
        ->condition('field_affiliated_parents', $parent_project_node->id());
      $datasets = $dataset_query->execute();

      $count = count($datasets);
      return $this->t('View All Datasets (@count)', ['@count' => $count]);
    }
    else {
      return NULL;
    }
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

