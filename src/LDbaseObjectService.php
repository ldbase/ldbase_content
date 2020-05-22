<?php

namespace Drupal\ldbase_content;

/**
 * Class LDbaseObjectService.
 */
class LDbaseObjectService implements LDbaseObjectServiceInterface {

  /**
   * Constructs a new LDbaseObjectService object.
   */
  public function __construct() {
  }

  public function isUrlAnLdbaseObjectUrl($url) {
    $ldbase_objects = array('projects', 'datasets', 'code', 'documents');
    $url_bits = explode('/', $url);
    if (in_array($url_bits[1], $ldbase_objects)) {
      $answer = $url_bits[2];
    }
    else {
      $answer = FALSE;
    }
    return $answer;
  }

  public function getLdbaseObjectFromUuid($uuid) {
    $query = \Drupal::entityQuery('node')->condition('uuid', $uuid)->execute();
    $node = node_load(reset($query));
    return $node;
  }

  public function getLdbaseRootProjectNodeFromLdbaseObjectNid($nid) {
    $entity = entity_load('node', $nid);
    $bundle = $entity->bundle();
    if ($bundle == 'project') {
      $parent_project_node = node_load($nid);
    }
    else {
      $parent_nid = \Drupal::service('ldbase.object_service')->getLdbaseObjectParent($nid);
      $parent_project_node = \Drupal::service('ldbase.object_service')->getLdbaseRootProjectNodeFromLdbaseObjectNid($parent_nid);
      //$parent_project_node = node_load($parent_nid);
    }
    return $parent_project_node;
  }

  public function getLdbaseObjectParent($nid) {
    $node = node_load($nid);
    $affiliated_parents = $node->field_affiliated_parents->getValue();
    $parent_nid = $affiliated_parents[0]['target_id'];
    return $parent_nid;
  }

}
