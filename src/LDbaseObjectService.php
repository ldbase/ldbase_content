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
    $ldbase_objects_singular = array('project', 'dataset', 'code', 'document');
    $ldbase_objects_plural = array('projects', 'datasets', 'code', 'documents');
    $url_bits = explode('/', $url);
    if (in_array($url_bits[1], $ldbase_objects_plural)) {
      $uuid = $url_bits[2];
      $object = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($uuid);
      if (is_null($object) || !in_array($object->bundle(), $ldbase_objects_singular)) {
        $answer = FALSE;
      }
      else {
        $answer = $uuid;
      }
    }
    else {
      $answer = FALSE;
    }
    return $answer;
  }

  public function getLdbaseObjectFromUuid($uuid) {
    $query = \Drupal::entityQuery('node')->condition('uuid', $uuid)->execute();
    $results = reset($query);
    if (!empty($results)) {
      $node = node_load($results);
    }
    else {
      $node = NULL;
    }
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

  public function getBreadcrumbTrailToLdbaseObject($link_data) {
    $entity = entity_load('node', $link_data[0]['nid']);
    $bundle = $entity->bundle();
    if ($bundle == 'project') {
      return $link_data;
    }
    else {
      $parent_nid = \Drupal::service('ldbase.object_service')->getLdbaseObjectParent($link_data[0]['nid']);
      $node = node_load($parent_nid);
      array_unshift($link_data, array('title' => $node->getTitle(), 'nid' => $node->id()));
      return \Drupal::service('ldbase.object_service')->getBreadcrumbTrailToLdbaseObject($link_data);
    }
  }

  public function isLdbaseCodebook($uuid) {
    $object = \Drupal::service('ldbase.object_service')->getLdbaseObjectFromUuid($uuid);
    if (is_null($object) || $object->bundle() != 'document') {
      return FALSE;
    }
    else {
      $document_type = $object->get('field_document_type')->target_id;
      $document_type_term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($document_type)->getName();
      if ($document_type_term === 'Codebook') {
        return TRUE;
      }
      else {
        return FALSE;
      }
    }
  }

}
